<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\UpdatePageContentRequest;
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

        $content = $siteContentService->getEditablePageContent($page);

        if ($content === null) {
            throw new NotFoundHttpException;
        }

        return view('cms.pages.edit', [
            'pageSlug' => $page,
            'pageDefinition' => $definition,
            'values' => $this->formatValues($definition['sections'] ?? [], $content),
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

        $cmsContentService->updatePage(
            $page,
            $this->decodeValues(
                $definition['sections'] ?? [],
                $request->validated('sections'),
            ),
        );

        return to_route('cms.pages.edit', ['page' => $page])->with(
            'cms_status',
            "{$definition['label']} content updated.",
        );
    }

    private function formatValues(array $sections, array $content): array
    {
        $values = [];

        foreach ($sections as $section) {
            $key = $section['key'] ?? null;
            $type = $section['type'] ?? null;

            if (! is_string($key) || ! is_string($type)) {
                continue;
            }

            $value = $content[$key] ?? null;

            $values[$key] = match ($type) {
                'json' => json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                default => is_scalar($value) ? (string) $value : '',
            };
        }

        return $values;
    }

    private function decodeValues(array $sections, array $payload): array
    {
        $decoded = [];

        foreach ($sections as $section) {
            $key = $section['key'] ?? null;
            $type = $section['type'] ?? null;

            if (! is_string($key) || ! is_string($type) || ! array_key_exists($key, $payload)) {
                continue;
            }

            $decoded[$key] = match ($type) {
                'json' => json_decode($payload[$key], true, 512, JSON_THROW_ON_ERROR),
                default => trim((string) $payload[$key]),
            };
        }

        return $decoded;
    }
}
