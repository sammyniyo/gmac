<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class Product extends Model implements HasMedia
{
    use HasSafeMedia;

    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
