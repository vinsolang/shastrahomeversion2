<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContactSubmission;

final class ContactSubmissionService
{
    public function store(array $validated, ?string $ipAddress, ?string $userAgent): ContactSubmission
    {
        return ContactSubmission::query()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email_address' => $validated['email_address'],
            'project_type' => $validated['project_type'],
            'message' => $validated['message'],
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }
}
