<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'section_key',
        'title_en',
        'title_km',
        'title_ch',
        'content1_km',
        'content1_en',
        'content1_ch',
        'content2_km',
        'content2_en',
        'content2_ch',
        'content3_km',
        'content3_en',
        'content3_ch',
        'content4_km',
        'content4_en',
        'content4_ch',
        'content5_km',
        'content5_en',
        'content5_ch',
        'pdf_path',
        'image_path',
    ];
}
