<?php
declare(strict_types=1);

namespace Skoolyst\Services;

class AdService {
    public static function getAd(string $placementCode): ?array {
        $cacheFile = self::cachePath($placementCode);

        if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < (int) config('ads.cache_ttl', 30)) {
            $cached = json_decode((string) file_get_contents($cacheFile), true);
            if (is_array($cached)) {
                return $cached['ad'] ?? null;
            }
        }

        $result = self::fetch($placementCode);

        if ($result === false) {
            // Transport-level failure — never cache it, so the next request retries.
            return null;
        }

        file_put_contents($cacheFile, json_encode(['ad' => $result]));
        return $result;
    }

    public static function placementCode(string $slot): ?string {
        return config('ads.placements')[$slot] ?? null;
    }

    public static function imageUrl(?string $path): ?string {
        if (!$path) return null;
        if (preg_match('#^https?://#i', $path)) return $path;

        $base = preg_replace('#/api/v\d+/?$#', '', (string) config('ads.base_url'));
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }

    public static function trackImpression(string $adId): void {
        self::track('impression', $adId);
    }

    public static function trackClick(string $adId): void {
        self::track('click', $adId);
    }

    private static function track(string $event, string $adId): void {
        $baseUrl = config('ads.base_url');
        $apiKey = config('ads.api_key');
        if (!$baseUrl || !$apiKey) return;

        $ch = curl_init(rtrim($baseUrl, '/') . '/ads/' . $adId . '/' . $event);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $apiKey]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Returns the raw ad array on a successful call (which may be null if no ad
     * matched), or false to signal a transport-level failure that must not be cached.
     */
    private static function fetch(string $placementCode): array|false|null {
        $baseUrl = config('ads.base_url');
        $apiKey = config('ads.api_key');
        if (!$baseUrl || !$apiKey) return false;

        $url = rtrim($baseUrl, '/') . '/ads/serve?placement=' . urlencode($placementCode);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $apiKey]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($errno !== 0 || $status < 200 || $status >= 300) {
            return false;
        }

        $decoded = json_decode((string) $response, true);
        if (!is_array($decoded) || empty($decoded['success'])) {
            return false;
        }

        return $decoded['data']['ad'] ?? null;
    }

    private static function cachePath(string $placementCode): string {
        return sys_get_temp_dir() . '/skoolyst_ad_' . md5($placementCode) . '.json';
    }
}
