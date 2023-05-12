<?php

use App\Http\Controllers\BenefitController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/industries', IndustryController::class)->name('industries');
    Route::get('/benefits', BenefitController::class)->name('benefits');

    Route::get('/companies/list', [CompanyController::class, 'list'])->name('companies.list');
    Route::resource('companies', CompanyController::class);

    Route::resource('locations', LocationController::class);
    Route::get('/location/{id}', [LocationController::class, 'get'])->name('locations.get');
});

require __DIR__.'/auth.php';
