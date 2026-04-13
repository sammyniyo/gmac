<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Spatie\MediaLibrary\InteractsWithMedia;

trait HasSafeMedia
{
    use InteractsWithMedia {
        hasMedia as protected spatieHasMedia;
        getFirstMediaUrl as protected spatieGetFirstMediaUrl;
        clearMediaCollection as protected spatieClearMediaCollection;
        addMediaFromRequest as protected spatieAddMediaFromRequest;
    }

    protected function mediaTableReady(): bool
    {
        try {
            return Schema::hasTable('media');
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function hasMedia(string $collectionName = 'default'): bool
    {
        if (!$this->mediaTableReady()) {
            return false;
        }

        return $this->spatieHasMedia($collectionName);
    }

    public function getFirstMediaUrl(string $collectionName = 'default', string $conversionName = ''): string
    {
        if (!$this->mediaTableReady()) {
            return '';
        }

        return $this->spatieGetFirstMediaUrl($collectionName, $conversionName);
    }

    public function clearMediaCollection(string $collectionName = 'default'): static
    {
        if (!$this->mediaTableReady()) {
            return $this;
        }

        return $this->spatieClearMediaCollection($collectionName);
    }

    public function addMediaFromRequest(string $key)
    {
        if (!$this->mediaTableReady()) {
            throw new RuntimeException('The media table is missing. Run the media migration before uploading files.');
        }

        return $this->spatieAddMediaFromRequest($key);
    }
}
