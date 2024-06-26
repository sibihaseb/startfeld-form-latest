<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'surname',
        'firstname',
        'address',
        'zip',
        'city',
        'email',
        'country',
        'phone',
        'about_us',
        'gender',
        'current_status_other'
    ];

    /**
     * A applicant may have One EntryStatus
     *
     * @return HasOne
     */
    public function applicationStatus()
    {
        return $this->hasOne(ApplicationStatus::class, 'applicant_id');
    }

    /**
     * A applicant may have One Log Entry
     *
     * @return HasOne
     */
    public function applicationLog()
    {
        return $this->hasOne(ApplicationReviewLog::class);
    }

    /**
     * A applicant have Many Answers
     *
     * @return HasOne
     */
    public function applicantAnswer()
    {
        return $this->hasMany(answer::class);
    }

    /**
     * Generate unique key for applicants
     *
     * @return string
     *
     * @throws Exception
     */
    public static function generateUniqueKey(): string
    {
        do {
            $token = 'a' . generateRandomKey();
            $applicants = self::where('token', $token)->get();
        } while ($applicants->count() > 0);

        return $token;
    }

    public function scopeSearch($query, $applicantSearch)
    {
        return $query->when($applicantSearch, function ($query, $applicantSearch) {
            $query->whereRaw("CONCAT(firstname, ' ', surname) LIKE ?", ['%' . $applicantSearch . '%'])
                ->orWhere('email', 'like', '%' . $applicantSearch . '%');
        });
    }
}
