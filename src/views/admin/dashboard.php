<?php
declare(strict_types=1);

$pageTitle = 'Oversigt · Bogø Portalen admin';
?>
<div class="admin-page-head">
    <h1>Oversigt</h1>
    <p>Et hurtigt overblik over indholdet på Bogø Portalen.</p>
</div>

<div class="admin-grid">
    <section class="admin-panel">
        <h2>Nøgletal</h2>
        <div class="stats-grid">
            <article class="stat-card">
                <span class="stat-label">Begivenheder</span>
                <span class="stat-value"><?= (int)($stats['events'] ?? 0) ?></span>
            </article>
            <article class="stat-card">
                <span class="stat-label">Nyheder</span>
                <span class="stat-value"><?= (int)($stats['news'] ?? 0) ?></span>
            </article>
            <article class="stat-card">
                <span class="stat-label">Foreninger</span>
                <span class="stat-value"><?= (int)($stats['associations'] ?? 0) ?></span>
            </article>
            <article class="stat-card">
                <span class="stat-label">Annoncer</span>
                <span class="stat-value"><?= (int)($stats['ads'] ?? 0) ?></span>
            </article>
            <article class="stat-card">
                <span class="stat-label">Admin-brugere</span>
                <span class="stat-value"><?= (int)($stats['users'] ?? 0) ?></span>
            </article>
        </div>
    </section>

    <section class="admin-panel">
        <h2>Seneste aktivitet</h2>
        <?php if (empty($activity)): ?>
            <p class="admin-muted">Ingen registreret aktivitet endnu.</p>
        <?php else: ?>
            <ul class="activity-list">
                <?php foreach ($activity as $row): ?>
                    <li>
                        <span class="who"><?= sanitize($row['username'] ?? 'System') ?></span>
                        <span class="what"><?= sanitize($row['action']) ?></span>
                        <?php if (!empty($row['entity_type'])): ?>
                            <span class="entity"><?= sanitize($row['entity_type']) ?></span>
                        <?php endif; ?>
                        <span class="when"><?= sanitize($row['created_at']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</div>

