<?php
declare(strict_types=1);
$isEdit = !empty($association);
$pageTitle = ($isEdit ? 'Rediger forening' : 'Ny forening') . ' · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1><?= $isEdit ? 'Rediger forening' : 'Ny forening' ?></h1>
    <a href="/admin/associations" class="admin-btn admin-btn-secondary">← Tilbage</a>
</div>

<section class="admin-panel">
    <?php if (!empty($error)): ?>
        <p class="admin-error"><?= sanitize($error) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <div class="form-field">
            <label for="name">Navn <span class="required">*</span></label>
            <input type="text" id="name" name="name" required
                   value="<?= sanitize($association['name'] ?? '') ?>">
        </div>

        <div class="form-field">
            <label for="description">Beskrivelse</label>
            <textarea id="description" name="description" rows="5"><?= sanitize($association['description'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="contact_email">Kontakt e-mail</label>
                <input type="email" id="contact_email" name="contact_email"
                       value="<?= sanitize($association['contact_email'] ?? '') ?>">
            </div>

            <div class="form-field">
                <label for="contact_phone">Kontakt telefon</label>
                <input type="text" id="contact_phone" name="contact_phone"
                       value="<?= sanitize($association['contact_phone'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="website_url">Website URL</label>
                <input type="url" id="website_url" name="website_url"
                       value="<?= sanitize($association['website_url'] ?? '') ?>">
            </div>

            <div class="form-field">
                <label for="sort_order">Rækkefølge</label>
                <input type="number" id="sort_order" name="sort_order" min="0"
                       value="<?= (int)($association['sort_order'] ?? 0) ?>">
            </div>
        </div>

        <div class="form-field form-field-checkbox">
            <label>
                <input type="checkbox" name="is_published" value="1"
                       <?= !empty($association['is_published']) ? 'checked' : '' ?>>
                Udgivet
            </label>
        </div>

        <div class="form-field">
            <label for="logo">Logo</label>
            <?php if (!empty($association['logo_path'])): ?>
                <div class="current-image">
                    <img src="<?= sanitize($association['logo_path']) ?>" alt="Nuværende logo" style="max-height:80px;">
                    <p class="admin-muted">Upload et nyt logo for at erstatte det nuværende.</p>
                </div>
            <?php endif; ?>
            <input type="file" id="logo" name="logo" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-btn">
                <?= $isEdit ? 'Gem ændringer' : 'Opret forening' ?>
            </button>
            <a href="/admin/associations" class="admin-btn admin-btn-secondary">Annuller</a>
        </div>
    </form>
</section>