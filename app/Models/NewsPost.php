<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use App\Support\FrontendShowcase;
use App\Support\WordpressExport;
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

    public function displayImage(): string
    {
        $url = $this->existingMediaUrl('cover');
        if ($url !== '') {
            return $url;
        }

        if (filled($this->image_url) && $this->publicImageUrlIsUsable($this->image_url)) {
            return $this->image_url;
        }

        $fromBody = WordpressExport::firstImageSrc((string) $this->content);
        if ($fromBody && $this->publicImageUrlIsUsable($fromBody)) {
            return $fromBody;
        }

        return FrontendShowcase::newsImage($this->slug);
    }

    private function publicImageUrlIsUsable(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH) ?: $url;

        return ! str_contains($path, '/storage/')
            && ! str_contains($path, '/wp-content/');
    }
}
