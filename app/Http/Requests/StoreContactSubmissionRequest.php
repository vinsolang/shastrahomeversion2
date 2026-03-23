<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreContactSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email_address' => ['required', 'email', 'max:255'],
            'project_type' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }
}
