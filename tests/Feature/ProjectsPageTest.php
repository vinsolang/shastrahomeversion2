<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class ProjectsPageTest extends TestCase
{
    public function test_the_projects_page_uses_the_dedicated_view_and_gallery_content(): void
    {
        $response = $this->get(route('projects'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.projects')
            ->assertSee('PORTFOLIO', false)
            ->assertDontSee('Architectural Design and Master planning services', false)
            ->assertSee('Renovation', false)
            ->assertSee('Construction', false)
            ->assertSee('Architectural design', false)
            ->assertSee('Interior', false)
            ->assertSee('Villa Prey Veng', false)
            ->assertSee('Skyline Pavilion', false)
            ->assertSee('Shastra Home 01_View 01.jpg', false)
            ->assertViewHas('page', function (array $page): bool {
                return ($page['view'] ?? null) === 'frontend.projects'
                    && isset($page['portfolio']['tabs'][0], $page['portfolio']['projects'][0]['gallery'][0])
                    && ($page['portfolio']['projects'][0]['cover_image'] ?? null) === 'assets/images/Projects/home (1)/Shastra Home 01_View 01.jpg';
            });
    }
}
