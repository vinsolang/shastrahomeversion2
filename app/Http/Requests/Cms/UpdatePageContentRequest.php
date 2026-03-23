<?php

declare(strict_types=1);

namespace App\Http\Requests\Cms;

use App\Http\Requests\Cms\Concerns\ValidatesCmsJsonFields;
use App\Services\CmsContentService;
use Illuminate\Foundation\Http\FormRequest;

final class UpdatePageContentRequest extends FormRequest
{
    use ValidatesCmsJsonFields;

    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $definition = app(CmsContentService::class)->editablePage((string) $this->route('page'));

        if ($definition === null) {
            return [
                'page' => ['prohibited'],
            ];
        }

        $rules = [];

        foreach ($definition['sections'] ?? [] as $section) {
            $key = $section['key'] ?? null;
            $type = $section['type'] ?? null;

            if (! is_string($key) || ! is_string($type)) {
                continue;
            }

            $rules["sections.{$key}"] = match ($type) {
                'json' => ['required', 'json'],
                'textarea', 'text' => ['required', 'string'],
                default => ['required'],
            };
        }

        return $rules;
    }

    public function withValidator($validator): void
    {
        $validator->after(function () use ($validator): void {
            $definition = app(CmsContentService::class)->editablePage((string) $this->route('page'));

            if ($definition === null) {
                return;
            }

            $this->validateDecodedJson(
                $validator,
                $definition['sections'] ?? [],
            );
        });
    }
}
