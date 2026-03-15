<?php
declare(strict_types=1);
$isEdit = !empty($event);
$pageTitle = ($isEdit ? 'Rediger begivenhed' : 'Ny begivenhed') . ' · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1><?= $isEdit ? 'Rediger begivenhed' : 'Ny begivenhed' ?></h1>
    <a href="/admin/events" class="admin-btn admin-btn-secondary">← Tilbage</a>
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
                   value="<?= sanitize($event['title'] ?? '') ?>">
        </div>

        <div class="form-field">
            <label for="description">Beskrivelse</label>
            <textarea id="description" name="description" rows="5"><?= sanitize($event['description'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="event_date">Dato</label>
                <input type="date" id="event_date" name="event_date"
                       value="<?= sanitize($event['event_date'] ?? '') ?>">
            </div>

            <div class="form-field">
                <label for="recurring">Gentagelse</label>
                <select id="recurring" name="recurring">
                    <?php foreach (['none' => 'Ingen', 'daily' => 'Daglig', 'weekly' => 'Ugentlig', 'monthly' => 'Månedlig', 'yearly' => 'Årlig'] as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($event['recurring'] ?? 'none') === $val ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="location">Sted</label>
                <input type="text" id="location" name="location"
                       value="<?= sanitize($event['location'] ?? '') ?>">
            </div>

            <div class="form-field">
                <label for="external_url">Ekstern URL</label>
                <input type="url" id="external_url" name="external_url"
                       value="<?= sanitize($event['external_url'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="sort_order">Rækkefølge</label>
                <input type="number" id="sort_order" name="sort_order" min="0"
                       value="<?= (int)($event['sort_order'] ?? 0) ?>">
            </div>

            <div class="form-field form-field-checkbox">
                <label>
                    <input type="checkbox" name="is_published" value="1"
                           <?= !empty($event['is_published']) ? 'checked' : '' ?>>
                    Udgivet
                </label>
            </div>
        </div>

        <div class="form-field">
            <label for="image">Billede</label>
            <?php if (!empty($event['image_path'])): ?>
                <div class="current-image">
                    <img src="<?= sanitize($event['image_path']) ?>" alt="Nuværende billede" style="max-height:120px;">
                    <p class="admin-muted">Upload et nyt billede for at erstatte det nuværende.</p>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-btn">
                <?= $isEdit ? 'Gem ændringer' : 'Opret begivenhed' ?>
            </button>
            <a href="/admin/events" class="admin-btn admin-btn-secondary">Annuller</a>
        </div>
    </form>
</section>