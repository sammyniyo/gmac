<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\FrontendShowcase;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
        $keepSlugs = collect($catalog)->pluck('slug')->all();

        foreach ($catalog as $row) {
            $categorySlug = $row['category'];
            unset($row['category']);

            Product::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, [
                    'product_category_id' => $categories[$categorySlug]->id ?? null,
                    'is_active' => true,
                ])
            );
        }

        Product::whereNotIn('slug', $keepSlugs)->update(['is_active' => false]);
    }
}
