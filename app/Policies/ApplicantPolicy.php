<?php

namespace App\Policies;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicantPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param  User  $user
     * @return void|bool
     */
    public function before(User $user): bool
    {
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Applicant $applicant): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Applicant $applicant, $applicantToken): bool
    {
        return $applicant->token = $applicantToken;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Applicant $applicant): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Applicant $applicant): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Applicant $applicant): bool
    {
        //
    }
}
