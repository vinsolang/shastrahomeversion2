<?php

declare(strict_types=1);

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePageContentRequest;
use App\Services\CmsContentService;
use App\Services\SiteContentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageContentController extends Controller
{
    public function edit(
        string $page,
        CmsContentService $cmsContentService,
        SiteContentService $siteContentService,
    ): View {
        $definition = $cmsContentService->editablePage($page);

        if ($definition === null) {
            throw new NotFoundHttpException;
        }

        $values = $siteContentService->getEditablePageContent($page);

        if ($values === null) {
            throw new NotFoundHttpException;
        }

        $view = match ($page) {
            'home' => 'admin.cms.pages.home',
            'contact' => 'admin.cms.pages.contact',
            default => throw new NotFoundHttpException,
        };

        return view($view, [
            'pageSlug' => $page,
            'pageDefinition' => $definition,
            'cmsPages' => $cmsContentService->editablePages(),
            'values' => $values,
        ]);
    }

    public function update(
        UpdatePageContentRequest $request,
        string $page,
        CmsContentService $cmsContentService,
    ): RedirectResponse {
        $definition = $cmsContentService->editablePage($page);

        if ($definition === null) {
            throw new NotFoundHttpException;
        }

        $cmsContentService->updatePage($page, $request->validated('sections'));

        return to_route('cms.pages.edit', ['page' => $page])
            ->with('success', "{$definition['label']} content updated successfully.");
    }
}
