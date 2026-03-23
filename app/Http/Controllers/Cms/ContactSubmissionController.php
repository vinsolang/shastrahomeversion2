<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Contracts\View\View;

final class ContactSubmissionController extends Controller
{
    public function index(): View
    {
        return view('cms.contact-submissions.index', [
            'submissions' => ContactSubmission::query()
                ->latest()
                ->paginate(20),
        ]);
    }
}
