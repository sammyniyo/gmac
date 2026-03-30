<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';
    protected $description = 'Generate the sitemap.xml for the site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = \Spatie\Sitemap\Sitemap::create();

        // Static Pages
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/')->setPriority(1.0)->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/history')->setPriority(0.8));
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/products')->setPriority(0.9));
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/news')->setPriority(0.8));
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/gallery')->setPriority(0.7));
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/washing-stations')->setPriority(0.7));
        $sitemap->add(\Spatie\Sitemap\Tags\Url::create('/contact')->setPriority(0.6));

        // Dynamic Products
        \App\Models\Product::where('is_active', true)->get()->each(function (\App\Models\Product $product) use ($sitemap) {
            $sitemap->add(\Spatie\Sitemap\Tags\Url::create("/products/{$product->slug}")->setPriority(0.8));
        });

        // Dynamic News
        \App\Models\NewsPost::where('is_published', true)->get()->each(function (\App\Models\NewsPost $post) use ($sitemap) {
            $sitemap->add(\Spatie\Sitemap\Tags\Url::create("/news/{$post->slug}")->setPriority(0.7));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
