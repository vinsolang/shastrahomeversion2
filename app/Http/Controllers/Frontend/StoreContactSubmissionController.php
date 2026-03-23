<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactSubmissionRequest;
use App\Services\ContactSubmissionService;
use Illuminate\Http\RedirectResponse;

final class StoreContactSubmissionController extends Controller
{
    public function __invoke(
        StoreContactSubmissionRequest $request,
        ContactSubmissionService $contactSubmissionService,
    ): RedirectResponse {
        $contactSubmissionService->store(
            $request->validated(),
            $request->ip(),
            $request->userAgent(),
        );

        return to_route('contact')->with(
            'contact_form_status',
            'Thanks for reaching out. Our team will review your request and get back to you shortly.',
        );
    }
}
