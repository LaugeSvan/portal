<?php
declare(strict_types=1);

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/helpers.php';
require_once __DIR__ . '/../../src/models/User.php';

$pdo = getDB();
$hasUsers = (bool)$pdo->query('SELECT EXISTS(SELECT 1 FROM users) AS exists_flag')->fetch()['exists_flag'];

if ($hasUsers) {
    echo 'Opsætning er allerede gennemført. Slet venligst denne fil (public/admin/setup.php).';
    exit;
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Alle felter er påkrævet.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        User::create([
            'username' => $username,
            'email' => $email,
            'password_hash' => $hash,
            'role' => 'sudoadmin',  // ← was 'admin'
        ]);
        $success = 'Første administrator er oprettet. Du kan nu logge ind via /admin. Husk at slette denne fil (public/admin/setup.php).';
    }
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Første administrator · Bogø Portalen</title>
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
                <span class="login-sub">Første administrator</span>
            </div>
            <p>Opret den allerførste admin-bruger til Bogø Portalen.</p>
        </header>

        <?php if ($error): ?>
            <div class="login-alert"><?= sanitize($error) ?></div>
        <?php elseif ($success): ?>
            <div class="login-alert" style="border-color:#4ade80;background:rgba(22,163,74,0.12);color:#bbf7d0;">
                <?= sanitize($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
            <form method="post" class="login-form">
                <label class="field">
                    <span>Brugernavn</span>
                    <input type="text" name="username" required>
                </label>
                <label class="field">
                    <span>E-mail</span>
                    <input type="email" name="email" required>
                </label>
                <label class="field">
                    <span>Adgangskode</span>
                    <input type="password" name="password" required>
                </label>
                <button type="submit" class="btn-primary">Opret administrator</button>
            </form>
        <?php endif; ?>

        <footer class="login-footer">
            <p>Når du er færdig, bør du slette denne fil fra serveren.</p>
        </footer>
    </div>
</div>
</body>
</html>
