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
    'seeds/educational-attainments' => EducationalAttainmentController::class,
    'seeds/bpo-experiences' => BpoExperienceController::class,
    'seeds/interview-types' => InterviewTypeController::class,
    'seeds/bpo-account-types' => BpoAccountTypeController::class,
    'seeds/applicant-status' => ApplicantStatusController::class,
    'seeds/applicant-tags' => ApplicantTagController::class,
    'seeds/related-bpo-work-experience' => RelatedBpoWorkExperienceController::class,
    'seeds/nationalities' => NationalitiesController::class,
    'seeds/work-experience-types' => WorkExperienceTypeController::class,
    'seeds/systemid' => SystemIdController::class,
    'seeds/reason-for-not-endorsing' => ReasonForNotEndorsingController::class

    
]);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
