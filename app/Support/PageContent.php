<?php

namespace App\Support;

use Illuminate\Support\Str;

class PageContent
{
    public static function isMaklumatStandarBiaya(string $slug, string $title, ?string $currentSub = null): bool
    {
        return $currentSub === 'maklumat-pelayanan-standar-biaya'
            || (Str::contains($slug, 'maklumat-pelayanan') && Str::contains($title, 'Standar Biaya'));
    }

    /**
     * @param  array<int, array{id: string, text: string}>  $extraHeadings
     * @return array<int, array{id: string, text: string}>
     */
    public static function headings(string $content, string $levels = '23', array $extraHeadings = [], ?int $maxLength = null): array
    {
        preg_match_all('/<(h['.$levels.'])[^>]*>(.*?)<\/\1>/i', $content, $matches);

        $headings = [];
        foreach ($matches[2] ?? [] as $headingText) {
            $text = html_entity_decode(strip_tags($headingText), ENT_QUOTES, 'UTF-8');

            if ($maxLength !== null && (strlen($text) <= 2 || strlen($text) >= $maxLength)) {
                continue;
            }

            $headings[] = [
                'id' => Str::slug(strip_tags($headingText)),
                'text' => $text,
            ];
        }

        return array_merge($headings, $extraHeadings);
    }

    public static function withHeadingIds(string $content, string $levels = '23', string $classes = 'scroll-mt-32 border-b-2 border-gray-100 pb-2'): string
    {
        return preg_replace_callback('/<(h['.$levels.'])([^>]*)>(.*?)<\/\1>/i', function (array $match) use ($classes): string {
            $tag = $match[1];
            $attributes = $match[2];
            $headingContent = $match[3];
            $id = Str::slug(strip_tags($headingContent));

            if (! str_contains($attributes, 'id="')) {
                $attributes .= ' id="'.$id.'"';
            }

            if (str_contains($attributes, 'class="')) {
                $attributes = preg_replace('/class="/', 'class="'.$classes.' ', $attributes) ?? $attributes;
            } else {
                $attributes .= ' class="'.$classes.'"';
            }

            return "<{$tag}{$attributes}>{$headingContent}</{$tag}>";
        }, $content) ?? $content;
    }

    public static function withoutRegulasiDraftNotice(string $content): string
    {
        return preg_replace(
            '/<div\\b[^>]*>.*?Draft.*?perlu ditinjau tim PPID.*?<\\/div>/isu',
            '',
            $content
        ) ?? $content;
    }
}
