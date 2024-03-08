<?php

use App\Http\Controllers\ApplicantStatusController;
use App\Http\Controllers\ApplicantTagController;
use App\Http\Controllers\BpoAccountTypeController;
use App\Http\Controllers\BpoExperienceController;
use App\Http\Controllers\EducationalAttainmentController;
use App\Http\Controllers\InterviewTypeController;
use App\Http\Controllers\NationalitiesController;
use App\Http\Controllers\ReasonForNotEndorsingController;
use App\Http\Controllers\RelatedBpoWorkExperienceController;
use App\Http\Controllers\SystemIdController;
use App\Http\Controllers\WorkExperienceTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::apiResources([
    'records/educational-attainments' => EducationalAttainmentController::class,
    'records/bpo-experiences' => BpoExperienceController::class,
    'records/interview-types' => InterviewTypeController::class,
    'records/bpo-account-types' => BpoAccountTypeController::class,
    'records/applicant-status' => ApplicantStatusController::class,
    'records/applicant-tags' => ApplicantTagController::class,
    'records/related-bpo-work-experience' => RelatedBpoWorkExperienceController::class,
    'records/nationalities' => NationalitiesController::class,
    'records/work-experience-types' => WorkExperienceTypeController::class,
    'records/systemid' => SystemIdController::class,
    'records/reason-for-not-endorsing' => ReasonForNotEndorsingController::class

    
]);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
