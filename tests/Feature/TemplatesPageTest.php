<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class TemplatesPageTest extends TestCase
{
    public function test_the_templates_page_uses_the_generic_page_view_by_default(): void
    {
        $response = $this->get(route('templates'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.page')
            ->assertDontSee('Architectural Design and Master planning services', false)
            ->assertViewHas('page', function (array $page): bool {
                return ($page['title'] ?? null) === 'Templates'
                    && ($page['description'] ?? null) === 'This page is prepared for the final templates showcase and can be expanded once the actual content direction is confirmed.'
                    && ! array_key_exists('view', $page);
            });
    }
}
