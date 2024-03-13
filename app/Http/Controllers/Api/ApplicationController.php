<?php

namespace App\Http\Controllers\Api;

use App\Models\answer;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\ApplicationStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationApprovedMail;
use App\Mail\ApplicationRejectedMail;
use App\Http\Resources\ApplicantResource;
use App\Http\Resources\ApplicationStatusResource;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {

        $applicants = Applicant::Search($request->Search)->with(['applicationStatus' => function ($query) {
            $query->orderBy('created_at', 'DESC');
        }])->with(['applicantAnswer' => function ($query) {
            $query->orderBy('question_id', 'ASC');
        }])->paginate($request->pageSize);

        return ApplicantResource::collection($applicants);
    }

    public function approval(Request $request, Applicant $applicant): JsonResponse
    {
        $input = $request->flag;
        $applicationStatus = ApplicationStatus::create(['applicant_id' => $applicant->id, 'status' => $input]);

        if($input === "accepted" && $applicant)
        {
            Mail::to($applicant->email)->queue(new ApplicationApprovedMail($applicant->firstname.' '.$applicant->surname));
        }
        elseif($input === "rejected" && $applicant)
        {
            Mail::to($applicant->email)->queue(new ApplicationRejectedMail($applicant->firstname . ' ' . $applicant->surname));
        }

        return $this->successResponse(
            new ApplicationStatusResource($applicationStatus),
            true
        );
    }

    public function destroy(Applicant $applicant): JsonResponse
    {
        DB::transaction(function () use ($applicant) {
            answer::where('applicant_id', $applicant->id)->delete();
            $applicantData = Applicant::findOrFail($applicant->id);
            $applicantData->delete();
        });

        return $this->deleteResponse();
    }
}
