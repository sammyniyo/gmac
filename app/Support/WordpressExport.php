<?php

namespace App\Support;

use SimpleXMLElement;

class WordpressExport
{
    public static function path(): string
    {
        return database_path('data/gmac-wordpress-export.xml');
    }

    public static function publishedPosts(): array
    {
        $path = self::path();
        if (! is_file($path)) {
            return [];
        }

        $xml = simplexml_load_file($path);
        if (! $xml instanceof SimpleXMLElement) {
            return [];
        }

        $attachments = [];
        $posts = [];

        foreach ($xml->channel->item as $item) {
            $wp = $item->children('http://wordpress.org/export/1.2/');
            $type = (string) $wp->post_type;

            if ($type === 'attachment') {
                $url = trim((string) $wp->attachment_url);
                if ($url !== '') {
                    $attachments[(string) $wp->post_id] = $url;
                }
            }
        }

        foreach ($xml->channel->item as $item) {
            $wp = $item->children('http://wordpress.org/export/1.2/');
            $contentNs = $item->children('http://purl.org/rss/1.0/modules/content/');

            if ((string) $wp->post_type !== 'post' || (string) $wp->status !== 'publish') {
                continue;
            }

            $html = self::cleanHtml((string) $contentNs->encoded);
            if ($html === '') {
                continue;
            }

            $thumbId = null;
            foreach ($wp->postmeta as $meta) {
                if ((string) $meta->meta_key === '_thumbnail_id') {
                    $thumbId = trim((string) $meta->meta_value);
                    break;
                }
            }

            $posts[] = [
                'slug' => (string) $wp->post_name,
                'title' => html_entity_decode(trim((string) $item->title), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                'excerpt' => self::excerpt($html),
                'content' => $html,
                'published_at' => (string) $wp->post_date,
                'image_url' => $thumbId && isset($attachments[$thumbId]) ? $attachments[$thumbId] : self::firstImageSrc($html),
            ];
        }

        usort($posts, fn (array $a, array $b) => strcmp($b['published_at'], $a['published_at']));

        return $posts;
    }

    public static function cleanHtml(string $html): string
    {
        $html = preg_replace('/<!--\s*\/?wp:.*?-->/s', '', $html) ?? $html;
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $html = preg_replace(
            '/<p[^>]*class="[^"]*has-large-font-size[^"]*"[^>]*>\s*(?:<strong>)?(.*?)(?:<\/strong>)?\s*<\/p>/is',
            '<h2>$1</h2>',
            $html
        ) ?? $html;
        $html = strip_tags($html, '<p><br><strong><b><em><i><a><ul><ol><li><blockquote><h2><h3><h4><figure><img><figcaption><hr>');
        $html = preg_replace('/<p>\s*(?:&nbsp;|\s)*<\/p>/i', '', $html) ?? $html;
        $html = preg_replace('/\s+/', ' ', $html) ?? $html;
        $html = preg_replace('/>\s+</', '><', $html) ?? $html;
        $html = str_replace(['<h2>', '<h3>', '<p>', '<li>'], ["\n<h2>", "\n<h3>", "\n<p>", "\n<li>"], $html);

        return trim($html);
    }

    public static function excerpt(string $html, int $limit = 220): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)) ?? '');

        if ($text === '') {
            return '';
        }

        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $limit), " \t\n\r.,;:-").'…';
    }

    public static function firstImageSrc(string $html): ?string
    {
        if (preg_match('/<img[^>]+src="([^"]+)"/i', $html, $match)) {
            return $match[1];
        }

        return null;
    }
}
