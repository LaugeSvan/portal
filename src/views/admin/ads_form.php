<?php
declare(strict_types=1);
$isEdit = !empty($ad);
$pageTitle = ($isEdit ? 'Rediger annonce' : 'Ny annonce') . ' · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1><?= $isEdit ? 'Rediger annonce' : 'Ny annonce' ?></h1>
    <a href="/admin/ads" class="admin-btn admin-btn-secondary">← Tilbage</a>
</div>

<section class="admin-panel">
    <?php if (!empty($error)): ?>
        <p class="admin-error"><?= sanitize($error) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <div class="form-field">
            <label for="title">Titel/Navn <span class="required">*</span></label>
            <input type="text" id="title" name="title" required
                   value="<?= sanitize($ad['title'] ?? '') ?>">
        </div>

        <div class="form-field">
            <label for="link_url">Link URL</label>
            <input type="url" id="link_url" name="link_url" placeholder="https://..."
                   value="<?= sanitize($ad['link_url'] ?? '') ?>">
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="sort_order">Rækkefølge</label>
                <input type="number" id="sort_order" name="sort_order"
                       value="<?= (int)($ad['sort_order'] ?? 0) ?>">
            </div>

            <div class="form-field form-field-checkbox" style="padding-top: 2rem;">
                <label>
                    <input type="checkbox" name="is_published" value="1"
                           <?= (!isset($ad['is_published']) || !empty($ad['is_published'])) ? 'checked' : '' ?>>
                    Aktiv
                </label>
            </div>
        </div>

        <div class="form-field">
            <label for="image">Billede <span class="required"><?= $isEdit ? '' : '*' ?></span></label>
            <?php if (!empty($ad['image_path'])): ?>
                <div class="current-image">
                    <img src="<?= sanitize($ad['image_path']) ?>" alt="Nuværende billede" style="max-height:120px; display: block; margin-bottom: 0.5rem;">
                    <p class="admin-muted">Upload et nyt billede for at erstatte det nuværende.</p>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-btn">
                <?= $isEdit ? 'Gem ændringer' : 'Opret annonce' ?>
            </button>
            <a href="/admin/ads" class="admin-btn admin-btn-secondary">Annuller</a>
        </div>
    </form>
</section>
