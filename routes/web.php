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

/**
 * Entity Callback Routes.
 */
Route::get('/entities', [EntityController::class, 'list'])->name('listEntities');
Route::get('/create/entity', [EntityController::class, 'createForm'])->name('createEntity');
Route::post('/create/entity', [EntityController::class, 'createInstance'])->name('entityCreateInstance');
Route::get('/edit/entity/{entity_id}', [EntityController::class, 'edit'])->name('editEntity');
Route::post('/edit/entity/{entity_id}', [EntityController::class, 'updateInstance'])->name('entityUpdateInstance');
Route::get('/entity/{entity_id}/remove-logo', [EntityController::class, 'removeLogo'])->name('entityRemoveLogo');
Route::get('/entity/{entity_id}', [EntityController::class, 'show']);
Route::get('/entity/{entity_id}/print', [EntityController::class, 'print']);

/**
 * Skill Callback Routes.
 */
Route::get('/skills', [SkillController::class, 'list'])->name('listSkills');
Route::get('/create/skill', [SkillController::class, 'createForm'])->name('createSkill');
Route::post('/create/skill', [SkillController::class, 'createInstance'])->name('skillCreateInstance');
Route::get('/edit/skill/{skill_id}', [SkillController::class, 'edit'])->name('editSkill');
Route::post('/edit/skill/{skill_id}', [SkillController::class, 'updateInstance'])->name('skillUpdateInstance');
Route::get('/skill/{skill_id}/remove-logo', [SkillController::class, 'removeIcon'])->name('skillRemoveIcon');
Route::get('/skill/{skill_id}', [SkillController::class, 'show']);
Route::get('/skill-link/{skill_id}', [SkillLinkController::class, 'createLink'])->name('skillCreateLink');

/**
 * Experience Callback Routes.
 */
Route::get('/experiences', [ExperienceController::class, 'list'])->name('listExperiences');
Route::get('/create/experience', [ExperienceController::class, 'createForm'])->name('createExperience');
Route::post('/create/experience', [ExperienceController::class, 'createInstance'])->name('experienceCreateInstance');
Route::get('/edit/experience/{experience_id}', [ExperienceController::class, 'edit'])->name('editExperience');
Route::post('/edit/experience/{experience_id}/submit', [ExperienceController::class, 'updateInstance'])->name('experienceUpdateInstance');
Route::get('/edit/experience/{experience_id}/milestones', [ExperienceController::class, 'getMilestones'])->name('experienceGetMilestones');
Route::get('/experience/{experience_id}', [ExperienceController::class, 'show']);
Route::get('/experience/{experience_id}/print', [ExperienceController::class, 'print']);

/**
 * Social Media Platform Callback Routes.
 */
Route::get('/social-media-platforms', [SocialMediaPlatformController::class, 'list'])->name('listSocialMediaPlatforms');
Route::get('/create/social', [SocialMediaPlatformController::class, 'createForm'])->name('createSocial');
Route::post('/create/social', [SocialMediaPlatformController::class, 'createInstance'])->name('socialCreateInstance');
Route::get('/edit/social/{social_id}', [SocialMediaPlatformController::class, 'edit'])->name('editSocial');
Route::post('/edit/social/{social_id}/submit', [SocialMediaPlatformController::class, 'updateInstance'])->name('socialUpdateInstance');
Route::get('/social/{social_id}/remove-logo', [SocialMediaPlatformController::class, 'removeLogo'])->name('socialRemoveLogo');
Route::get('/social/{social_id}', [SocialMediaPlatformController::class, 'show']);
Route::get('/social/{social_id}/print', [SocialMediaPlatformController::class, 'print']);

/**
 * Social Media Link Callback Routes.
 */
Route::get('/create/social-link', [SocialMediaLinkController::class, 'createForm'])->name('createSocialLink');
Route::post('/create/social-link', [SocialMediaLinkController::class, 'createInstance'])->name('socialLinkCreateInstance');

/**
 * Milestone Callback Routes.
 */
Route::get('/create/milestone/{experience_id}', [MilestoneController::class, 'createForm'])->name('createMilestone');
Route::post('/create/milestone/{experience_id}/submit', [MilestoneController::class, 'createInstance'])->name('milestoneCreateInstance');
Route::get('/edit/milestone/{milestone_id}', [MilestoneController::class, 'edit'])->name('editMilestone');
Route::post('/edit/milestone/{milestone_id}/submit', [MilestoneController::class, 'updateInstance'])->name('milestoneUpdateInstance');
Route::get('/edit/milestone/{milestone_id}/remove-image', [MilestoneController::class, 'removeImage'])->name('milestoneRemoveImage');

//resumeProfileUpdate
Route::get('/resume-profile/get', [ResumeProfileController::class, 'getInstance'])->name('resumeProfileGet');
Route::get('/resume-profile/remove-cover-photo', [ResumeProfileController::class, 'removeCoverPhoto'])->name('resumeProfileRemoveCoverPhoto');
Route::post('/resume-profile/update', [ResumeProfileController::class, 'editInstance'])->name('resumeProfileUpdate');

