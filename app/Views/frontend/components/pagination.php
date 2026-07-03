<?php
/**
 * Pagination Component
 * Usage: require with $pagination array from BaseController::paginate()
 */
$p = $pagination ?? [];
if (empty($p) || $p['last_page'] <= 1) return;

$current   = $p['current_page'];
$last      = $p['last_page'];
$baseUrl   = strtok($_SERVER['REQUEST_URI'], '?');
$range     = 2; // pages either side of current

function pageUrl(string $base, int $page): string {
    $params = $_GET;
    $params['page'] = $page;
    unset($params['']); // safety
    return $base . '?' . http_build_query($params);
}
?>
<nav aria-label="Pagination" class="flex items-center justify-between gap-4 flex-wrap">
    <p class="text-sm text-gray-500">
        Menampilkan <strong><?= e((string)$p['from']) ?></strong>–<strong><?= e((string)$p['to']) ?></strong>
        dari <strong><?= e((string)$p['total']) ?></strong> data
    </p>

    <div class="pagination" role="list">
        <!-- Prev -->
        <?php if ($current <= 1): ?>
            <span class="page-link disabled" aria-disabled="true" aria-label="Halaman sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </span>
        <?php else: ?>
            <a href="<?= e(pageUrl($baseUrl, $current - 1)) ?>" class="page-link" aria-label="Halaman sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        <?php endif; ?>

        <!-- First page -->
        <?php if ($current > $range + 1): ?>
            <a href="<?= e(pageUrl($baseUrl, 1)) ?>" class="page-link" role="listitem">1</a>
            <?php if ($current > $range + 2): ?>
                <span class="page-link disabled">…</span>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Page range -->
        <?php for ($i = max(1, $current - $range); $i <= min($last, $current + $range); $i++): ?>
            <?php if ($i === $current): ?>
                <span class="page-link active" aria-current="page" role="listitem"><?= e((string)$i) ?></span>
            <?php else: ?>
                <a href="<?= e(pageUrl($baseUrl, $i)) ?>" class="page-link" role="listitem"><?= e((string)$i) ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- Last page -->
        <?php if ($current < $last - $range): ?>
            <?php if ($current < $last - $range - 1): ?>
                <span class="page-link disabled">…</span>
            <?php endif; ?>
            <a href="<?= e(pageUrl($baseUrl, $last)) ?>" class="page-link" role="listitem"><?= e((string)$last) ?></a>
        <?php endif; ?>

        <!-- Next -->
        <?php if ($current >= $last): ?>
            <span class="page-link disabled" aria-disabled="true" aria-label="Halaman berikutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7 7 7"/></svg>
            </span>
        <?php else: ?>
            <a href="<?= e(pageUrl($baseUrl, $current + 1)) ?>" class="page-link" aria-label="Halaman berikutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7 7 7"/></svg>
            </a>
        <?php endif; ?>
    </div>
</nav>
