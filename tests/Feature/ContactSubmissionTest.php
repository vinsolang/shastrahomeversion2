<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_valid_contact_submission_is_stored(): void
    {
        $response = $this->post(route('contact.store'), [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_address' => 'jane@example.com',
            'project_type' => 'Residential Construction',
            'message' => 'We are planning a new build and would like to discuss the scope and budget.',
        ]);

        $response
            ->assertRedirect(route('contact'))
            ->assertSessionHas('contact_form_status');

        $this->assertDatabaseHas('contact_submissions', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email_address' => 'jane@example.com',
            'project_type' => 'Residential Construction',
        ]);
    }

    public function test_an_invalid_contact_submission_returns_validation_errors(): void
    {
        $response = $this->from(route('contact'))->post(route('contact.store'), [
            'first_name' => '',
            'last_name' => '',
            'email_address' => 'not-an-email',
            'project_type' => '',
            'message' => 'Too short',
        ]);

        $response
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors([
                'first_name',
                'last_name',
                'email_address',
                'project_type',
                'message',
            ]);

        $this->assertDatabaseCount('contact_submissions', 0);
    }
}
