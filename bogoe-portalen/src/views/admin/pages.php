<?php
declare(strict_types=1);
$pageTitle = 'Sider · Bogø Portalen Admin';

$pageLabels = [
    'det-sker'         => 'Det sker',
    'om-bogoe'         => 'Om Bogø',
    'om-bogoe-portalen'=> 'Om Bogø Portalen',
    'foreninger'       => 'Foreninger',
    'nyheder'          => 'Nyheder',
];
?>
<div class="admin-page-head">
    <h1>Sider</h1>
</div>

<div class="admin-pages-list">
    <?php if (empty($sections)): ?>
        <section class="admin-panel">
            <p class="admin-muted">Ingen sideindhold endnu. Indhold oprettes automatisk første gang en side gemmes.</p>
        </section>
    <?php else: ?>
        <?php foreach ($sections as $slug => $pageSections): ?>
            <section class="admin-panel" style="margin-bottom:1rem;">
                <h2><?= sanitize($pageLabels[$slug] ?? $slug) ?></h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sektion</th>
                            <th>Type</th>
                            <th>Sidst opdateret</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pageSections as $section): ?>
                            <tr>
                                <td><?= sanitize($section['section_key']) ?></td>
                                <td><span class="badge badge-draft"><?= sanitize($section['content_type']) ?></span></td>
                                <td><?= sanitize($section['updated_at']) ?></td>
                                <td class="admin-table-actions">
                                    <a href="/admin/pages/edit?page=<?= urlencode($section['page_slug']) ?>&section=<?= urlencode($section['section_key']) ?>"
                                       class="admin-btn admin-btn-sm">Rediger</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</div>