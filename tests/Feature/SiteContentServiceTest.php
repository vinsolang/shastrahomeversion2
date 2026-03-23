<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\SiteSetting;
use App\Services\SiteContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SiteContentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_config_backed_site_content_when_no_database_overrides_exist(): void
    {
        $site = app(SiteContentService::class)->getSite();

        $this->assertSame('Shastra Home', data_get($site, 'brand.name'));
        $this->assertSame('frontend.services', data_get($site, 'pages.services.view'));
        $this->assertSame('Get in Touch', data_get($site, 'pages.contact.hero.eyebrow'));
        $this->assertSame('Contact Us', data_get($site, 'hero.primaryCta.label'));
    }

    public function test_it_merges_database_overrides_without_breaking_the_existing_shape(): void
    {
        SiteSetting::query()->create([
            'key' => 'brand',
            'value' => [
                'name' => 'Shastra CMS Brand',
                'location' => 'Bangkok',
            ],
        ]);

        ContentPage::query()->create([
            'slug' => 'home',
            'data' => [
                'hero' => [
                    'title' => 'Built from the CMS',
                ],
                'stats' => [
                    [
                        'value' => '200+',
                        'label' => 'Projects',
                    ],
                ],
            ],
        ]);

        ContentPage::query()->create([
            'slug' => 'contact',
            'data' => [
                'title' => 'Contact through CMS',
                'hero' => [
                    'headline' => 'Speak With Our Team',
                ],
            ],
        ]);

        app()->forgetInstance(SiteContentService::class);

        $site = app(SiteContentService::class)->getSite();

        $this->assertSame('Shastra CMS Brand', data_get($site, 'brand.name'));
        $this->assertSame('Built from the CMS', data_get($site, 'hero.title'));
        $this->assertSame('200+', data_get($site, 'stats.0.value'));
        $this->assertSame('Contact through CMS', data_get($site, 'pages.contact.title'));
        $this->assertSame('Speak With Our Team', data_get($site, 'pages.contact.hero.headline'));
        $this->assertSame('frontend.contact', data_get($site, 'pages.contact.view'));
        $this->assertIsArray(data_get($site, 'pages.contact.form.fields'));
    }
}
