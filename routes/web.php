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
Route::get('resume', [ResumeController::class, 'show'])->name('resumePrint');
Route::get('resume/debug', [ResumeController::class, 'debug'])->name('resumeDebug');

/**
 * Entity Callback Routes.
 */
Route::get('/entities', [EntityController::class, 'list'])->name('entityList');
Route::get('/create/entity', [EntityController::class, 'create'])->name('entityCreate');
Route::post('/create/entity', [EntityController::class, 'store'])->name('entityStore');
Route::get('/edit/entity/{entity_id}', [EntityController::class, 'edit'])->name('entityEdit');
Route::post('/edit/entity/{entity_id}', [EntityController::class, 'update'])->name('entityUpdate');
Route::get('/entity/{entity_id}/remove-logo', [EntityController::class, 'removeLogo'])->name('entityRemoveLogo');
Route::get('/delete/entity/{entity_id}', [EntityController::class, 'delete'])->name('entityDelete');

/**
 * Skill Callback Routes.
 */
Route::get('/skills', [SkillController::class, 'list'])->name('skillList');
Route::get('/create/skill', [SkillController::class, 'create'])->name('skillCreate');
Route::post('/create/skill', [SkillController::class, 'store'])->name('skillStore');
Route::get('/edit/skill/{skill_id}', [SkillController::class, 'edit'])->name('skillEdit');
Route::post('/edit/skill/{skill_id}', [SkillController::class, 'update'])->name('skillUpdate');
Route::get('/skill/{skill_id}/remove-logo', [SkillController::class, 'removeIcon'])->name('skillRemoveIcon');
Route::get('/delete/skill/{skill_id}', [SkillController::class, 'delete'])->name('skillDelete');
Route::get('/skill-link/{skill_id}', [SkillLinkController::class, 'store'])->name('skillCreateLink');
Route::get('/delete/skill-link/{skill_id}', [SkillLinkController::class, 'delete'])->name('skillUnlink');

/**
 * Experience Callback Routes.
 */
Route::get('/experiences', [ExperienceController::class, 'list'])->name('experienceList');
Route::get('/create/experience', [ExperienceController::class, 'create'])->name('experienceCreate');
Route::post('/create/experience', [ExperienceController::class, 'store'])->name('experienceStore');
Route::get('/edit/experience/{experience_id}', [ExperienceController::class, 'edit'])->name('experienceEdit');
Route::post('/edit/experience/{experience_id}/submit', [ExperienceController::class, 'update'])->name('experienceUpdate');
Route::get('/delete/experience/{experience_id}', [ExperienceController::class, 'delete'])->name('experienceDelete');

/**
 * Social Media Platform Callback Routes.
 */
Route::get('/social-media-platforms', [SocialMediaPlatformController::class, 'list'])->name('socialPlatformList');
Route::get('/create/social', [SocialMediaPlatformController::class, 'create'])->name('socialPlatformCreate');
Route::post('/create/social', [SocialMediaPlatformController::class, 'store'])->name('socialPlatformStore');
Route::get('/edit/social/{social_id}', [SocialMediaPlatformController::class, 'edit'])->name('socialPlatformEdit');
Route::post('/edit/social/{social_id}/submit', [SocialMediaPlatformController::class, 'update'])->name('socialPlatformUpdate');
Route::get('/social/{social_id}/remove-logo', [SocialMediaPlatformController::class, 'removeLogo'])->name('socialPlatformRemoveLogo');
Route::get('/delete/social/{social_id}', [SocialMediaPlatformController::class, 'delete'])->name('socialPlatformDelete');

/**
 * Social Media Link Callback Routes.
 */
Route::get('/create/social-link', [SocialMediaLinkController::class, 'create'])->name('socialLinkCreate');
Route::post('/create/social-link', [SocialMediaLinkController::class, 'store'])->name('socialLinkUpdate');
Route::get('/delete/social-link/{social_id}', [SocialMediaLinkController::class, 'delete'])->name('socialLinkDelete');

/**
 * Milestone Callback Routes.
 */
Route::get('/create/milestone/{experience_id}', [MilestoneController::class, 'create'])->name('milestoneCreate');
Route::post('/create/milestone/{experience_id}/submit', [MilestoneController::class, 'store'])->name('milestoneStore');
Route::get('/edit/milestone/{milestone_id}', [MilestoneController::class, 'edit'])->name('milestoneEdit');
Route::post('/edit/milestone/{milestone_id}/submit', [MilestoneController::class, 'update'])->name('milestoneUpdate');
Route::get('/edit/milestone/{milestone_id}/remove-image', [MilestoneController::class, 'removeImage'])->name('milestoneRemoveImage');
Route::get('/delete/milestone/{milestone_id}', [MilestoneController::class, 'delete'])->name('milestoneDelete');

/**
 * Resume Profile Routes.
 */
Route::get('/resume-profile/get', [ResumeProfileController::class, 'edit'])->name('resumeProfileEdit');
Route::get('/resume-profile/remove-cover-photo', [ResumeProfileController::class, 'removeCoverPhoto'])->name('resumeProfileRemoveCoverPhoto');
Route::post('/resume-profile/update', [ResumeProfileController::class, 'update'])->name('resumeProfileUpdate');
