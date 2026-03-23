<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContentPage;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

final class SiteContentService
{
    private ?array $resolvedSite = null;

    public function getSite(): array
    {
        if ($this->resolvedSite !== null) {
            return $this->resolvedSite;
        }

        $site = config('site');

        if (! is_array($site)) {
            return $this->resolvedSite = [];
        }

        foreach ($this->globalOverrides() as $key => $value) {
            $default = $site[$key] ?? [];
            $site[$key] = $this->mergeValue($default, $value);
        }

        $pageOverrides = $this->pageOverrides();
        $homeOverrides = $pageOverrides['home'] ?? [];

        if (is_array($homeOverrides)) {
            foreach ($homeOverrides as $key => $value) {
                $default = $site[$key] ?? [];
                $site[$key] = $this->mergeValue($default, $value);
            }
        }

        unset($pageOverrides['home']);

        foreach ($pageOverrides as $slug => $value) {
            $defaultPage = data_get($site, "pages.{$slug}");

            if (! is_array($defaultPage) || ! is_array($value)) {
                continue;
            }

            data_set($site, "pages.{$slug}", $this->mergeValue($defaultPage, $value));
        }

        return $this->resolvedSite = $site;
    }

    public function getPage(string $slug): ?array
    {
        $page = data_get($this->getSite(), "pages.{$slug}");

        return is_array($page) ? $page : null;
    }

    public function getEditablePageContent(string $slug): ?array
    {
        if ($slug === 'home') {
            $site = $this->getSite();

            return [
                'hero' => $site['hero'] ?? [],
                'stats' => $site['stats'] ?? [],
            ];
        }

        return $this->getPage($slug);
    }

    public function getGlobalContent(): array
    {
        $site = $this->getSite();

        return [
            'brand' => $site['brand'] ?? [],
            'navigation' => $site['navigation'] ?? [],
            'contact' => $site['contact'] ?? [],
            'footer' => $site['footer'] ?? [],
        ];
    }

    private function globalOverrides(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        return SiteSetting::query()
            ->get(['key', 'value'])
            ->mapWithKeys(fn (SiteSetting $setting): array => [
                $setting->key => is_array($setting->value) ? $setting->value : [],
            ])
            ->all();
    }

    private function pageOverrides(): array
    {
        if (! Schema::hasTable('content_pages')) {
            return [];
        }

        return ContentPage::query()
            ->get(['slug', 'data'])
            ->mapWithKeys(fn (ContentPage $page): array => [
                $page->slug => is_array($page->data) ? $page->data : [],
            ])
            ->all();
    }

    private function mergeValue(mixed $default, mixed $override): mixed
    {
        if (! is_array($default) || ! is_array($override)) {
            return $override;
        }

        if (array_is_list($default) || array_is_list($override)) {
            return $override;
        }

        $merged = $default;

        foreach ($override as $key => $value) {
            $merged[$key] = array_key_exists($key, $merged)
                ? $this->mergeValue($merged[$key], $value)
                : $value;
        }

        return $merged;
    }
}
