<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use App\Support\FrontendShowcase;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $keep = [];

        foreach (FrontendShowcase::heroSlides() as $i => $row) {
            $keep[] = $row['title'];

            $slide = HeroSlide::updateOrCreate(
                ['title' => $row['title']],
                [
                    'subtitle' => $row['subtitle'],
                    'button_text' => $row['button_text'] ?? null,
                    'button_link' => $row['button_link'] ?? null,
                    'order' => $i + 1,
                    'is_active' => true,
                ]
            );

            $path = public_path('images/'.($row['image_file'] ?? ''));

            if (is_file($path) && ! $slide->hasMedia('slides')) {
                $slide->addMedia($path)->preservingOriginal()->toMediaCollection('slides');
            }
        }

        HeroSlide::whereNotIn('title', $keep)->update(['is_active' => false]);
    }
}
