<?php

use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WizardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'localize'], function () {

    Route::group(['middleware' => 'auth:sanctum'], function () {
        //get Authenticated User
        Route::get('me', [UserController::class, 'getAuthUser']);

        //update user notification
        Route::post('user/{user}/notification', [UserController::class, 'updateNotification']);
        //All applicants And Forms
        Route::get('applicants', [ApplicationController::class, 'index']);
        //Applicantion Delete
        Route::delete('application/{token}/destroy', [ApplicationController::class, 'destroy']);
        //Application Status Update
        Route::post('application/{token}/approve', [ApplicationController::class, 'approval']);
        //Download form of applicants
        Route::get('download/{token}/form', [WizardController::class, 'downloadFormPdf']);
        //SuperAdmin Routes and UserManagement
        Route::apiResource('users', UserController::class)->middleware('superadmin');
        //Crud Questions
        Route::apiResource('questions', QuestionController::class)->middleware('superadmin');
    });
    //loading all question for wizard
    Route::get('loadwizard/{token?}', [WizardController::class, 'index']);
    //loading all notes for admin
    Route::get('loadNotes/{token}', [WizardController::class, 'loadAdminNotes']);
    //creating applicant
    Route::post('createapplicant', [ApplicantController::class, 'store'])->name('applicants.store');
    //load applicant Profile
    Route::get('applicant/{token}', [ApplicantController::class, 'show']);
    //update applicant
    Route::post('applicant/{token}/update', [ApplicantController::class, 'update'])->name('applicants.update');
    //save answers
    Route::post('save/{token}/answers', [WizardController::class, 'store']);
    //save answer files
    Route::post('save/{token}/files', [WizardController::class, 'storeFiles']);
    // All Application Status
    Route::get('loadApplicationStatus/{token}', [ApplicantController::class, 'applicationStatus']);
});
