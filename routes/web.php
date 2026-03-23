<?php

declare(strict_types=1);

use App\Http\Controllers\Cms\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Cms\ContactSubmissionController as CmsContactSubmissionController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\GlobalSettingsController;
use App\Http\Controllers\Cms\PageContentController as CmsPageContentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\StoreContactSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/services', PageController::class)->defaults('page', 'services')->name('services');
Route::get('/about-us', PageController::class)->defaults('page', 'about')->name('about');
Route::get('/projects', PageController::class)->defaults('page', 'projects')->name('projects');
Route::get('/templates', PageController::class)->defaults('page', 'templates')->name('templates');
Route::get('/contact', PageController::class)->defaults('page', 'contact')->name('contact');
Route::post('/contact', StoreContactSubmissionController::class)
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::prefix('cms')->name('cms.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/settings/global', [GlobalSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/global', [GlobalSettingsController::class, 'update'])->name('settings.update');
        Route::get('/pages/{page}', [CmsPageContentController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [CmsPageContentController::class, 'update'])->name('pages.update');
        Route::get('/contact-submissions', [CmsContactSubmissionController::class, 'index'])->name('contact-submissions.index');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
