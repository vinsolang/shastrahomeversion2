<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SiteContentService;
use Illuminate\Contracts\View\View;

final class HomeController extends Controller
{
    public function __invoke(SiteContentService $siteContentService): View
    {
        return view('frontend.home', [
            'site' => $siteContentService->getSite(),
        ]);
    }
}
