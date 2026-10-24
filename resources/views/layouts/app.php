<?php
$__siteName = config('seo.site_name', 'Skoolyst MCQs');
$__title = \Skoolyst\Core\View::yieldSection('full_title');
if ($__title === '') {
    $__page = trim(\Skoolyst\Core\View::yieldSection('title'));
    $__title = $__page !== '' ? $__page . ' | ' . $__siteName : $__siteName;
}
$__description = meta_description(\Skoolyst\Core\View::yieldSection('meta_description', (string) config('seo.description', '')));
$__canonical = \Skoolyst\Core\View::yieldSection('canonical', canonical_url());
$__robots = \Skoolyst\Core\View::yieldSection('robots', 'index, follow, max-image-preview:large');
$__ogImage = absolute_asset(\Skoolyst\Core\View::yieldSection('og_image', (string) config('seo.og_image', 'assets/images/og-default.jpg')));
$__ogType = \Skoolyst\Core\View::yieldSection('og_type', 'website');
$__siteSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Organization',
            '@id' => base_url() . '/#organization',
            'name' => $__siteName,
            'url' => base_url() . '/',
            'logo' => absolute_asset('favicon.png'),
            'parentOrganization' => ['@type' => 'Organization', 'name' => 'Skoolyst', 'url' => config('seo.parent_site', 'https://skoolyst.com')],
        ],
        [
            '@type' => 'WebSite',
            '@id' => base_url() . '/#website',
            'name' => $__siteName,
            'url' => base_url() . '/',
            'inLanguage' => 'en-PK',
            'publisher' => ['@id' => base_url() . '/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => ['@type' => 'EntryPoint', 'urlTemplate' => base_url() . '/search?q={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($__title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars($__description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="robots" content="<?= htmlspecialchars($__robots, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="theme-color" content="#0f172a" />
    <link rel="canonical" href="<?= htmlspecialchars($__canonical, ENT_QUOTES, 'UTF-8') ?>" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />

    <meta property="og:type" content="<?= htmlspecialchars($__ogType, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:site_name" content="<?= htmlspecialchars($__siteName, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:locale" content="en_PK" />
    <meta property="og:title" content="<?= htmlspecialchars($__title, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($__description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:url" content="<?= htmlspecialchars($__canonical, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:image" content="<?= htmlspecialchars($__ogImage, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= htmlspecialchars($__title, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($__description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:image" content="<?= htmlspecialchars($__ogImage, ENT_QUOTES, 'UTF-8') ?>" />

    <script type="application/ld+json"><?= json_encode($__siteSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
    @yield('schema')

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    @yield('extra_css')
</head>
<body>
    @include('components.navbar')
    
    @yield('content')
    
    @include('components.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('extra_js')
</body>
</html>
