<?php
declare(strict_types=1);
$pageTitle = 'Rediger sektion · Bogø Portalen Admin';
$pageLabels = [
    'det-sker'          => 'Det sker',
    'om-bogoe'          => 'Om Bogø',
    'om-bogoe-portalen' => 'Om Bogø Portalen',
    'foreninger'        => 'Foreninger',
    'nyheder'           => 'Nyheder',
];
?>
<div class="admin-page-head">
    <h1>Rediger sektion</h1>
    <a href="/admin/pages" class="admin-btn admin-btn-secondary">← Tilbage</a>
</div>

<section class="admin-panel">
    <?php if (!empty($error)): ?>
        <p class="admin-error"><?= sanitize($error) ?></p>
    <?php endif; ?>

    <p class="admin-muted" style="margin:0 0 1rem;">
        Side: <strong style="color:var(--admin-text)"><?= sanitize($pageLabels[(string)$pageSlug] ?? (string)$pageSlug) ?></strong>
        &nbsp;·&nbsp;
        Sektion: <strong style="color:var(--admin-text)"><?= sanitize($sectionKey) ?></strong>
    </p>

    <form method="post" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <div class="form-field">
            <label for="content">Indhold</label>
            <textarea id="content" name="content" rows="14"><?= sanitize($section['content'] ?? '') ?></textarea>
            <span class="admin-muted" style="font-size:0.78rem;">HTML er tilladt.</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-btn">Gem ændringer</button>
            <a href="/admin/pages" class="admin-btn admin-btn-secondary">Annuller</a>
        </div>
    </form>
</section>