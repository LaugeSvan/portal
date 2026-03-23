<?php
declare(strict_types=1);

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/helpers.php';
require_once __DIR__ . '/../../src/models/User.php';

$pdo = getDB();
$hasUsers = (bool)$pdo->query('SELECT EXISTS(SELECT 1 FROM users) AS exists_flag')->fetch()['exists_flag'];

if ($hasUsers) {
    exit('Opsætning er allerede gennemført. Slet venligst mappen public/admin/.');
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username && $email && $password) {
        User::create([
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'sudoadmin',
        ]);
        $success = 'Første administrator oprettet! SLET NU mappen "public/admin/" for at systemet kan virke.';
    } else {
        $error = 'Alle felter skal udfyldes.';
    }
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Setup · Bogø Portalen</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <style>
        .setup-container { max-width: 400px; margin: 100px auto; padding: 20px; background: #1e293b; color: white; border-radius: 8px; }
        .setup-container input { width: 100%; margin: 10px 0; padding: 8px; border-radius: 4px; border: 1px solid #334155; background: #0f172a; color: white; }
        .setup-container button { width: 100%; padding: 10px; background: #3b82f6; border: none; color: white; border-radius: 4px; cursor: pointer; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 4px; background: #ef4444; }
        .alert-success { background: #10b981; }
    </style>
</head>
<body>
    <div class="setup-container">
        <h2>Første administrator</h2>
        <?php if ($error): ?><div class="alert"><?= sanitize($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= sanitize($success) ?></div>
        <?php else: ?>
            <form method="post">
                <input type="text" name="username" placeholder="Brugernavn" required autofocus>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Adgangskode" required>
                <button type="submit">Opret administrator</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
