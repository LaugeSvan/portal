<?php
declare(strict_types=1);
$isEdit = !empty($user);
$pageTitle = ($isEdit ? 'Rediger bruger' : 'Ny bruger') . ' · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1><?= $isEdit ? 'Rediger bruger' : 'Ny bruger' ?></h1>
    <a href="/admin/users" class="admin-btn admin-btn-secondary">← Tilbage</a>
</div>

<section class="admin-panel">
    <?php if (!empty($error)): ?>
        <p class="admin-error"><?= sanitize($error) ?></p>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <div class="form-row">
            <div class="form-field">
                <label for="username">Brugernavn <span class="required">*</span></label>
                <input type="text" id="username" name="username" required
                       value="<?= sanitize($user['username'] ?? '') ?>">
            </div>

            <div class="form-field">
                <label for="email">E-mail <span class="required">*</span></label>
                <input type="email" id="email" name="email" required
                       value="<?= sanitize($user['email'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="password">
                    Adgangskode <?= $isEdit ? '<span class="admin-muted">(lad stå tom for at beholde)</span>' : '<span class="required">*</span>' ?>
                </label>
                <input type="password" id="password" name="password"
                       <?= $isEdit ? '' : 'required' ?>>
            </div>

            <div class="form-field">
                <label for="role">Rolle</label>
                <select id="role" name="role">
                    <option value="editor" <?= ($user['role'] ?? 'editor') === 'editor' ? 'selected' : '' ?>>Editor</option>
                    <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <?php if (isSudoAdmin()): ?>
                        <option value="sudoadmin" <?= ($user['role'] ?? '') === 'sudoadmin' ? 'selected' : '' ?>>Sudo Admin</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="admin-btn">
                <?= $isEdit ? 'Gem ændringer' : 'Opret bruger' ?>
            </button>
            <a href="/admin/users" class="admin-btn admin-btn-secondary">Annuller</a>
        </div>
    </form>
</section>