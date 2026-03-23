<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SiteContentService;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageController extends Controller
{
    public function __invoke(string $page, SiteContentService $siteContentService): View
    {
        $site = $siteContentService->getSite();
        $pageConfig = $siteContentService->getPage($page);

        if (! is_array($pageConfig)) {
            throw new NotFoundHttpException;
        }

        $view = data_get($pageConfig, 'view', 'frontend.page');

        if (! is_string($view) || $view === '') {
            $view = 'frontend.page';
        }

        return view($view, [
            'site' => $site,
            'page' => $pageConfig,
        ]);
    }
}
