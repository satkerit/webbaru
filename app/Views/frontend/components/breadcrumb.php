<?php
/**
 * Breadcrumb Component
 * Usage: require with $breadcrumbs = [['label'=>'Home','url'=>'/'], ['label'=>'Tentang Kami','url'=>'/tentang-kami'], ['label'=>'Visi Misi']]
 */
$breadcrumbs = $breadcrumbs ?? [];
if (empty($breadcrumbs)) return;
?>
<nav aria-label="Breadcrumb" class="breadcrumb">
    <?php foreach ($breadcrumbs as $i => $crumb): ?>
        <?php $isLast = ($i === count($breadcrumbs) - 1); ?>
        <?php if (!$isLast && !empty($crumb['url'])): ?>
            <a href="<?= e($crumb['url']) ?>"><?= e($crumb['label']) ?></a>
            <span class="breadcrumb-sep" aria-hidden="true">
                <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        <?php else: ?>
            <span class="breadcrumb-current" aria-current="page"><?= e($crumb['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
