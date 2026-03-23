<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContentPage;
use App\Models\SiteSetting;
use InvalidArgumentException;

final class CmsContentService
{
    public function editablePages(): array
    {
        $pages = config('cms.editable_pages');

        return is_array($pages) ? $pages : [];
    }

    public function editablePage(string $slug): ?array
    {
        $pages = $this->editablePages();
        $page = $pages[$slug] ?? null;

        return is_array($page) ? $page : null;
    }

    public function globalSections(): array
    {
        $sections = config('cms.global_sections');

        return is_array($sections) ? $sections : [];
    }

    public function updateGlobalSettings(array $values): void
    {
        foreach ($this->globalSections() as $section) {
            $key = $section['key'] ?? null;

            if (! is_string($key) || ! array_key_exists($key, $values)) {
                continue;
            }

            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $values[$key]],
            );
        }
    }

    public function updatePage(string $slug, array $values): void
    {
        if ($this->editablePage($slug) === null) {
            throw new InvalidArgumentException("Unsupported CMS page [{$slug}].");
        }

        ContentPage::query()->updateOrCreate(
            ['slug' => $slug],
            ['data' => $values],
        );
    }
}
