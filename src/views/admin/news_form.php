<?php
declare(strict_types=1);
$isEdit = !empty($article);
$pageTitle = ($isEdit ? 'Rediger nyhed' : 'Ny nyhed') . ' · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1><?= $isEdit ? 'Rediger nyhed' : 'Ny nyhed' ?></h1>
    <a href="/admin/news" class="admin-btn admin-btn-secondary">← Tilbage</a>
</div>

<section class="admin-panel">
    <?php if (!empty($error)): ?>
        <p class="admin-error"><?= sanitize($error) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <div class="form-field">
            <label for="title">Titel <span class="required">*</span></label>
            <input type="text" id="title" name="title" required
                   value="<?= sanitize($article['title'] ?? '') ?>">
        </div>

        <div class="form-field">
            <label for="body">Indhold</label>
            <textarea id="body" name="body" rows="10"><?= sanitize($article['body'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="author">Forfatter</label>
                <input type="text" id="author" name="author"
                       value="<?= sanitize($article['author'] ?? '') ?>">
            </div>

            <div class="form-field">
                <label for="published_at">Publiceringsdato</label>
                <input type="date" id="published_at" name="published_at"
                       value="<?= sanitize($article['published_at'] ?? '') ?>">
            </div>
        </div>

        <div class="form-field form-field-checkbox">
            <label>
                <input type="checkbox" name="is_published" value="1"
                       <?= !empty($article['is_published']) ? 'checked' : '' ?>>
                Udgivet
            </label>
        </div>

        <div class="form-field">
            <label for="image">Billede</label>
            <?php if (!empty($article['image_path'])): ?>
                <div class="current-image">
                    <img src="<?= sanitize($article['image_path']) ?>" alt="Nuværende billede" style="max-height:120px;">
                    <p class="admin-muted">Upload et nyt billede for at erstatte det nuværende.</p>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-btn">
                <?= $isEdit ? 'Gem ændringer' : 'Opret nyhed' ?>
            </button>
            <a href="/admin/news" class="admin-btn admin-btn-secondary">Annuller</a>
        </div>
    </form>
</section>