<?php
/**
 * TEMPORARY debug script — verifies the Skoolyst AdEngine (ads.skoolyst.com)
 * integration using the app's real config and AdService.
 * Upload to project root, open in browser, then DELETE when done.
 */

require __DIR__ . '/bootstrap/app.php';

use Skoolyst\Services\AdService;

header('Content-Type: text/plain');

echo "=== 1. Config (from config/ads.php + .env) ===\n";
$apiKey = (string) config('ads.api_key');
echo "base_url: " . config('ads.base_url') . "\n";
echo "api_key (first 12 chars): " . substr($apiKey, 0, 12) . "... (" . strlen($apiKey) . " chars total)\n";
echo "cache_ttl: " . config('ads.cache_ttl') . "s\n";
echo "placements: " . json_encode(config('ads.placements')) . "\n";

$placementSlot = $_GET['placement'] ?? 'home_top';
$placementCode = AdService::placementCode($placementSlot);

echo "\nTesting slot: '$placementSlot' -> placement code: '" . ($placementCode ?? '(none)') . "'\n";
echo "(pass ?placement=subject_top / test_type_top / mock_test_top to test another slot)\n";

if (!$placementCode) {
    echo "\nNo placement code configured for this slot. Check config/ads.php and .env.\n";
    exit;
}

echo "\n=== 2. Direct request with generous timeout (10s connect / 20s total) ===\n";
$url = rtrim(config('ads.base_url'), '/') . '/ads/serve?placement=' . urlencode($placementCode);
echo "URL: $url\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $apiKey]);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

$start = microtime(true);
$response = curl_exec($ch);
$elapsed = round(microtime(true) - $start, 2);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
$errno = curl_errno($ch);
curl_close($ch);

echo "Took: {$elapsed}s\n";
echo "HTTP status: $status\n";
echo "curl errno: $errno\n";
echo "curl error: " . ($error ?: '(none)') . "\n";

echo "\n=== 3. Raw response body ===\n";
echo $response . "\n";

echo "\n=== 4. Decoded ===\n";
$decoded = json_decode((string) $response, true);
var_dump($decoded);

echo "\n=== 5. Clearing cache file and calling AdService::getAd() ===\n";
$cacheFile = sys_get_temp_dir() . '/skoolyst_ad_' . md5($placementCode) . '.json';
if (is_file($cacheFile)) {
    unlink($cacheFile);
    echo "Deleted stale cache file: $cacheFile\n";
} else {
    echo "No cache file present at: $cacheFile\n";
}
$ad = AdService::getAd($placementCode);
var_dump($ad);

if ($ad) {
    echo "\nResolved image URL: " . AdService::imageUrl($ad['image_path'] ?? null) . "\n";
}

echo "\n=== 6. Verdict ===\n";
if ($errno !== 0) {
    echo "Still fails even with 20s timeout -> confirms a real, non-timeout network problem (not just 'too slow'). Re-check firewall/antivirus.\n";
} elseif ($status >= 200 && $status < 300) {
    if (!empty($decoded['success']) && array_key_exists('ad', $decoded['data'] ?? [])) {
        if ($decoded['data']['ad'] === null) {
            echo "API call succeeded but returned ad: null -> no ACTIVE ad is currently matched to placement '$placementCode' for this app on ads.skoolyst.com. Double-check the placement in Admin -> Connected Apps, and that an ad is created + active + in date range for it.\n";
        } else {
            echo "SUCCESS - real ad data returned. If step 5 above still shows NULL, clear the cache file listed above and retry.\n";
        }
    } else {
        echo "2xx response but missing 'success'/'data.ad' keys - response shape differs from what AdService.php expects. Compare step 3's raw body against the API docs and adjust AdService::fetch() accordingly.\n";
    }
} else {
    echo "Non-2xx status - check raw body in step 3 for the API's error message (invalid/expired API key, unknown placement, etc).\n";
}

echo "\n=== REMINDER: delete this file (ads_debug.php) once testing is done. ===\n";
