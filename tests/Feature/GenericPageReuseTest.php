<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class GenericPageReuseTest extends TestCase
{
    public function test_generic_pages_can_render_shared_reusable_sections_when_configured(): void
    {
        config()->set('site.pages.templates.cards', [
            [
                'icon' => 'assets/images/Services/Services-logo-1.svg',
                'icon_tone' => 'dark-source',
                'title' => 'Architectural Design and Master planning services',
                'description' => 'We provide comprehensive architectural design and master planning services that transform ideas into functional, aesthetic, and sustainable spaces.',
                'cta_label' => 'Read More',
            ],
        ]);

        config()->set('site.pages.templates.difference', [
            'eyebrow' => 'Shared Difference',
            'title' => 'Why Choose Us?',
            'paragraphs' => [
                'Reusable difference copy for templates.',
            ],
            'image' => 'assets/images/Services/Services-img.png',
        ]);

        config()->set('site.pages.templates.media', [
            'headline_prefix' => 'Delivering thoughtful',
            'headline_emphasis' => 'design & quality',
            'headline_suffix' => 'construction for modern living',
            'accent' => '.',
            'video' => 'assets/videos/Main Video.mp4',
        ]);

        config()->set('site.pages.templates.portfolio', config('site.pages.projects.portfolio'));

        $response = $this->get(route('templates'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.page')
            ->assertSee('Architectural Design and Master planning services', false)
            ->assertSee('Why Choose Us?', false)
            ->assertSee('Delivering thoughtful', false)
            ->assertSee('PORTFOLIO', false)
            ->assertSee('Villa Prey Veng', false);
    }
}
