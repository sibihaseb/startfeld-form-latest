<?php

namespace App\Http\Resources;

use App\Models\answer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'step' => $this->step,
            'sort_order' => $this->sort_order,
            'title' => $this->title,
            'description' => $this->description,
            'answer_type' => $this->answer_type,
            'options' => $this->options,
            'answer' => new AnswerResource($this->whenLoaded('answerquestion')),
            'is_hidden' => $this->is_hidden ? true : false,
            'is_mandatory' => $this->is_mandatory,
        ];
    }
}
