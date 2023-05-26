<?php

use App\Http\Controllers\BenefitController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
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

Route::name('guests.')->group(function () {
    Route::get('/', fn () => view('welcome'))->name('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Industry
    Route::get('/industries', IndustryController::class)->name('industries');

    // Benefit
    Route::get('/benefits', BenefitController::class)->name('benefits');

    // Company
    Route::get('/companies/list', [CompanyController::class, 'list'])->name('companies.list');
    Route::delete('/companies/destroy/image', [CompanyController::class, 'destroyImage'])->name('companies.destroy_image');
    Route::resource('companies', CompanyController::class);

    // Location
    Route::get('/location/{id}', [LocationController::class, 'get'])->name('locations.get');

    // Admin
    Route::group([
        'middleware' => 'admin',
        'as' => 'admin.',
        'prefix' => 'admin'
    ], function () {
        Route::get('/companies/list', [AdminCompanyController::class, 'list'])->name('companies.list');
        Route::get('/companies/create', [AdminCompanyController::class, 'create'])->name('companies.create');
        Route::get('/companies/{company}/edit', [AdminCompanyController::class, 'edit'])->name('companies.edit');
    });
});


require __DIR__.'/auth.php';
