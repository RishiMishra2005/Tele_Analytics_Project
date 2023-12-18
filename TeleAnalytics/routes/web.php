<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataPlanController;
use App\Http\Controllers\UserDataMappingController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('data_plan',DataPlanController::class)
    ->only(['create','store'])
    ->middleware(['auth','verified']);

Route::resource('user_data_mapping',UserDataMappingController::class)
    ->only(['dataManagement','create','store','stateAnalysis','yearAnalysis','update','delete'])
    ->middleware(['auth','verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/storePlan', [UserDataMappingController::class, 'store'])->name('user_data_mapping.store');
    Route::get('/state-analysis', [UserDataMappingController::class, 'stateAnalysis'])->name('user_data_mapping.stateAnalysis');
    Route::get('/year-analysis', [UserDataMappingController::class, 'yearAnalysis'])->name('user_data_mapping.yearAnalysis');
    Route::get('/datamanagement', [UserDataMappingController::class, 'dataManagement'])->name('user_data_mapping.dataManagement');
    Route::post('/update', [UserDataMappingController::class, 'update'])->name('user_data_mapping.update');
    Route::post('/saveDataPlan', [UserDataMappingController::class, 'saveDataPlan'])->name('user_data_mapping.saveDataPlan');
});

require __DIR__.'/auth.php';
