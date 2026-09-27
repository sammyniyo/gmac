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

    public function isRetailPack(): bool
    {
        return in_array((string) $this->barcode, [
            '0679721369612', '0679721369778', '0679721369955',
            '0679721369544', '0679721369476', '0679721369300',
            '0679721369230', '0679721369162', '0679721369090',
        ], true);
    }

    public function isGreenLot(): bool
    {
        return ! $this->isRetailPack();
    }

    public function usesPackShot(): bool
    {
        return $this->isRetailPack() || $this->isGreenLot();
    }

    public function packColor(): string
    {
        if (! $this->isRetailPack()) {
            return match (true) {
                str_contains((string) $this->slug, 'lemongrass') => 'coferment',
                str_contains((string) $this->slug, 'natural') => 'natural',
                default => 'washed',
            };
        }

        return match ((string) $this->barcode) {
            '0679721369778', '0679721369476', '0679721369162' => 'green',
            '0679721369955', '0679721369544', '0679721369230' => 'chocolate',
            default => 'red',
        };
    }

    public function packSize(): string
    {
        if (! $this->isRetailPack()) {
            return match (true) {
                str_contains((string) $this->slug, 'grade-a1') => 'Grade A1',
                str_contains((string) $this->slug, 'commercial') => 'Commercial',
                str_contains((string) $this->slug, 'low-grade') => 'Low grade',
                str_contains((string) $this->slug, 'natural') => 'Natural',
                str_contains((string) $this->slug, 'lemongrass') => 'Lemongrass',
                default => 'Green lot',
            };
        }

        return match ((string) $this->barcode) {
            '0679721369612', '0679721369778', '0679721369955' => '250g',
            '0679721369544', '0679721369476', '0679721369300' => '500g',
            default => '1kg',
        };
    }

    public function packColorLabel(): string
    {
        return match ($this->packColor()) {
            'green' => 'Green & white',
            'chocolate' => 'Chocolate & white',
            'natural' => 'Natural',
            'washed' => 'Fully washed',
            'coferment' => 'Co-fermented',
            default => 'Red & white',
        };
    }

    public function packRoast(): ?string
    {
        if (! $this->isRetailPack()) {
            return null;
        }

        return match ($this->packColor()) {
            'red' => 'Dark roast',
            'chocolate' => 'Light roast',
            default => null,
        };
    }

    public function offerLead(): string
    {
        if ($this->isGreenLot()) {
            return 'Green Arabica from Karenge and Gasange. Price on request — write to us for availability, sample, and export terms.';
        }

        $roast = $this->packRoast();

        return 'A '.$this->packSize().' roasted Arabica bag in the '.$this->packColorLabel().' envelope'
            .($roast ? ', finished as a '.strtolower($roast) : '')
            .'. Packed in Niboye, Kigali by Green Mountain Arabica Coffee Ltd.';
    }

    public function displayImage(): string
    {
        foreach (['cover', 'products'] as $collection) {
            $url = $this->existingMediaUrl($collection);
            if ($url !== '') {
                return $url;
            }
        }

        return FrontendShowcase::productImage($this->slug);
    }
}
