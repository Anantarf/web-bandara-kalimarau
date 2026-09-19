<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlSanitizer
{
    /** @var array<string, array<int, string>> */
    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'table' => ['class'],
        'thead' => ['class'],
        'tbody' => ['class'],
        'tr' => ['class'],
        'th' => ['class', 'colspan', 'rowspan'],
        'td' => ['class', 'colspan', 'rowspan'],
    ];

    /** @var array<int, string> */
    private const ALLOWED_TAGS = [
        'a', 'abbr', 'blockquote', 'br', 'caption', 'code', 'col', 'colgroup', 'div', 'em', 'figcaption', 'figure',
        'h2', 'h3', 'h4', 'hr', 'img', 'li', 'ol', 'p', 'pre', 'span', 'strong', 'sub', 'sup', 'table', 'tbody',
        'td', 'tfoot', 'th', 'thead', 'tr', 'u', 'ul',
    ];

    /** @var array<int, string> */
    private const GLOBAL_ATTRIBUTES = ['class', 'id'];

    /** @var array<int, string> */
    private const REMOVE_WITH_CONTENT = ['iframe', 'script', 'style'];

    public static function clean(?string $html): string
    {
        $html = (string) $html;

        if (trim($html) === '') {
            return '';
        }

        $document = new DOMDocument;
        libxml_use_internal_errors(true);
        $document->loadHTML(
            '<!DOCTYPE html><html><body>'.$html.'</body></html>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $body = $document->getElementsByTagName('body')->item(0);
        if (! $body) {
            return strip_tags($html);
        }

        self::sanitizeChildren($body);

        $clean = '';
        foreach ($body->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return trim($clean);
    }

    private static function sanitizeChildren(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                self::sanitizeElement($child);
            }

            if ($child->parentNode) {
                self::sanitizeChildren($child);
            }
        }
    }

    private static function sanitizeElement(DOMElement $element): void
    {
        $tag = strtolower($element->tagName);

        if (in_array($tag, self::REMOVE_WITH_CONTENT, true)) {
            $element->parentNode?->removeChild($element);

            return;
        }

        if (! in_array($tag, self::ALLOWED_TAGS, true)) {
            self::unwrapElement($element);

            return;
        }

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->name);
            $value = trim($attribute->value);

            if (! self::isAllowedAttribute($tag, $name) || ! self::isSafeAttributeValue($name, $value)) {
                $element->removeAttributeNode($attribute);
            }
        }

        if ($tag === 'a') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function unwrapElement(DOMElement $element): void
    {
        $parent = $element->parentNode;
        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    private static function isAllowedAttribute(string $tag, string $name): bool
    {
        if (str_starts_with($name, 'on')) {
            return false;
        }

        return in_array($name, self::GLOBAL_ATTRIBUTES, true)
            || in_array($name, self::ALLOWED_ATTRIBUTES[$tag] ?? [], true);
    }

    private static function isSafeAttributeValue(string $name, string $value): bool
    {
        if (in_array($name, ['href', 'src'], true)) {
            return preg_match('/^(https?:|mailto:|tel:|\/|#|storage\/|images\/)/i', $value) === 1;
        }

        return ! str_contains(strtolower($value), 'javascript:');
    }
}
