<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'surname' => $this->surname,
            'firstname' => $this->firstname,
            'address' => $this->address,
            'zip' => $this->zip,
            'city' => $this->city,
            'email' => $this->email,
            'country' => $this->country,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'about_us' => $this->about_us,
            'current_status_other' => $this->current_status_other,
            'applicant_status' => new ApplicationStatusResource($this->whenLoaded('applicationStatus')),
            'applicant_answer' => AnswerResource::collection($this->whenLoaded('applicantAnswer')),
        ];
    }
}
