<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

/**
 * Builds /storage/... URLs using the current HTTP request host + port when available,
 * so images work with `php artisan serve` (e.g. :8000) even when APP_URL is http://localhost.
 * Falls back to the public disk URL (APP_URL) for CLI/queue.
 */
class RequestAwareUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $path = str_replace('\\', '/', $this->getPathRelativeToRoot());

        if ($this->hasRequestHost()) {
            $url = rtrim(request()->getSchemeAndHttpHost(), '/').'/storage/'.$path;
        } else {
            $url = $this->getDisk()->url($path);
        }

        return $this->versionUrl($url);
    }

    protected function hasRequestHost(): bool
    {
        if (! app()->bound('request') || ! request()) {
            return false;
        }

        try {
            return request()->getSchemeAndHttpHost() !== '';
        } catch (\Throwable) {
            return false;
        }
    }
}
