<?php

function render_template(string $path, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require $path;
}

function build_hreflang(string $path): array
{
    return [
        'ru-RU' => '/ru' . $path,
        'en-US' => '/en' . $path,
    ];
}

function render_json_ld(array $data): void
{
    echo '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

function build_breadcrumbs(string $lang, array $crumbs): array
{
    $items = [];
    foreach ($crumbs as $position => $crumb) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position + 1,
            'name' => $crumb['label'],
            'item' => $crumb['url'],
        ];
    }

    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

function build_organization(string $name, string $url): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $name,
        'url' => $url,
    ];
}

function build_faq(array $faq): array
{
    $items = [];
    foreach ($faq as $item) {
        $items[] = [
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['answer'],
            ],
        ];
    }

    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $items,
    ];
}
