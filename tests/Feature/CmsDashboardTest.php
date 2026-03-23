<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Services\SiteContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CmsDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_cms_login_page(): void
    {
        $this->get(route('cms.dashboard'))
            ->assertRedirect(route('cms.login'));
    }

    public function test_non_admin_users_cannot_access_the_cms_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('cms.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_users_can_update_page_content(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $payload = [
            'sections' => [
                'title' => 'Contact us',
                'description' => 'Updated by the CMS for test coverage.',
                'hero' => json_encode([
                    'eyebrow' => 'Reach Out',
                    'headline' => 'Talk With Shastra',
                    'accent' => '.',
                    'description' => 'Updated hero content.',
                    'video' => 'assets/videos/Main Video.mp4',
                    'poster' => 'assets/images/Contact/contact-hero-poster.jpg',
                ], JSON_THROW_ON_ERROR),
                'form' => json_encode([
                    'title' => 'Get a Quote',
                    'fields' => [
                        'first_name' => [
                            'label' => 'First Name',
                            'placeholder' => 'First Name',
                            'type' => 'text',
                            'autocomplete' => 'given-name',
                        ],
                        'last_name' => [
                            'label' => 'Last Name',
                            'placeholder' => 'Last Name',
                            'type' => 'text',
                            'autocomplete' => 'family-name',
                        ],
                        'email_address' => [
                            'label' => 'Email Address',
                            'placeholder' => 'Email Address',
                            'type' => 'email',
                            'autocomplete' => 'email',
                        ],
                        'project_type' => [
                            'label' => 'Project Type',
                            'placeholder' => 'Project Type',
                            'options' => [
                                'Residential Construction',
                            ],
                        ],
                        'message' => [
                            'label' => 'Message',
                            'placeholder' => 'Message',
                            'rows' => 5,
                        ],
                    ],
                    'submit_label' => 'Send Message',
                ], JSON_THROW_ON_ERROR),
                'media' => json_encode([
                    'headline_prefix' => 'Delivering thoughtful',
                    'headline_emphasis' => 'design & quality',
                    'headline_suffix' => 'construction for modern living',
                    'accent' => '.',
                    'video' => 'assets/videos/Main Video.mp4',
                ], JSON_THROW_ON_ERROR),
            ],
        ];

        $this->actingAs($admin)
            ->put(route('cms.pages.update', ['page' => 'contact']), $payload)
            ->assertRedirect(route('cms.pages.edit', ['page' => 'contact']));

        $this->assertDatabaseHas('content_pages', [
            'slug' => 'contact',
        ]);

        app()->forgetInstance(SiteContentService::class);

        $site = app(SiteContentService::class)->getSite();

        $this->assertSame('Talk With Shastra', data_get($site, 'pages.contact.hero.headline'));
    }
}
