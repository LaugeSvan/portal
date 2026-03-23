<?php
declare(strict_types=1);

$currentPath = $currentPath ?? ($_SERVER['REQUEST_URI'] ?? '/');

function isActive(string $path, string $currentPath): string {
    return rtrim($currentPath, '/') === $path ? ' is-active' : '';
}
?>
<header class="site-header">
    <div class="container header-inner">
        <div class="brand">
            <a href="/det-sker" class="brand-link">
                <span class="brand-mark">Bogø</span>
                <span class="brand-word">Portalen</span>
            </a>
        </div>
        <button class="nav-toggle" aria-label="Åbn menu" aria-expanded="false">
            <span></span>
            <span></span>
        </button>
        <nav class="main-nav" aria-label="Hovedmenu">
            <ul>
                <li><a href="/det-sker" class="nav-link<?= isActive('/det-sker', $currentPath) ?>">Det sker</a></li>
                <li><a href="/om-bogoe" class="nav-link<?= isActive('/om-bogoe', $currentPath) ?>">Om Bogø</a></li>
                <li><a href="/om-bogoe-portalen" class="nav-link<?= isActive('/om-bogoe-portalen', $currentPath) ?>">Om Bogø Portalen</a></li>
                <li><a href="/foreninger" class="nav-link<?= isActive('/foreninger', $currentPath) ?>">Bogøs foreninger</a></li>
                <li><a href="/nyheder" class="nav-link<?= isActive('/nyheder', $currentPath) ?>">Nyheder</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="site-main">
    <div class="container">
        <div class="global-layout">
            <div class="main-content">
