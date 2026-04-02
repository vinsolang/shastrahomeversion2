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

    // public function getEditablePageContent(string $slug): ?array
    // {
    //     if ($slug === 'home') {
    //         $site = $this->getSite();

    //         return [
    //             'hero' => $site['hero'] ?? [],
    //             'stats' => $site['stats'] ?? [],
    //         ];
    //     }

    //     return $this->getPage($slug);
    // }

public function getEditablePageContent(string $page): ?array
{
    if ($page === 'home') {
        $data = \App\Models\HomePageSetting::first();

        if (!$data) return null;

        return [
            'hero' => [
                'title' => $data->hero_title,
                'primaryCta' => [
                    'label' => $data->hero_primary_cta_label,
                ],
                'description' => $data->hero_description,
            ],
            'stats' => [
                [
                    'value' => $data->stat_1_value,
                    'label' => $data->stat_1_label,
                ],
                [
                    'value' => $data->stat_2_value,
                    'label' => $data->stat_2_label,
                ],
                [
                    'value' => $data->stat_3_value,
                    'label' => $data->stat_3_label,
                ],
            ],
        ];
    }

    // ✅ ADD THIS BACK
    return $this->getPage($page);
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
        $overrides = [];

        if (Schema::hasTable('site_settings')) {
            $overrides = SiteSetting::query()
                ->get(['key', 'value'])
                ->mapWithKeys(fn (SiteSetting $setting): array => [
                    $setting->key => is_array($setting->value) ? $setting->value : [],
                ])
                ->all();
        }

        if (Schema::hasTable('global_settings')) {
            $gs = \App\Models\GlobalSetting::first();
            if ($gs) {
                $globalOverrides = [
                    'brand' => [
                        'name' => $gs->brand_name,
                    ],
                    'contact' => [
                        'address_lines' => array_values(array_filter([$gs->contact_address_line_1, $gs->contact_address_line_2])),
                        'phones' => array_values(array_filter([$gs->contact_phone_1, $gs->contact_phone_2])),
                        'hours' => $gs->contact_hours,
                        'email' => $gs->contact_email,
                        'socials' => array_values(array_filter([
                            filled($gs->contact_social_facebook_url) ? ['label' => 'Facebook', 'icon' => 'facebook', 'href' => $gs->contact_social_facebook_url] : null,
                            filled($gs->contact_social_tiktok_url) ? ['label' => 'TikTok', 'icon' => 'tiktok', 'href' => $gs->contact_social_tiktok_url] : null,
                            filled($gs->contact_social_instagram_url) ? ['label' => 'Instagram', 'icon' => 'instagram', 'href' => $gs->contact_social_instagram_url] : null,
                            filled($gs->contact_social_telegram_url) ? ['label' => 'Telegram', 'icon' => 'telegram', 'href' => $gs->contact_social_telegram_url] : null,
                        ]))
                    ],
                    'footer' => [
                        'cta' => [
                            'headline' => $gs->footer_cta_headline,
                            'button_label' => $gs->footer_cta_button_label,
                        ],
                        'description_heading' => $gs->footer_description_heading,
                        'description' => array_values(array_filter([$gs->footer_description_paragraph_1, $gs->footer_description_paragraph_2])),
                        'team' => [
                            'image' => $gs->footer_team_image_path,
                        ],
                        'contact' => [
                            'address_lines' => array_values(array_filter([$gs->contact_address_line_1, $gs->contact_address_line_2])),
                            'phones' => array_values(array_filter([$gs->contact_phone_1, $gs->contact_phone_2])),
                            'hours' => $gs->contact_hours,
                            'email' => $gs->contact_email,
                            'socials' => array_values(array_filter([
                                filled($gs->contact_social_facebook_url) ? ['label' => 'Facebook', 'icon' => 'facebook', 'href' => $gs->contact_social_facebook_url] : null,
                                filled($gs->contact_social_tiktok_url) ? ['label' => 'TikTok', 'icon' => 'tiktok', 'href' => $gs->contact_social_tiktok_url] : null,
                                filled($gs->contact_social_instagram_url) ? ['label' => 'Instagram', 'icon' => 'instagram', 'href' => $gs->contact_social_instagram_url] : null,
                                filled($gs->contact_social_telegram_url) ? ['label' => 'Telegram', 'icon' => 'telegram', 'href' => $gs->contact_social_telegram_url] : null,
                            ]))
                        ],
                        'legal' => [
                            'copyright' => $gs->footer_legal_copyright,
                        ]
                    ]
                ];

                $overrides = array_merge($overrides, $globalOverrides);
            }
        }

        return $overrides;
    }

    private function pageOverrides(): array
    {
        $overrides = [];

        if (Schema::hasTable('contact_page_settings')) {
            $contactSetting = \App\Models\ContactPageSetting::first();
            if ($contactSetting) {
                // Map ContactPageSetting model back to the config array structure
                $overrides['contact'] = [
                    'title' => $contactSetting->page_title,
                    'description' => $contactSetting->page_description,
                    'hero' => [
                        'headline' => $contactSetting->hero_headline,
                        'poster' => $contactSetting->hero_poster_path, // Note: may need asset() or storage prefix if used
                    ],
                    'form' => [
                        'title' => $contactSetting->form_title,
                        'submit_label' => $contactSetting->form_submit_label,
                        'fields' => [
                            'project_type' => [
                                'options' => array_filter([
                                    $contactSetting->project_type_option_1,
                                    $contactSetting->project_type_option_2,
                                    $contactSetting->project_type_option_3,
                                    $contactSetting->project_type_option_4,
                                ]),
                            ],
                        ],
                    ],
                ];
            }
        }

        if (! Schema::hasTable('content_pages')) {
            return $overrides;
        }

        $contentOverrides = ContentPage::query()
            ->get(['slug', 'data'])
            ->mapWithKeys(fn (ContentPage $page): array => [
                $page->slug => is_array($page->data) ? $page->data : [],
            ])
            ->all();

        return array_merge($contentOverrides, $overrides);
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
