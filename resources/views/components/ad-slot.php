<?php
$__adPlacementCode = \Skoolyst\Services\AdService::placementCode($placement ?? '');
$__ad = $__adPlacementCode ? \Skoolyst\Services\AdService::getAd($__adPlacementCode) : null;

if (!$__ad) return;

$__adImage = \Skoolyst\Services\AdService::imageUrl($__ad['image_path'] ?? null);
$__adTitle = (string)($__ad['title'] ?? 'Advertisement');
$__adDescription = (string)($__ad['description'] ?? '');
$__adCta = (string)($__ad['cta_text'] ?? '');
$__adId = (string)($__ad['id'] ?? '');
$__adClickHref = $__adId
    ? route('ads.click', $__adId) . '?url=' . urlencode((string)($__ad['click_url'] ?? ''))
    : (string)($__ad['click_url'] ?? '#');
?>
<div class="sk-ad-slot">
    <a href="{{ $__adClickHref }}" target="_blank" rel="noopener sponsored" class="sk-ad-card">
        <span class="sk-ad-badge">Sponsored</span>
        @if($__adImage)
        <img src="{{ $__adImage }}" alt="{{ $__adTitle }}" class="sk-ad-thumb" loading="lazy" />
        @endif
        <div class="sk-ad-body">
            <h3 class="sk-ad-title">{{ $__adTitle }}</h3>
            @if($__adDescription)
            <p class="sk-ad-desc">{{ $__adDescription }}</p>
            @endif
            @if($__adCta)
            <span class="sk-ad-cta">{{ $__adCta }}</span>
            @endif
        </div>
    </a>
    @if($__adId)
    <img src="{{ route('ads.impression', $__adId) }}" alt="" width="1" height="1" class="sk-ad-pixel" />
    @endif
</div>
