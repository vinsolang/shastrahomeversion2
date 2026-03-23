<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Services\CmsContentService;
use App\Services\SiteContentService;
use Illuminate\Contracts\View\View;

final class DashboardController extends Controller
{
    public function __invoke(
        CmsContentService $cmsContentService,
        SiteContentService $siteContentService,
    ): View {
        return view('cms.dashboard', [
            'editablePages' => $cmsContentService->editablePages(),
            'site' => $siteContentService->getSite(),
            'submissionCount' => ContactSubmission::query()->count(),
        ]);
    }
}
