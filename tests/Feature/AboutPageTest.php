<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class AboutPageTest extends TestCase
{
    public function test_the_about_page_uses_the_dedicated_view_and_content(): void
    {
        $response = $this->get(route('about'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.about')
            ->assertSee('OUR PHILOSOPHY', false)
            ->assertDontSee('Architectural Design and Master planning services', false)
            ->assertSee('Why Choose Us?', false)
            ->assertSee('Lorem Sample Name', false)
            ->assertSee('PORTFOLIO', false)
            ->assertSee('Villa Prey Veng', false)
            ->assertViewHas('page', function (array $page): bool {
                return ($page['view'] ?? null) === 'frontend.about'
                    && isset($page['story'], $page['philosophy'], $page['core_values'], $page['founder'], $page['difference'], $page['media']);
            });
    }
}
