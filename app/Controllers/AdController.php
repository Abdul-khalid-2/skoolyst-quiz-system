<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Services\AdService;

class AdController extends Controller {
    public function click(string $id): never {
        $rawUrl = (string) ($_GET['url'] ?? '');
        $sig = (string) ($_GET['sig'] ?? '');
        $valid = $rawUrl !== '' && hash_equals(AdService::signClick($id, $rawUrl), $sig);

        // Unsigned/forged links never redirect off-site (prevents use as an open redirect).
        if (!$valid) {
            Response::redirect('/');
        }

        $clickUrl = $this->sanitizeClickUrl($rawUrl);
        AdService::trackClick($id);
        Response::redirect($clickUrl ?: '/');
    }

    public function impression(string $id): never {
        AdService::trackImpression($id);
        header('Content-Type: image/gif');
        header('Cache-Control: no-store');
        echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBTAA7');
        exit;
    }

    private function sanitizeClickUrl(string $url): ?string {
        if ($url === '') return null;

        // Guard against malformed concatenated URLs (e.g. "https://x.inhttps://y.com")
        // by keeping only the last well-formed http(s) URL found in the string.
        if (preg_match_all('#https?://[^\s"\']+#i', $url, $matches) && !empty($matches[0])) {
            $url = end($matches[0]);
        }

        return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
    }
}
