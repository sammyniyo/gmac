<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use App\Support\FrontendShowcase;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class WashingStation extends Model implements HasMedia
{
    use HasSafeMedia;

    protected $guarded = [];

    public function displayImage(): string
    {
        $url = $this->getFirstMediaUrl('cover');
        if ($url !== '') {
            return $url;
        }

        return FrontendShowcase::stationImage($this->name);
    }
}
