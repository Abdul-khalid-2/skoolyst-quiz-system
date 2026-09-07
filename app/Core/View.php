<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class View {
    private static array $sections = [];
    private static array $sectionStack = [];
    private static ?string $pendingExtends = null;

    public static function render(string $view, array $data = []): void {
        echo self::renderToString($view, $data);
    }

    public static function renderToString(string $view, array $data = []): string {
        self::$sections = [];
        self::$sectionStack = [];
        self::$pendingExtends = null;

        $content = self::evaluate($view, $data);

        while (self::$pendingExtends !== null) {
            $layout = self::$pendingExtends;
            self::$pendingExtends = null;
            $content = self::evaluate($layout, $data);
        }

        return $content;
    }

    public static function renderInclude(string $view, array $data = []): string {
        return self::evaluate($view, $data);
    }

    // --- Runtime support called from compiled templates ---

    public static function setExtends(string $layout): void {
        self::$pendingExtends = $layout;
    }

    public static function startSection(string $name): void {
        self::$sectionStack[] = $name;
        ob_start();
    }

    public static function endSection(): void {
        $name = array_pop(self::$sectionStack);
        self::$sections[$name] = ob_get_clean();
    }

    public static function setSection(string $name, mixed $value): void {
        self::$sections[$name] = (string) $value;
    }

    public static function yieldSection(string $name, string $default = ''): string {
        return self::$sections[$name] ?? $default;
    }

    public static function iterate(iterable $items): \Generator {
        $items = is_array($items) ? $items : iterator_to_array($items);
        $count = count($items);
        $i = 0;
        foreach ($items as $key => $item) {
            $i++;
            $loop = new \stdClass();
            $loop->index = $i - 1;
            $loop->iteration = $i;
            $loop->count = $count;
            $loop->first = $i === 1;
            $loop->last = $i === $count;
            yield [$loop, $key, $item];
        }
    }

    // --- Compilation ---

    private static function evaluate(string $view, array $data): string {
        $file = self::path($view);
        if (!is_file($file)) throw new \RuntimeException("View not found: {$view}");

        $php = self::compile(file_get_contents($file));
        $cache = self::cacheFile($view, $php);

        extract($data);
        ob_start();
        include $cache;
        return ob_get_clean();
    }

    private static function path(string $view): string {
        return dirname(__DIR__, 2) . '/resources/views/' . str_replace('.', '/', $view) . '.php';
    }

    private static function cacheFile(string $view, string $php): string {
        $dir = dirname(__DIR__, 2) . '/storage/cache/views';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $name = str_replace(['/', '.'], '_', $view) . '_' . md5($php) . '.php';
        $file = $dir . '/' . $name;
        if (!is_file($file)) file_put_contents($file, $php);
        return $file;
    }

    private static function compile(string $tpl): string {
        $tpl = preg_replace(
            "/@extends\\(\\s*'([^']+)'\\s*\\)/",
            "<?php \\Skoolyst\\Core\\View::setExtends('$1'); ?>",
            $tpl
        );

        $tpl = self::compileBalancedDirective($tpl, 'include', fn($args) => "<?= \\Skoolyst\\Core\\View::renderInclude({$args}) ?>");

        $tpl = preg_replace_callback(
            "/@section\\(\\s*'([^']+)'\\s*,\\s*(.+?)\\)/",
            fn($m) => "<?php \\Skoolyst\\Core\\View::setSection('{$m[1]}', {$m[2]}); ?>",
            $tpl
        );

        $tpl = preg_replace_callback(
            "/@section\\(\\s*'([^']+)'\\s*\\)/",
            fn($m) => "<?php \\Skoolyst\\Core\\View::startSection('{$m[1]}'); ?>",
            $tpl
        );
        $tpl = str_replace('@endsection', "<?php \\Skoolyst\\Core\\View::endSection(); ?>", $tpl);

        $tpl = preg_replace_callback(
            "/@yield\\(\\s*'([^']+)'\\s*(?:,\\s*'([^']*)')?\\s*\\)/",
            fn($m) => "<?= \\Skoolyst\\Core\\View::yieldSection('{$m[1]}', '" . ($m[2] ?? '') . "') ?>",
            $tpl
        );

        $tpl = preg_replace_callback(
            "/@foreach\\(\\s*(.+?)\\s+as\\s+(?:(\\\$[a-zA-Z_][a-zA-Z0-9_]*)\\s*=>\\s*)?(\\\$[a-zA-Z_][a-zA-Z0-9_]*)\\s*\\)/",
            function ($m) {
                $keyVar = $m[2] !== '' ? $m[2] : '$__key';
                return "<?php foreach (\\Skoolyst\\Core\\View::iterate({$m[1]}) as [\$loop, {$keyVar}, {$m[3]}]): ?>";
            },
            $tpl
        );
        $tpl = str_replace('@endforeach', '<?php endforeach; ?>', $tpl);

        $tpl = self::compileBalancedDirective($tpl, 'if', fn($args) => "<?php if ({$args}): ?>");
        $tpl = self::compileBalancedDirective($tpl, 'elseif', fn($args) => "<?php elseif ({$args}): ?>");
        $tpl = str_replace('@else', '<?php else: ?>', $tpl);
        $tpl = str_replace('@endif', '<?php endif; ?>', $tpl);

        $tpl = preg_replace_callback(
            "/\\{\\{\\s*(.+?)\\s*\\}\\}/s",
            fn($m) => "<?= htmlspecialchars((string)({$m[1]}), ENT_QUOTES, 'UTF-8') ?>",
            $tpl
        );

        return $tpl;
    }

    private static function compileBalancedDirective(string $tpl, string $directive, callable $wrap): string {
        $out = '';
        $pos = 0;
        $needle = '@' . $directive . '(';

        while (($p = strpos($tpl, $needle, $pos)) !== false) {
            $out .= substr($tpl, $pos, $p - $pos);
            $openParen = $p + strlen('@' . $directive);
            $close = self::findMatchingParen($tpl, $openParen);

            if ($close === -1) {
                $out .= substr($tpl, $p);
                $pos = strlen($tpl);
                break;
            }

            $args = substr($tpl, $openParen + 1, $close - $openParen - 1);
            $out .= $wrap($args);
            $pos = $close + 1;
        }

        $out .= substr($tpl, $pos);
        return $out;
    }

    private static function findMatchingParen(string $s, int $openPos): int {
        $depth = 0;
        $inString = false;
        $len = strlen($s);

        for ($i = $openPos; $i < $len; $i++) {
            $ch = $s[$i];
            if ($inString) {
                if ($ch === '\\') { $i++; continue; }
                if ($ch === "'") { $inString = false; }
                continue;
            }
            if ($ch === "'") { $inString = true; continue; }
            if ($ch === '(') { $depth++; }
            elseif ($ch === ')') { $depth--; if ($depth === 0) return $i; }
        }

        return -1;
    }
}
