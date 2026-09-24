<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Statistic;
use App\Models\Testimonial;
use App\Models\WashingStation;
use App\Support\FrontendShowcase;
use Illuminate\Database\Seeder;

class ShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect();
        foreach (FrontendShowcase::categories() as $row) {
            $categories[$row['slug']] = ProductCategory::updateOrCreate(
                ['slug' => $row['slug']],
                $row
            );
        }

        $catalog = FrontendShowcase::products();
        $keepBarcodes = collect($catalog)->pluck('barcode')->all();

        foreach (Product::whereIn('barcode', $keepBarcodes)->get() as $existing) {
            $existing->update(['slug' => $existing->slug.'-tmp-'.substr((string) $existing->barcode, -4)]);
        }

        foreach ($catalog as $row) {
            $categorySlug = $row['category'];
            unset($row['category']);
            Product::updateOrCreate(
                ['barcode' => $row['barcode']],
                array_merge($row, [
                    'product_category_id' => $categories[$categorySlug]->id ?? null,
                    'is_active' => true,
                ])
            );
        }

        Product::whereNotIn('barcode', $keepBarcodes)->update(['is_active' => false]);

        $keepGallery = [];
        foreach (FrontendShowcase::gallery() as $i => $row) {
            $keepGallery[] = $row['title'];
            GalleryItem::updateOrCreate(
                ['title' => $row['title']],
                array_merge($row, ['order' => $i + 1, 'is_active' => true])
            );
        }
        GalleryItem::whereNotIn('title', $keepGallery)->update(['is_active' => false]);

        $this->call(NewsPostSeeder::class);

        $keepStations = [];
        foreach (FrontendShowcase::stations() as $row) {
            $keepStations[] = $row['name'];
            WashingStation::updateOrCreate(
                ['name' => $row['name']],
                $row
            );
        }
        WashingStation::whereNotIn('name', $keepStations)->delete();

        foreach (FrontendShowcase::testimonials() as $row) {
            Testimonial::updateOrCreate(
                ['name' => $row['name'], 'company' => $row['company']],
                array_merge($row, ['is_active' => true])
            );
        }

        foreach (FrontendShowcase::stats() as $row) {
            Statistic::updateOrCreate(
                ['title' => $row['title']],
                $row
            );
        }

        foreach (FrontendShowcase::reviews() as $row) {
            Feedback::updateOrCreate(
                ['name' => $row['name'], 'body' => $row['body']],
                $row
            );
        }

        $this->call(TeamMemberSeeder::class);
    }
}
