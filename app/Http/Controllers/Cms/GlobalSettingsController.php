<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\UpdateGlobalSettingsRequest;
use App\Services\CmsContentService;
use App\Services\SiteContentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class GlobalSettingsController extends Controller
{
    public function edit(
        CmsContentService $cmsContentService,
        SiteContentService $siteContentService,
    ): View {
        $content = $siteContentService->getGlobalContent();

        return view('cms.settings.edit', [
            'sections' => $cmsContentService->globalSections(),
            'values' => $this->formatValues($cmsContentService->globalSections(), $content),
        ]);
    }

    public function update(
        UpdateGlobalSettingsRequest $request,
        CmsContentService $cmsContentService,
    ): RedirectResponse {
        $cmsContentService->updateGlobalSettings(
            $this->decodeValues(
                $cmsContentService->globalSections(),
                $request->validated('sections'),
            ),
        );

        return to_route('cms.settings.edit')->with(
            'cms_status',
            'Global settings updated.',
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
