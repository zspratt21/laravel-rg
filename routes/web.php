<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ResumeController;
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
Route::get('resume/{user_id}', [ResumeController::class, 'show']);

/**
 * Entity Callback Routes.
 */
Route::get('/entity/create', [EntityController::class, 'createForm']);
Route::post('/entity/create', [EntityController::class, 'createInstance'])->name('entityCreateInstance');
Route::get('/entity/{entity_id}', [EntityController::class, 'show']);
Route::get('/entity/{entity_id}/print', [EntityController::class, 'print']);

/**
 * Experience Callback Routes.
 */
Route::get('/experience/create', [ExperienceController::class, 'createForm']);
Route::post('/experience/create', [ExperienceController::class, 'createInstance'])->name('experienceCreateInstance');
Route::get('/experience/{experience_id}', [ExperienceController::class, 'show']);
Route::get('/experience/{experience_id}/print', [ExperienceController::class, 'print']);
