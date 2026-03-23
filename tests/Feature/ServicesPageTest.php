<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class ServicesPageTest extends TestCase
{
    public function test_the_services_page_uses_the_dedicated_view_and_content(): void
    {
        $response = $this->get(route('services'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.services')
            ->assertSee('Architectural Design and Master planning services', false)
            ->assertSee('Why Choose Us?', false)
            ->assertSee('PORTFOLIO', false)
            ->assertSee('Villa Prey Veng', false)
            ->assertViewHas('page', function (array $page): bool {
                return ($page['view'] ?? null) === 'frontend.services'
                    && isset($page['cards'][0], $page['difference'], $page['media']);
            });
    }
}
