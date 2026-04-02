<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePageContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return match ((string) $this->route('page')) {
            'home' => $this->homeRules(),
            'contact' => $this->contactRules(),
            default => ['page' => ['prohibited']],
        };
    }

    private function homeRules(): array
    {
        $rules = [
            'sections.hero.eyebrow' => ['nullable', 'string', 'max:255'],
            'sections.hero.title' => ['nullable', 'string', 'max:255'],
            'sections.hero.titleAccent' => ['nullable', 'string', 'max:20'],
            'sections.hero.description' => ['nullable', 'string'],
            'sections.hero.primaryCta.label' => ['nullable', 'string', 'max:255'],
            'sections.hero.primaryCta.route' => ['nullable', 'string', 'max:255'],
            'sections.hero.secondaryCta.label' => ['nullable', 'string', 'max:255'],
            'sections.hero.secondaryCta.route' => ['nullable', 'string', 'max:255'],
            'sections.hero.videos.0.label' => ['nullable', 'string', 'max:255'],
            'sections.hero.videos.0.src' => ['nullable', 'string', 'max:255'],
        ];

        foreach (range(0, 2) as $index) {
            $rules["sections.stats.{$index}.value"] = ['nullable', 'string', 'max:255'];
            $rules["sections.stats.{$index}.label"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    private function contactRules(): array
    {
        $rules = [
            'sections.title' => ['nullable', 'string', 'max:255'],
            'sections.description' => ['nullable', 'string'],
            'sections.hero.eyebrow' => ['nullable', 'string', 'max:255'],
            'sections.hero.headline' => ['nullable', 'string', 'max:255'],
            'sections.hero.accent' => ['nullable', 'string', 'max:20'],
            'sections.hero.description' => ['nullable', 'string'],
            'sections.hero.video' => ['nullable', 'string', 'max:255'],
            'sections.hero.poster' => ['nullable', 'string', 'max:255'],
            'sections.form.title' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.first_name.label' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.first_name.placeholder' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.last_name.label' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.last_name.placeholder' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.email_address.label' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.email_address.placeholder' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.project_type.label' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.project_type.placeholder' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.message.label' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.message.placeholder' => ['nullable', 'string', 'max:255'],
            'sections.form.fields.message.rows' => ['nullable', 'integer', 'min:1', 'max:20'],
            'sections.form.submit_label' => ['nullable', 'string', 'max:255'],
            'sections.media.headline_prefix' => ['nullable', 'string', 'max:255'],
            'sections.media.headline_emphasis' => ['nullable', 'string', 'max:255'],
            'sections.media.headline_suffix' => ['nullable', 'string', 'max:255'],
            'sections.media.accent' => ['nullable', 'string', 'max:20'],
            'sections.media.video' => ['nullable', 'string', 'max:255'],
        ];

        foreach (range(0, 3) as $index) {
            $rules["sections.form.fields.project_type.options.{$index}"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
