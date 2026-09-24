<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use App\Support\WordpressExport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewsPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = WordpressExport::publishedPosts();
        if ($posts === []) {
            return;
        }

        $keep = [];

        foreach ($posts as $row) {
            $keep[] = $row['slug'];

            $post = NewsPost::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['is_published' => true])
            );

            if (! empty($row['image_url']) && ! $post->hasMedia('cover')) {
                $this->attachRemoteImage($post, $row['image_url']);
            }
        }

        NewsPost::whereNotIn('slug', $keep)->update(['is_published' => false]);
    }

    protected function attachRemoteImage(NewsPost $post, string $url): void
    {
        try {
            $response = Http::timeout(25)->withHeaders([
                'User-Agent' => 'GMAC-Importer/1.0',
            ])->get($url);

            if (! $response->successful() || strlen($response->body()) < 800) {
                return;
            }

            $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg');
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                $ext = 'jpg';
            }

            $tmp = storage_path('app/tmp-news-'.Str::random(8).'.'.$ext);
            if (! is_dir(dirname($tmp))) {
                mkdir(dirname($tmp), 0755, true);
            }
            file_put_contents($tmp, $response->body());

            $post->addMedia($tmp)->usingFileName($post->slug.'.'.$ext)->toMediaCollection('cover');
        } catch (\Throwable) {
            // Keep the post even if the WordPress image is unreachable.
        }
    }
}
