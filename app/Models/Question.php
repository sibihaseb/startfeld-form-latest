<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'step',
        'sort_order',
        'title',
        'description',
        'answer_type',
        'options',
        'is_hidden',
        'is_mandatory',
    ];

    protected $casts = [
        'title' => 'json',
        'description' => 'json',
        'options' => 'json',
    ];

    public function answerquestion()
    {
        return $this->hasOne(answer::class, 'question_id');
    }
}
