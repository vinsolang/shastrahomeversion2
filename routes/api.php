<?php

use App\Http\Controllers\Api\ProjectCatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', [ProjectCatalogController::class, 'projects']);
Route::get('/projects/categories', [ProjectCatalogController::class, 'categories']);
