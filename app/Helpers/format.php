<?php
function config(string $key, mixed $default = null): mixed {
    static $cache = [];

    [$file, $item] = array_pad(explode('.', $key, 2), 2, null);
    if (!array_key_exists($file, $cache)) {
        $path = dirname(__DIR__, 2) . '/config/' . $file . '.php';
        $cache[$file] = is_file($path) ? require $path : [];
    }

    if ($item === null) return $cache[$file];
    return $cache[$file][$item] ?? $default;
}

function format_date(?string $date): string { return $date ? date('Y-m-d', strtotime($date)) : ''; }

function slugify(string $text): string {
    $slug = strtolower(trim($text));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Rich text (topic descriptions): the admin editor produces simple HTML, which is stored sanitized.
 *
 * Only these tags survive: p, br, h2, h3, h4, strong, em, ul, ol, li. Every attribute is removed,
 * scripts/styles/embeds are dropped completely, and links/images are reduced to their plain text.
 */
function sanitize_rich_text(?string $html): string {
    $html = trim((string) $html);
    if ($html === '') return '';
    if (strlen($html) > 100000) $html = substr($html, 0, 100000); // refuse to parse absurd input

    // Without ext-dom, fall back to the strictest option: plain text paragraphs.
    if (!class_exists('DOMDocument')) {
        return plain_text_to_html(html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8'));
    }

    $blockTags = ['p' => 'p', 'h1' => 'h2', 'h2' => 'h2', 'h3' => 'h3', 'h4' => 'h4', 'h5' => 'h4', 'h6' => 'h4',
                  'ul' => 'ul', 'ol' => 'ol', 'blockquote' => 'p', 'pre' => 'p', 'div' => 'div', 'section' => 'div', 'article' => 'div'];
    $inlineTags = ['strong' => 'strong', 'b' => 'strong', 'em' => 'em', 'i' => 'em'];
    $dropTags = ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math', 'template', 'noscript', 'textarea',
                 'select', 'option', 'button', 'form', 'input', 'head', 'title', 'meta', 'link', 'base', 'audio', 'video', 'canvas'];

    $previous = libxml_use_internal_errors(true);
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->loadHTML('<?xml encoding="UTF-8"><body>' . $html . '</body>', LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);

    $body = $doc->getElementsByTagName('body')->item(0);
    if (!$body) return '';

    $clean = static function (string $text): string {
        return htmlspecialchars(str_replace("\xC2\xA0", ' ', $text), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    };
    $isBlank = static fn(string $s): bool => trim(str_replace(["\xC2\xA0", '&nbsp;'], ' ', strip_tags($s))) === '';

    $inline = null;   // inline content of a node (text, strong, em, br; anything else unwrapped)
    $blocks = null;   // block content of a node
    $inline = function (DOMNode $node) use (&$inline, $inlineTags, $dropTags, $blockTags, $clean): string {
        $out = '';
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE || $child->nodeType === XML_CDATA_SECTION_NODE) {
                $out .= $clean($child->nodeValue);
                continue;
            }
            if ($child->nodeType !== XML_ELEMENT_NODE) continue;
            $tag = strtolower($child->nodeName);
            if (in_array($tag, $dropTags, true)) continue;
            if ($tag === 'br') { $out .= '<br>'; continue; }
            $inner = $inline($child);
            if (isset($inlineTags[$tag]) && trim($inner) !== '') {
                $out .= '<' . $inlineTags[$tag] . '>' . $inner . '</' . $inlineTags[$tag] . '>';
            } else {
                $out .= $inner . (isset($blockTags[$tag]) || $tag === 'li' ? ' ' : '');
            }
        }
        return $out;
    };

    $blocks = function (DOMNode $node) use (&$blocks, &$inline, $blockTags, $inlineTags, $dropTags, $clean, $isBlank): string {
        $out = '';
        $run = ''; // consecutive inline nodes at this level get wrapped in one <p>
        $flush = function () use (&$out, &$run, $isBlank) {
            if (!$isBlank($run)) $out .= '<p>' . trim($run) . '</p>';
            $run = '';
        };
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE || $child->nodeType === XML_CDATA_SECTION_NODE) {
                $run .= $clean($child->nodeValue);
                continue;
            }
            if ($child->nodeType !== XML_ELEMENT_NODE) continue;
            $tag = strtolower($child->nodeName);
            if (in_array($tag, $dropTags, true)) continue;

            if ($tag === 'ul' || $tag === 'ol') {
                $flush();
                // Quill stores bullet lists as <ol><li data-list="bullet">
                $listTag = $tag;
                foreach ($child->childNodes as $li) {
                    if ($li->nodeType === XML_ELEMENT_NODE && strtolower($li->nodeName) === 'li') {
                        $listTag = ($li instanceof DOMElement && $li->getAttribute('data-list') === 'bullet') ? 'ul' : ($li instanceof DOMElement && $li->getAttribute('data-list') === 'ordered' ? 'ol' : $tag);
                        break;
                    }
                }
                $items = '';
                foreach ($child->childNodes as $li) {
                    if ($li->nodeType !== XML_ELEMENT_NODE || strtolower($li->nodeName) !== 'li') continue;
                    $text = trim($inline($li));
                    if (!$isBlank($text)) $items .= '<li>' . $text . '</li>';
                }
                if ($items !== '') $out .= '<' . $listTag . '>' . $items . '</' . $listTag . '>';
                continue;
            }
            if ($tag === 'li') { // stray list item outside a list
                $flush();
                $text = trim($inline($child));
                if (!$isBlank($text)) $out .= '<p>' . $text . '</p>';
                continue;
            }
            if (isset($blockTags[$tag])) {
                $flush();
                $mapped = $blockTags[$tag];
                if ($mapped === 'div') { $out .= $blocks($child); continue; }
                $text = trim($inline($child));
                if (!$isBlank($text)) $out .= '<' . $mapped . '>' . $text . '</' . $mapped . '>';
                continue;
            }
            // inline or unknown element at block level: treat as part of the current paragraph
            $run .= isset($inlineTags[$tag]) || $tag === 'br' ? $inline((function () use ($child) { $w = new DOMDocument(); $r = $w->createElement('r'); $r->appendChild($w->importNode($child, true)); return $r; })()) : $inline($child);
        }
        $flush();
        return $out;
    };

    return $blocks($body);
}

