<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class GlobalSetting extends Model
{
    protected $table = 'global_settings';
    protected $fillable = [
        'brand_name',
        'contact_address_line_1',
        'contact_address_line_2',
        'contact_phone_1',
        'contact_phone_2',
        'contact_hours',
        'contact_email',
        'contact_social_facebook_url',
        'contact_social_tiktok_url',
        'contact_social_instagram_url',
        'contact_social_telegram_url',
        'footer_cta_headline',
        'footer_cta_button_label',
        'footer_description_heading',
        'footer_description_paragraph_1',
        'footer_description_paragraph_2',
        'footer_team_image_path',
        'footer_legal_copyright',
    ];
}
