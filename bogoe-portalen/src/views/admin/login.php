<?php
declare(strict_types=1);

$pageTitle = 'Bogø Portalen · Admin login';
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-login-body">
<div class="login-shell">
    <div class="login-card">
        <header class="login-header">
            <div class="login-brand">
                <span class="login-mark">Bogø Portalen</span>
                <span class="login-sub">Administratorområde</span>
            </div>
            <p>Log ind for at redigere indholdet på Bogø Portalen.</p>
        </header>

        <?php if (!empty($error)): ?>
            <div class="login-alert">
                <?= sanitize($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" class="login-form">
            <input type="hidden" name="csrf_token" value="<?= sanitize($csrfToken ?? '') ?>">
            <label class="field">
                <span>Brugernavn</span>
                <input type="text" name="username" autocomplete="username" required>
            </label>
            <label class="field">
                <span>Adgangskode</span>
                <input type="password" name="password" autocomplete="current-password" required>
            </label>
            <button type="submit" class="btn-primary">Log ind</button>
        </form>

        <footer class="login-footer">
            <p>Første gang? Opret den første administrator via opsætningssiden.</p>
        </footer>
    </div>
</div>
</body>
</html>

