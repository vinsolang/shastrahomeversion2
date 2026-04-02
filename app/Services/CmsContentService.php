<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContentPage;
use App\Models\GlobalSetting;
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

    // public function updateGlobalSettings(array $values): void
    // {
    //     foreach ($this->globalSections() as $section) {
    //         $key = $section['key'] ?? null;

    //         if (! is_string($key) || ! array_key_exists($key, $values)) {
    //             continue;
    //         }

    //         SiteSetting::query()->updateOrCreate(
    //             ['key' => $key],
    //             ['value' => $values[$key]],
    //         );
    //     }
    // }

    public function updateGlobalSettings(array $sections): void
{
    $data = [
        'brand_name' => data_get($sections, 'brand.name'),

        'contact_address_line_1' => data_get($sections, 'contact.address_lines.0'),
        'contact_address_line_2' => data_get($sections, 'contact.address_lines.1'),

        'contact_phone_1' => data_get($sections, 'contact.phones.0'),
        'contact_phone_2' => data_get($sections, 'contact.phones.1'),

        'contact_hours' => data_get($sections, 'contact.hours'),
        'contact_email' => data_get($sections, 'contact.email'),

        'contact_social_facebook_url' => data_get($sections, 'contact.socials.0.href'),
        'contact_social_tiktok_url' => data_get($sections, 'contact.socials.1.href'),
        'contact_social_instagram_url' => data_get($sections, 'contact.socials.2.href'),
        'contact_social_telegram_url' => data_get($sections, 'contact.socials.3.href'),

        'footer_cta_headline' => data_get($sections, 'footer.cta.headline'),
        'footer_cta_button_label' => data_get($sections, 'footer.cta.button_label'),

        'footer_description_heading' => data_get($sections, 'footer.description_heading'),
        'footer_description_paragraph_1' => data_get($sections, 'footer.description.0'),
        'footer_description_paragraph_2' => data_get($sections, 'footer.description.1'),

        'footer_team_image_path' => data_get($sections, 'footer.team.image'),

        'footer_legal_copyright' => data_get($sections, 'footer.legal.copyright'),
    ];

    GlobalSetting::query()->updateOrCreate(
        ['id' => 1], // or your condition
        $data
    );
}

    // public function updatePage(string $slug, array $values): void
    // {
    //     if ($this->editablePage($slug) === null) {
    //         throw new InvalidArgumentException("Unsupported CMS page [{$slug}].");
    //     }

    //     ContentPage::query()->updateOrCreate(
    //         ['slug' => $slug],
    //         ['data' => $values],
    //     );
    // }
    public function updatePage(string $slug, array $values): void
    {
        if ($this->editablePage($slug) === null) {
            throw new InvalidArgumentException("Unsupported CMS page [{$slug}].");
        }

        if ($slug === 'home') {
            \App\Models\HomePageSetting::query()->updateOrCreate(
                ['id' => 1],
                [
                    'hero_title'            => data_get($values, 'hero.title'),
                    'hero_primary_cta_label'=> data_get($values, 'hero.primaryCta.label'),
                    'hero_description'      => data_get($values, 'hero.description'),
                    'stat_1_value'          => data_get($values, 'stats.0.value'),
                    'stat_1_label'          => data_get($values, 'stats.0.label'),
                    'stat_2_value'          => data_get($values, 'stats.1.value'),
                    'stat_2_label'          => data_get($values, 'stats.1.label'),
                    'stat_3_value'          => data_get($values, 'stats.2.value'),
                    'stat_3_label'          => data_get($values, 'stats.2.label'),
                ]
            );
            return;
        }
         // CONTACT (THIS IS YOUR MISSING PART)
    if ($slug === 'contact') {
        \App\Models\ContactPageSetting::updateOrCreate(
            ['id' => 1],
            [
                'page_title' => data_get($values, 'title'),
                'page_description' => data_get($values, 'description'),

                'hero_headline' => data_get($values, 'hero.headline'),
                'hero_poster_path' => data_get($values, 'hero.poster'),

                'form_title' => data_get($values, 'form.title'),
                'form_submit_label' => data_get($values, 'form.submit_label'),

                'project_type_option_1' => data_get($values, 'form.fields.project_type.options.0'),
                'project_type_option_2' => data_get($values, 'form.fields.project_type.options.1'),
                'project_type_option_3' => data_get($values, 'form.fields.project_type.options.2'),
                'project_type_option_4' => data_get($values, 'form.fields.project_type.options.3'),
            ]
        );

        return;
    }

        ContentPage::query()->updateOrCreate(
            ['slug' => $slug],
            ['data' => $values],
        );
    }
}
