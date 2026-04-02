<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectCategoryResource;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectCatalogService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ProjectCatalogController extends Controller
{
    public function projects(ProjectCatalogService $projectCatalogService): AnonymousResourceCollection
    {
        return ProjectResource::collection($projectCatalogService->projects());
    }

    public function categories(ProjectCatalogService $projectCatalogService): AnonymousResourceCollection
    {
        return ProjectCategoryResource::collection($projectCatalogService->categories());
    }
}