/** Plain text (legacy descriptions) -> safe paragraphs. Blank line = new paragraph, newline = <br>. */
function plain_text_to_html(string $text): string {
    $text = trim(str_replace("\r\n", "\n", $text));
    if ($text === '') return '';
    $html = '';
    foreach (preg_split('/\n{2,}/', $text) as $paragraph) {
        $paragraph = trim($paragraph);
        if ($paragraph !== '') $html .= '<p>' . str_replace(["\r", "\n"], '', nl2br(htmlspecialchars($paragraph, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'), false)) . '</p>';
    }
    return $html;
}

/** Stored description (old plain text OR new HTML) -> HTML that is safe to print as-is. */
function rich_text_html(?string $stored): string {
    $stored = trim((string) $stored);
    if ($stored === '') return '';
    if ($stored === strip_tags($stored)) return plain_text_to_html($stored); // old plain-text rows
    return sanitize_rich_text($stored);
}

/** Stored description as one line of plain text (meta tags, JSON-LD, previews). */
function plain_excerpt(?string $stored, int $max = 160): string {
    $html = rich_text_html($stored);
    if ($html === '') return '';
    $text = str_replace(['</p>', '</li>', '</h2>', '</h3>', '</h4>', '<br>'], ' ', $html);
    $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim((string) preg_replace('/\s+/u', ' ', $text));
    return mb_strlen($text) > $max ? rtrim(mb_substr($text, 0, $max - 1)) . '…' : $text;
}
