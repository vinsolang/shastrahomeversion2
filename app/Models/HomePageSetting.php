<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class HomePageSetting extends Model
{
    protected $table = 'home_page_settings';
    protected $fillable = [
        'hero_title',
        'hero_primary_cta_label',
        'hero_description',
        'stat_1_value',
        'stat_1_label',
        'stat_2_value',
        'stat_2_label',
        'stat_3_value',
        'stat_3_label',
    ];
}
