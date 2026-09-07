<?php
function csrf_token(): string { return $_SESSION['_csrf'] ??= bin2hex(random_bytes(32)); }
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrf_token()) . '">'; }
function csrf_verify(): bool { return isset($_POST['_csrf']) && hash_equals($_SESSION['_csrf'] ?? '', $_POST['_csrf']); }
