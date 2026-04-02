<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateGlobalSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        $rules = [
            'sections.brand.name' => ['nullable', 'string', 'max:255'],
            'sections.brand.location' => ['nullable', 'string', 'max:255'],
            'sections.contact.hours' => ['nullable', 'string', 'max:255'],
            'sections.contact.email' => ['nullable', 'email', 'max:255'],
            'sections.footer.cta.headline' => ['nullable', 'string', 'max:255'],
            'sections.footer.cta.emphasis' => ['nullable', 'string', 'max:255'],
            'sections.footer.cta.accent' => ['nullable', 'string', 'max:20'],
            'sections.footer.cta.button_label' => ['nullable', 'string', 'max:255'],
            'sections.footer.cta.button_route' => ['nullable', 'string', 'max:255'],
            'sections.footer.cta.background_image' => ['nullable', 'string', 'max:255'],
            'sections.footer.team.eyebrow' => ['nullable', 'string', 'max:255'],
            'sections.footer.team.caption' => ['nullable', 'string', 'max:255'],
            'sections.footer.team.image' => ['nullable', 'string', 'max:255'],
            'sections.footer.team.message.0' => ['nullable', 'string', 'max:255'],
            'sections.footer.team.message.1' => ['nullable', 'string', 'max:255'],
            'sections.footer.description_heading' => ['nullable', 'string', 'max:255'],
            'sections.footer.description.0' => ['nullable', 'string'],
            'sections.footer.description.1' => ['nullable', 'string'],
            'sections.footer.legal.copyright' => ['nullable', 'string', 'max:255'],
            'uploads.footer_team_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:16384'],
        ];

        foreach (range(0, 5) as $index) {
            $rules["sections.footer.logo_strip.items.{$index}.label"] = ['nullable', 'string', 'max:255'];
            $rules["sections.footer.company_links.{$index}.label"] = ['nullable', 'string', 'max:255'];
            $rules["sections.footer.company_links.{$index}.route"] = ['nullable', 'string', 'max:255'];
        }

        foreach (range(0, 1) as $index) {
            $rules["sections.contact.address_lines.{$index}"] = ['nullable', 'string', 'max:255'];
            $rules["sections.contact.phones.{$index}"] = ['nullable', 'string', 'max:255'];
            $rules["sections.footer.legal.links.{$index}.label"] = ['nullable', 'string', 'max:255'];
            $rules["sections.footer.legal.links.{$index}.href"] = ['nullable', 'string', 'max:255'];
        }

        foreach (range(0, 3) as $index) {
            $rules["sections.contact.socials.{$index}.label"] = ['nullable', 'string', 'max:255'];
            $rules["sections.contact.socials.{$index}.icon"] = ['nullable', 'string', 'max:100'];
            $rules["sections.contact.socials.{$index}.href"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
