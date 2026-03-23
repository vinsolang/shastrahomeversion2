<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class ContactPageTest extends TestCase
{
    public function test_the_contact_page_uses_the_dedicated_view_and_expected_content(): void
    {
        $response = $this->get(route('contact'));

        $response
            ->assertOk()
            ->assertViewIs('frontend.contact')
            ->assertSee('Get in Touch', false)
            ->assertSeeText("Let's Build Vision.")
            ->assertSee('Get a Quote', false)
            ->assertDontSee('Architectural Design and Master planning services', false)
            ->assertSee('First Name', false)
            ->assertSee('Project Type', false)
            ->assertSee('Send Message', false)
            ->assertSee('123 Construction Ave,', false)
            ->assertSee('Industrial Park, Bangalore, Lorem 560001', false)
            ->assertSee('Mon-Fri from 8am to 5pm', false)
            ->assertSee('Delivering thoughtful', false)
            ->assertSee('construction for modern living', false)
            ->assertSee('info@shastraconstruction.com', false)
            ->assertViewHas('page', function (array $page): bool {
                return ($page['view'] ?? null) === 'frontend.contact'
                    && isset($page['hero']['video'], $page['hero']['poster'], $page['form']['fields']['first_name'], $page['media'])
                    && ($page['hero']['video'] ?? null) === 'assets/videos/Main-video.mp4'
                    && ($page['hero']['poster'] ?? null) === 'assets/images/Contact/contact-hero-poster.jpg'
                    && ($page['media']['video'] ?? null) === 'assets/videos/Main-video.mp4';
            });
    }
}
