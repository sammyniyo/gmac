<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class NewsPost extends Model implements HasMedia
{
    use HasSafeMedia;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];
}
