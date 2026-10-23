<div class="sk-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a></li>
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['label'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>
<?php
$__bcItems = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')]];
foreach ($breadcrumbs as $__i => $__bc) {
    $__item = ['@type' => 'ListItem', 'position' => $__i + 2, 'name' => (string) $__bc['label']];
    if (!empty($__bc['url']) && $__bc['url'] !== '#') {
        $__item['item'] = $__bc['url'];
    } else {
        $__item['item'] = canonical_url();
    }
    $__bcItems[] = $__item;
}
?>
<script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $__bcItems], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
