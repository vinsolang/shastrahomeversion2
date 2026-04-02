<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

final class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'desc' => ['nullable', 'string'],
            'location' => ['required', 'string'],
            'specifications' => ['nullable', 'string'],
            'category_id' => ['required', 'string', 'exists:categories,id'],
            'old_images' => ['nullable', 'array'],
            'old_images.*' => ['string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:20480'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $retainedImages = collect($this->input('old_images', []))
                ->filter(static fn (mixed $path): bool => is_string($path) && $path !== '')
                ->count();

            $uploadedImages = count($this->file('images', []));

            if (($retainedImages + $uploadedImages) === 0) {
                $validator->errors()->add('images', 'At least one project image is required.');
            }
        });
    }
}
