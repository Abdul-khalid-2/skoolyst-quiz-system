<?php
/**
 * Reusable pagination.
 *
 * Expects:
 *   $pagination - ['page' => int, 'pages' => int]
 *   $baseUrl    - URL of the list page (no query string)
 *   $query      - array of filters to keep in every link (page number is added here)
 */
$__page  = (int) ($pagination['page'] ?? 1);
$__pages = (int) ($pagination['pages'] ?? 1);
$__query = $query ?? [];

if ($__pages > 1):
    $__link = static function (int $p) use ($baseUrl, $__query): string {
        $params = $p > 1 ? array_merge($__query, ['page' => $p]) : $__query;
        return $baseUrl . ($params ? '?' . http_build_query($params) : '');
    };

    // First, last and two pages either side of the current one; gaps become an ellipsis.
    $__show = array_unique(array_filter(
        array_merge([1, $__pages], range(max(1, $__page - 2), min($__pages, $__page + 2))),
        static fn($n) => $n >= 1 && $n <= $__pages
    ));
    sort($__show);
?>
<nav aria-label="Pagination" class="sk-pagination mt-4">
    <ul class="pagination pagination-sm flex-wrap justify-content-center mb-0">
        <li class="page-item <?= $__page <= 1 ? 'disabled' : '' ?>">
            <?php if ($__page > 1): ?>
            <a class="page-link" href="<?= clean($__link($__page - 1)) ?>" rel="prev" aria-label="Previous page">&laquo; Prev</a>
            <?php else: ?>
            <span class="page-link">&laquo; Prev</span>
            <?php endif; ?>
        </li>
        <?php $__prev = 0; foreach ($__show as $__n): ?>
            <?php if ($__prev && $__n - $__prev > 1): ?>
            <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
            <?php endif; ?>
            <li class="page-item <?= $__n === $__page ? 'active' : '' ?>">
                <a class="page-link" href="<?= clean($__link($__n)) ?>"<?= $__n === $__page ? ' aria-current="page"' : '' ?>><?= $__n ?></a>
            </li>
        <?php $__prev = $__n; endforeach; ?>
        <li class="page-item <?= $__page >= $__pages ? 'disabled' : '' ?>">
            <?php if ($__page < $__pages): ?>
            <a class="page-link" href="<?= clean($__link($__page + 1)) ?>" rel="next" aria-label="Next page">Next &raquo;</a>
            <?php else: ?>
            <span class="page-link">Next &raquo;</span>
            <?php endif; ?>
        </li>
    </ul>
</nav>
<?php endif; ?>
