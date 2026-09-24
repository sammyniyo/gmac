<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use App\Support\FrontendShowcase;
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

    public static function rwf(?float $amount): string
    {
        if ($amount === null) {
            return '';
        }

        return number_format($amount, 0).' frw';
    }

    public function formattedPrice(): ?string
    {
        return $this->price === null ? null : self::rwf((float) $this->price);
    }

    public function usesPackShot(): bool
    {
        return in_array($this->packColor(), ['green', 'red', 'chocolate'], true);
    }

    public function packColor(): string
    {
        return match ((string) $this->barcode) {
            '0679721369778', '0679721369476', '0679721369162' => 'green',
            '0679721369955', '0679721369544', '0679721369230' => 'chocolate',
            '0679721369612', '0679721369300', '0679721369090' => 'red',
            default => match (true) {
                str_contains((string) $this->slug, 'green') => 'green',
                str_contains((string) $this->slug, 'chocolate') => 'chocolate',
                default => 'red',
            },
        };
    }

    public function packSize(): string
    {
        return match ((string) $this->barcode) {
            '0679721369612', '0679721369778', '0679721369955' => '250g',
            '0679721369544', '0679721369476', '0679721369300' => '500g',
            '0679721369230', '0679721369162', '0679721369090' => '1kg',
            default => match (true) {
                str_contains((string) $this->slug, '250g') => '250g',
                str_contains((string) $this->slug, '1kg') => '1kg',
                default => '500g',
            },
        };
    }

    public function packColorLabel(): string
    {
        return match ($this->packColor()) {
            'green' => 'Green & white',
            'chocolate' => 'Chocolate & white',
            default => 'Red & white',
        };
    }

    public function packRoast(): ?string
    {
        return match ($this->packColor()) {
            'red' => 'Dark roast',
            'chocolate' => 'Light roast',
            default => null,
        };
    }

    public function displayImage(): string
    {
        foreach (['cover', 'products'] as $collection) {
            $url = $this->getFirstMediaUrl($collection);
            if ($url !== '') {
                return $url;
            }
        }

        return FrontendShowcase::img(match ($this->packColor()) {
            'green' => 'pack_green',
            'chocolate' => 'pack_chocolate',
            default => 'pack_red',
        });
    }
}
