<?php

namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use App\Models\User;
use App\Models\answer;
use App\Models\Question;
use App\Models\Applicant;
use App\Models\PrivateNote;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ApplicationStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\ApplicationReviewLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationSubmittedMail;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\PrivateNoteResource;
use App\Mail\AdminApplicationNotificationMail;

class WizardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Applicant $applicant)
    {
        $questions = Question::when($applicant, function ($query, $applicant) {
            $query->with(['answerquestion' => function ($query) use ($applicant) {
                $query->where('applicant_id', $applicant->id);
            }]);
        })->get();

        return QuestionResource::collection($questions);
    }

    /**
     * Display a listing of the resource.
     */
    public function loadAdminNotes(Applicant $applicant)
    {
        $questions = PrivateNote::where('applicant_id', $applicant->id)->get();

        return PrivateNoteResource::collection($questions);
    }

    public function store(Request $request, Applicant $applicant): JsonResponse
    {
        $flag = $request->flag;
        $answerInput = json_decode($request->answers, true);
        $noteInput = json_decode($request->adminNotes, true);
        $AnswerChanged = false;

        foreach ($answerInput as $answer) {
            $answer['applicant_id'] = $applicant->id;
            if (array_key_exists('other', $answer)) {
                $answerValueWithOther = array('value' => $answer['value'], 'other' => $answer['other']);
                $answer['value'] = json_encode($answerValueWithOther);
                unset($answer['other']);
            }
            $SavedAnswer = answer::updateOrCreate(
                ['applicant_id' => $applicant->id, 'question_id' => $answer['question_id']],
                ['value' => $answer['value']]
            );
            if ($SavedAnswer->wasChanged()) {
                $AnswerChanged = true;
            }
        }

        if ($AnswerChanged && auth()->user()) {
            $ApplicationReviewLog = [
                'user_id' => auth()->user()->id,
                'applicant_id' => $applicant->id,
                'edit_date' => Carbon::now()
            ];
            ApplicationReviewLog::create($ApplicationReviewLog);
        }
        if ($noteInput) {
            foreach ($noteInput as $note) {
                PrivateNote::updateOrCreate(['applicant_id' => $applicant->id, 'step_id' => $note['step_id']], ['value' => $note['value']]);
            }
        }

        if ($flag === "submitted") {
            ApplicationStatus::create(['applicant_id' => $applicant->id, 'status' => 'submitted']);
            Mail::to($applicant->email)->queue(new ApplicationSubmittedMail($applicant->firstname.' '.$applicant->surname));
            $users = User::where('notification', 1)->select()->get();
            if ($users) {
                foreach ($users as $user) {
                    Mail::to($user->email)->queue(new AdminApplicationNotificationMail($user->firstname.' '.$user->lastname, $applicant->token));
                }
            }
        }
        return $this->successMessageResponse('Answers Saved', 200);
    }

    public function storeFiles(Request $request, Applicant $applicant)
    {
        $files = $request->all();
        if (!Storage::exists('public/' . $applicant->token)) {
            Storage::makeDirectory('public/' . $applicant->token);
        }
        $response = array();
        foreach ($files as $key => $file) {
            $ext = $file->getClientOriginalExtension();
            $filename = 'Answer' . $key . '.' . $ext;
            $oldFile = answer::FindAnswer($key, $applicant->id)->first();
            if ($oldFile) {
                Storage::delete('public/' . json_decode($oldFile->value));
            }
            $path = $file->storePubliclyAs('public/' . $applicant->token, $filename);
            $answer = [
                'question_id' => $key,
                'value' => trim($path, "public/"),
                'applicant_id' => $applicant->id
            ];

            answer::updateOrCreate(
                ['applicant_id' => $applicant->id, 'question_id' => $answer['question_id']],
                ['value' => $answer['value']]
            );
            $response[] = [
                'question_id' => $answer['question_id'],
                'value' => $answer['value']
            ];
        }
        return response()
            ->json(
                $response
            );
    }

    public function downloadFormPdf(Applicant $applicant)
    {
        $questionsAnswers = Question::when($applicant, function ($query, $applicant) {
            $query->with(['answerquestion' => function ($query) use ($applicant) {
                $query->where('applicant_id', $applicant->id);
            }]);
        })->get();

        $questions = QuestionResource::collection($questionsAnswers);

        $applicantWithStatus = Applicant::whereId($applicant->id)->with('applicationStatus')->get();

        $pdf = PDF::setOption(['isHtml5ParserEnabled', true])
            ->setOption(['isFontSubsettingEnabled', true])
            ->setOption(['enable_php', true])
            ->setOption(['isJavascriptEnabled', true])
            ->loadView('pdf/applicantform', ['questions' => $questions, 'applicant' => $applicantWithStatus]);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }
}
