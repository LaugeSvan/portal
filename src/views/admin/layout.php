<?php
declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Bogø Portalen · Admin';
$currentPath = $currentPath ?? ($_SERVER['REQUEST_URI'] ?? '/admin');
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
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <span class="admin-logo">Bogø</span>
            <span class="admin-word">Portalen</span>
            <span class="admin-tag">Admin</span>
        </div>
        <?php if (isLoggedIn()): ?>
        <nav class="admin-nav">
            <ul>
                <li><a href="/admin/dashboard" class="<?= $currentPath === '/admin/dashboard' ? 'is-active' : '' ?>">Oversigt</a></li>
                <li><a href="/admin/events" class="<?= str_starts_with($currentPath, '/admin/events') ? 'is-active' : '' ?>">Begivenheder</a></li>
                <li><a href="/admin/news" class="<?= str_starts_with($currentPath, '/admin/news') ? 'is-active' : '' ?>">Nyheder</a></li>
                <li><a href="/admin/associations" class="<?= str_starts_with($currentPath, '/admin/associations') ? 'is-active' : '' ?>">Foreninger</a></li>
                <li><a href="/admin/pages" class="<?= str_starts_with($currentPath, '/admin/pages') ? 'is-active' : '' ?>">Sider</a></li>
                <?php if (isSudoAdmin()): ?>
                    <li><a href="/admin/users" class="<?= str_starts_with($currentPath, '/admin/users') ? 'is-active' : '' ?>">Brugere</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="admin-sidebar-footer">
            <span class="admin-user">
                <?= sanitize($_SESSION['username'] ?? '') ?>
                <?php if (!empty($_SESSION['role'])): ?>
                    · <?= sanitize($_SESSION['role']) ?>
                <?php endif; ?>
            </span>
            <a href="/admin/logout" class="admin-logout">Log ud</a>
        </div>
        <?php endif; ?>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-inner">
                <div class="breadcrumbs">
                    <a href="/det-sker">← Til forsiden</a>
                </div>
            </div>
        </header>

        <section class="admin-content">
            <?php include $viewFile; ?>
        </section>
    </main>
</div>

<script src="/assets/js/admin.js"></script>
</body>
</html>

