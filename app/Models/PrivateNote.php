<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_id',
        'step_id',
        'value',
    ];
}
