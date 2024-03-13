<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationReviewLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_id',
        'edit_date'
    ];

    public function application()
    {
        return $this->belongsTo(Applicant::class);
    }
}
