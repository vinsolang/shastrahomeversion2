<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateGlobalSettingsRequest;
use App\Models\GlobalSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class GlobalSettingsController extends Controller
{
    public function edit(): View
    {
        $setting = GlobalSetting::first();

        return view('admin.cms.global-settings', [
            'values' => $this->formatToSections($setting),
        ]);
    }

    public function update(UpdateGlobalSettingsRequest $request): RedirectResponse
    {
        $sections = $request->validated('sections');

        // Handle image upload
        $sections = $this->syncFooterTeamImage(
            $sections,
            $request->file('uploads.footer_team_image')
        );

        // Map sections → DB fields
        $data = [
            'brand_name' => data_get($sections, 'brand.name'),

            'contact_address_line_1' => data_get($sections, 'contact.address_lines.0'),
            'contact_address_line_2' => data_get($sections, 'contact.address_lines.1'),

            'contact_phone_1' => data_get($sections, 'contact.phones.0'),
            'contact_phone_2' => data_get($sections, 'contact.phones.1'),

            'contact_hours' => data_get($sections, 'contact.hours'),
            'contact_email' => data_get($sections, 'contact.email'),

            'contact_social_facebook_url' => data_get($sections, 'contact.socials.0.href'),
            'contact_social_tiktok_url' => data_get($sections, 'contact.socials.1.href'),
            'contact_social_instagram_url' => data_get($sections, 'contact.socials.2.href'),
            'contact_social_telegram_url' => data_get($sections, 'contact.socials.3.href'),

            'footer_cta_headline' => data_get($sections, 'footer.cta.headline'),
            'footer_cta_button_label' => data_get($sections, 'footer.cta.button_label'),

            'footer_description_heading' => data_get($sections, 'footer.description_heading'),
            'footer_description_paragraph_1' => data_get($sections, 'footer.description.0'),
            'footer_description_paragraph_2' => data_get($sections, 'footer.description.1'),

            'footer_team_image_path' => data_get($sections, 'footer.team.image'),

            'footer_legal_copyright' => data_get($sections, 'footer.legal.copyright'),
        ];

        // Save (create if not exists)
        GlobalSetting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return redirect()
            ->route('cms.settings.edit')
            ->with('success', 'Global settings updated successfully.');
    }

    private function syncFooterTeamImage(array $sections, ?UploadedFile $file): array
    {
        if (!$file) {
            return $sections;
        }

        $currentPath = data_get($sections, 'footer.team.image');

        if ($currentPath && Storage::disk('public')->exists($currentPath)) {
            Storage::disk('public')->delete($currentPath);
        }

        $path = $file->store('cms/global/team', 'public');

        data_set($sections, 'footer.team.image', $path);

        return $sections;
    }

    // Convert DB → sections (for edit form)
    private function formatToSections(?GlobalSetting $setting): array
    {
        if (!$setting) return [];

        return [
            'brand' => [
                'name' => $setting->brand_name,
            ],
            'contact' => [
                'address_lines' => [
                    $setting->contact_address_line_1,
                    $setting->contact_address_line_2,
                ],
                'phones' => [
                    $setting->contact_phone_1,
                    $setting->contact_phone_2,
                ],
                'hours' => $setting->contact_hours,
                'email' => $setting->contact_email,
                'socials' => [
                    ['label' => 'Facebook', 'icon' => 'facebook', 'href' => $setting->contact_social_facebook_url],
                    ['label' => 'TikTok', 'icon' => 'tiktok', 'href' => $setting->contact_social_tiktok_url],
                    ['label' => 'Instagram', 'icon' => 'instagram', 'href' => $setting->contact_social_instagram_url],
                    ['label' => 'Telegram', 'icon' => 'telegram', 'href' => $setting->contact_social_telegram_url],
                ],
            ],
            'footer' => [
                'cta' => [
                    'headline' => $setting->footer_cta_headline,
                    'button_label' => $setting->footer_cta_button_label,
                ],
                'description_heading' => $setting->footer_description_heading,
                'description' => [
                    $setting->footer_description_paragraph_1,
                    $setting->footer_description_paragraph_2,
                ],
                'team' => [
                    'image' => $setting->footer_team_image_path,
                ],
                'legal' => [
                    'copyright' => $setting->footer_legal_copyright,
                ],
            ],
        ];
    }
}
























// declare(strict_types=1);

// namespace App\Http\Controllers\admin;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\Admin\UpdateGlobalSettingsRequest;
// use App\Services\CmsContentService;
// use App\Services\SiteContentService;
// use Illuminate\Contracts\View\View;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;

// final class GlobalSettingsController extends Controller
// {
//     public function edit(
//         CmsContentService $cmsContentService,
//         SiteContentService $siteContentService,
//     ): View {
//         return view('admin.cms.global-settings', [
//             'cmsPages' => $cmsContentService->editablePages(),
//             'values' => $siteContentService->getGlobalContent(),
//         ]);
//     }

//     public function update(
//         UpdateGlobalSettingsRequest $request,
//         CmsContentService $cmsContentService,
//     ): RedirectResponse {
//         $sections = $request->validated('sections');
//         $sections = $this->syncFooterTeamImage($sections, $request->file('uploads.footer_team_image'));

//         $cmsContentService->updateGlobalSettings($sections);

//         return to_route('cms.settings.edit')->with('success', 'Global settings updated successfully.');
//     }

//     private function syncFooterTeamImage(array $sections, ?UploadedFile $file): array
//     {
//         if (! $file instanceof UploadedFile) {
//             return $sections;
//         }

//         $currentPath = data_get($sections, 'footer.team.image');
//         if (is_string($currentPath) && Storage::disk('public')->exists($currentPath)) {
//             Storage::disk('public')->delete($currentPath);
//         }

//         data_set($sections, 'footer.team.image', $file->store('cms/global/team', 'public'));

//         return $sections;
//     }
// }
