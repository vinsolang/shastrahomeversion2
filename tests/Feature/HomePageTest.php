<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class HomePageTest extends TestCase
{
    public function test_the_homepage_uses_the_marketing_view_and_expected_content(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.home')
            ->assertSee('Shastra', false)
            ->assertSee('Shastra Home', false)
            ->assertSee('Delivering thoughtful design and quality construction for modern living.', false)
            ->assertSee('Architectural Design and Master planning services', false)
            ->assertSee('Why Choose Us?', false)
            ->assertSee('PORTFOLIO', false)
            ->assertSee('Villa Prey Veng', false)
            ->assertViewHas('site', function (array $site): bool {
                return ($site['hero']['title'] ?? null) === 'Shastra Home'
                    && ($site['hero']['primaryCta']['route'] ?? null) === 'contact'
                    && isset($site['stats'][0], $site['pages']['services']['cards'][0], $site['pages']['projects']['portfolio']['projects'][0]);
            });
    }
}
