<?php
function auth_user(): ?array { return $_SESSION['user'] ?? null; }
function is_authenticated(): bool { return auth_user() !== null; }
function is_admin(): bool { return (auth_user()['role'] ?? null) === 'admin'; }

/**
 * "Return to where you were" support for login/register.
 *
 * `next` is only ever a same-site, server-relative path (e.g. /mock-tests/mdcat-1/take?x=1).
 * Anything else (other hosts, //evil.com, backslashes, control characters, login/register/auth
 * URLs that would cause a loop) is rejected, so this can never become an open redirect.
 */
function safe_next_url(?string $url): ?string {
    if ($url === null) return null;
    $url = trim($url);

    // Accept absolute URLs of this very site (e.g. output of route()) by reducing them to path + query.
    if (preg_match('#^https?://#i', $url)) {
        $parts = parse_url($url);
        $home = parse_url(route('home'));
        if (!$parts || empty($parts['host']) || strcasecmp($parts['host'], (string) ($home['host'] ?? '')) !== 0) {
            return null;
        }
        $url = ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');
    }

    if ($url === '' || strlen($url) > 500) return null;
    if ($url[0] !== '/' || str_starts_with($url, '//')) return null;
    if (str_contains($url, '\\') || preg_match('/[\x00-\x1F\x7F]/', $url)) return null;

    $path = rtrim((string) parse_url($url, PHP_URL_PATH), '/');
    foreach (['login', 'register', 'logout'] as $name) {
        if ($path === rtrim((string) parse_url(route($name), PHP_URL_PATH), '/')) return null;
    }
    if (preg_match('#/auth(/|$)#', $path)) return null;

    return $url;
}

/** The pending "go here after login", saved in the session by the login/register pages. */
function auth_next(): ?string {
    return safe_next_url($_SESSION['auth_next'] ?? null);
}

/** Where login/register links on the current page should send people back to. */
function auth_link_next(): ?string {
    return safe_next_url($_SERVER['REQUEST_URI'] ?? null) ?? auth_next();
}

function login_url(?string $next = null): string {
    $next = safe_next_url($next) ?? auth_link_next();
    return route('login') . ($next !== null ? '?next=' . rawurlencode($next) : '');
}

function register_url(?string $next = null): string {
    $next = safe_next_url($next) ?? auth_link_next();
    return route('register') . ($next !== null ? '?next=' . rawurlencode($next) : '');
}

/** Link for "Continue with Google/Skoolyst" ($routeName = 'auth.google' | 'auth.skoolyst'). */
function auth_provider_url(string $routeName): string {
    $next = auth_link_next();
    return route($routeName) . ($next !== null ? '?next=' . rawurlencode($next) : '');
}

/** Remember (or forget) the destination from the ?next= query on the login/register pages. */
function remember_auth_next(): void {
    $next = safe_next_url(isset($_GET['next']) ? (string) $_GET['next'] : null);
    if ($next !== null) {
        $_SESSION['auth_next'] = $next;
    } else {
        unset($_SESSION['auth_next']);
    }
}

/** After a successful login/registration: go back to the saved page, or home. */
function redirect_after_auth(): never {
    $next = auth_next();
    unset($_SESSION['auth_next']);
    \Skoolyst\Core\Response::redirect($next ?? route('home'));
}
