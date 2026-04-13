<?php

namespace App\Support\MediaLibrary;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Stores each upload under storage/app/public/{root}/{model}/{collection}/{media_id}/
 * so hero slides, products, gallery, etc. are clearly separated on disk.
 */
class GmacPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->base($media).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->base($media).'/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->base($media).'/responsive-images/';
    }

    /**
     * Relative path inside the disk root (no leading slash).
     */
    public function directoryWithoutTrailingSlash(Media $media): string
    {
        return $this->base($media);
    }

    protected function base(Media $media): string
    {
        $root = trim((string) config('media-library.gmac_upload_root', 'uploads'), '/');
        $model = Str::kebab(class_basename($media->model_type));
        $collection = Str::slug((string) $media->collection_name, '-');

        return "{$root}/{$model}/{$collection}/{$media->getKey()}";
    }
}
