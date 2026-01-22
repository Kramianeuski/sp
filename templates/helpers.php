<?php

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function renderBlocks(array $blocks): string
{
    $output = '';
    foreach ($blocks as $block) {
        $output .= '<section class="section">';
        if (!empty($block['title'])) {
            $output .= '<h2>' . e($block['title']) . '</h2>';
        }
        if (!empty($block['body'])) {
            $output .= '<p>' . nl2br(e($block['body'])) . '</p>';
        }
        if (!empty($block['cta_label']) && !empty($block['cta_url'])) {
            $output .= '<a class="button" href="' . e($block['cta_url']) . '">' . e($block['cta_label']) . '</a>';
        }
        $output .= '</section>';
    }
    return $output;
}

function jsonLd(array $data): string
{
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
