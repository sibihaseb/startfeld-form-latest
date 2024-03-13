<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'applicant_id',
        'value'
    ];

    protected $casts = [
        'value' => 'json'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function applicantAnswer()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function scopeFindAnswer($query, $questionId, $applicant_id)
    {
        return $query->where('question_id', $questionId)->where('applicant_id', $applicant_id);
    }
}
