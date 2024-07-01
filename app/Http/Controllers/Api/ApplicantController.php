<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicantRequest;
use App\Http\Resources\ApplicantResource;
use App\Http\Resources\ApplicationStatusResource;
use App\Mail\ApplicantRegisterMail;
use App\Models\Applicant;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicantRequest $request)
    {
        $input = $request->validated();

        $input['token'] = Applicant::generateUniqueKey();

        $applicant = Applicant::create($input);

        if ($applicant) {
            Mail::to($applicant->email)->send(new ApplicantRegisterMail($applicant->token, $applicant->firstname . ' ' . $applicant->surname));
        }

        ApplicationStatus::create([
            'applicant_id' => $applicant->id,
            'status' => 'started'
        ]);

        return $this->successResponse(
            new ApplicantResource($applicant),
            true
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        $this->authorize('view', [Applicant::class, $applicant]);
        return $this->successResponse(
            new ApplicantResource($applicant)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplicantRequest $request, Applicant $applicant)
    {
        $input = $request->validated();
        $this->authorize('update', [Applicant::class, $applicant, $input['token']]);
        if (isset($input['current_status'])) {
            if ($input['current_status'] !== 'other') {
                $input['current_status_other'] = null;
            }
        }
        $applicant->update($input);

        return $this->successResponse(
            new ApplicantResource($applicant)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function applicationStatus(Applicant $applicant)
    {
        $applicationStatus = ApplicationStatus::where('applicant_id', $applicant->id)->orderBy('created_at', 'DESC')->first();

        return $this->successResponse(
            new ApplicationStatusResource($applicationStatus)
        );
    }
}
