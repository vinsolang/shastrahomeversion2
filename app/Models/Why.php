<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Why extends Model
{
    protected $table = 'whys';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title_en',
        'title_km',
        'title_ch',
        'content_km',
        'content_en',
        'content_ch',
        'image',
    ];
}
