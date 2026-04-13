<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class HeroSlide extends Model implements HasMedia
{
    use HasSafeMedia;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
