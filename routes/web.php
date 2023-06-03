<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ResumeProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SkillLinkController;
use App\Http\Controllers\SocialMediaLinkController;
use App\Http\Controllers\SocialMediaPlatformController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/**
 * Resume PDF Callback Route.
 */
Route::get('resume', [ResumeController::class, 'show']);

/**
 * Entity Callback Routes.
 */
Route::get('/create/entity', [EntityController::class, 'createForm']);
Route::post('/create/entity', [EntityController::class, 'createInstance'])->name('entityCreateInstance');
Route::get('/entity/{entity_id}', [EntityController::class, 'show']);
Route::get('/entity/{entity_id}/print', [EntityController::class, 'print']);

/**
 * Skill Callback Routes.
 */
Route::get('/create/skill', [SkillController::class, 'createForm']);
Route::post('/create/skill', [SkillController::class, 'createInstance'])->name('skillCreateInstance');
Route::get('/skill/{skill_id}', [SkillController::class, 'show']);
Route::get('/skill-link/{skill_id}', [SkillLinkController::class, 'createLink']);

/**
 * Experience Callback Routes.
 */
Route::get('/create/experience', [ExperienceController::class, 'createForm']);
Route::post('/create/experience', [ExperienceController::class, 'createInstance'])->name('experienceCreateInstance');
Route::get('/experience/{experience_id}', [ExperienceController::class, 'show']);
Route::get('/experience/{experience_id}/print', [ExperienceController::class, 'print']);

/**
 * Social Media Platform Callback Routes.
 */
Route::get('/create/social', [SocialMediaPlatformController::class, 'createForm']);
Route::post('/create/social', [SocialMediaPlatformController::class, 'createInstance'])->name('socialCreateInstance');
Route::get('/social/{social_id}', [SocialMediaPlatformController::class, 'show']);
Route::get('/social/{social_id}/print', [SocialMediaPlatformController::class, 'print']);

/**
 * Social Media Link Callback Routes.
 */
Route::get('/create/social-link', [SocialMediaLinkController::class, 'createForm']);
Route::post('/create/social-link', [SocialMediaLinkController::class, 'createInstance'])->name('socialLinkCreateInstance');

/**
 * Milestone Callback Routes.
 */
Route::get('/create/milestone', [MilestoneController::class, 'createForm']);
Route::post('/create/milestone', [MilestoneController::class, 'createInstance'])->name('milestoneCreateInstance');

//resumeProfileUpdate
Route::get('/resume-profile/get', [ResumeProfileController::class, 'getInstance'])->name('resumeProfileGet');
Route::get('/resume-profile/remove-cover-photo', [ResumeProfileController::class, 'removeCoverPhoto'])->name('resumeProfileRemoveCoverPhoto');
Route::post('/resume-profile/update', [ResumeProfileController::class, 'editInstance'])->name('resumeProfileUpdate');

