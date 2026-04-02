<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ContactPageSetting extends Model
{
    protected $table = 'contact_page_settings';
    protected $fillable = [
        'page_title',
        'page_description',
        'hero_headline',
        'hero_poster_path',
        'form_title',
        'form_submit_label',
        'project_type_option_1',
        'project_type_option_2',
        'project_type_option_3',
        'project_type_option_4',
    ];
}
