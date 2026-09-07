<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($appName) ?></title>
<style>
    body { font-family: system-ui, sans-serif; max-width: 640px; margin: 60px auto; padding: 0 20px; color: #1a1a2e; }
    h1 { margin-bottom: 4px; }
    .badge { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 13px; font-weight: 600; }
    .ok { background: #dcfce7; color: #166534; }
    .fail { background: #fee2e2; color: #991b1b; }
    ul { line-height: 1.9; }
    code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; }
</style>
</head>
<body>
    <h1><?= htmlspecialchars($appName) ?></h1>
    <p>Environment: <code><?= htmlspecialchars($appEnv) ?></code></p>

    <p>
        Database:
        <?php if ($dbConnected): ?>
            <span class="badge ok">connected</span>
        <?php else: ?>
            <span class="badge fail">not connected</span> — <?= htmlspecialchars($dbError ?? 'unknown error') ?>
        <?php endif; ?>
    </p>

    <p>The bootstrap, router, and view rendering are working. This is a placeholder home page — the full frontend (navbar, components, pages) is not yet wired up to this Core PHP engine.</p>
</body>
</html>
