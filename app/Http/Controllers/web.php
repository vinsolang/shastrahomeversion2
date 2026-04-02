<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicMediaController;
use App\Http\Controllers\admin\WhyController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\admin\PageContentController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\HistoryController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AboutBackendController;
use App\Http\Controllers\admin\GlobalSettingsController;
use App\Http\Controllers\admin\ProductBackendController;
use App\Http\Controllers\admin\ProjectBackendController;
use App\Http\Controllers\admin\UploadController;

Route::get('/google/auth', [GoogleAuthController::class, 'auth']);
Route::get('/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/media/public/{path}', [PublicMediaController::class, 'show'])
    ->where('path', '.*')
    ->name('public.media.show');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings/global', [GlobalSettingsController::class, 'edit'])->name('cms.settings.edit');
    Route::put('/settings/global', [GlobalSettingsController::class, 'update'])->name('cms.settings.update');
    Route::get('/pages/{page}', [PageContentController::class, 'edit'])
        ->whereIn('page', ['home', 'contact'])
        ->name('cms.pages.edit');
    Route::put('/pages/{page}', [PageContentController::class, 'update'])
        ->whereIn('page', ['home', 'contact'])
        ->name('cms.pages.update');

    Route::resource('banner', BannerController::class)->only(['index', 'edit', 'update']);

    Route::resource('category', CategoryController::class)->except(['destroy', 'show']);
    Route::get('category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::resource('about', AboutBackendController::class)->except(['destroy', 'show']);
    Route::resource('why', WhyController::class)->except(['destroy', 'show']);
    
    Route::resource('projects', ProjectBackendController::class)
        ->parameters(['projects' => 'project_backend'])
        ->names([
            'index' => 'project_backend.index',
            'create' => 'project_backend.create',
            'store' => 'project_backend.store',
            'edit' => 'project_backend.edit',
            'update' => 'project_backend.update',
        ])
        ->except(['destroy', 'show']);
    Route::get('projects/delete/{project_backend}', [ProjectBackendController::class, 'delete'])->name('project_backend.delete');
  
});

require __DIR__.'/auth.php';

//   Route::resource('history', HistoryController::class)->except(['destroy', 'show']);





//     // our client
//     Route::resource('client', ClientController::class)->except(['destroy', 'show']);
//     Route::post('/client/reorder', [ClientController::class, 'reorder'])->name('client.reorder');
//     Route::get('client/delete/{id}', [ClientController::class, 'delete'])->name('client.delete');
