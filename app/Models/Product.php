<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'desc',
        'location',
        'specifications',
        'category_id',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // store images as JSON
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->id = $product->id ?? (method_exists(Str::class, 'cuid') ? Str::cuid() : Str::random(10));
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
