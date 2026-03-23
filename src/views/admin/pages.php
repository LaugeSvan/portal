<?php
declare(strict_types=1);
$pageTitle = 'Sider · Bogø Portalen Admin';

$pageStructure = [
    'om-bogoe' => [
        'label' => 'Om Bogø',
        'sections' => [
            'intro' => 'Kort intro (øverst)',
            'main'  => 'Hovedindhold (prose)',
        ]
    ],
    'om-bogoe-portalen' => [
        'label' => 'Om Bogø Portalen',
        'sections' => [
            'intro' => 'Kort intro (øverst)',
            'main'  => 'Hovedindhold (prose)',
        ]
    ],
];

// Flatten for easier lookup
$sectionsBySlug = [];
foreach ($sections as $slug => $pageSections) {
    foreach ($pageSections as $section) {
        $sectionsBySlug[$slug][$section['section_key']] = $section;
    }
}
?>
<div class="admin-page-head">
    <h1>Sider</h1>
</div>

<div class="admin-pages-list">
    <?php foreach ($pageStructure as $slug => $page): ?>
        <section class="admin-panel" style="margin-bottom:2rem;">
            <h2><?= sanitize($page['label']) ?></h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 250px;">Sektion</th>
                        <th>Sidst opdateret</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($page['sections'] as $key => $label): ?>
                        <?php $section = $sectionsBySlug[$slug][$key] ?? null; ?>
                        <tr>
                            <td>
                                <strong><?= sanitize($label) ?></strong><br>
                                <small class="admin-muted"><?= sanitize($key) ?></small>
                            </td>
                            <td>
                                <?php if ($section): ?>
                                    <?= sanitize($section['updated_at']) ?>
                                <?php else: ?>
                                    <span class="badge badge-draft">Ikke oprettet</span>
                                <?php endif; ?>
                            </td>
                            <td class="admin-table-actions">
                                <a href="/admin/pages/edit?page=<?= urlencode($slug) ?>&section=<?= urlencode($key) ?>"
                                   class="admin-btn admin-btn-sm">Rediger</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endforeach; ?>

    <?php
    // Show other sections that might exist in database but are not in pageStructure
    $otherSections = array_diff_key($sectionsBySlug, $pageStructure);
    if (!empty($otherSections)): ?>
        <h3 style="margin: 2rem 0 1rem; color: var(--admin-muted);">Andre sektioner (system)</h3>
        <?php foreach ($otherSections as $slug => $pageSections): ?>
            <section class="admin-panel" style="margin-bottom:1rem;">
                <h2><?= sanitize($slug) ?></h2>
                <table class="admin-table">
                    <tbody>
                        <?php foreach ($pageSections as $key => $section): ?>
                            <tr>
                                <td><?= sanitize($key) ?></td>
                                <td><?= sanitize($section['updated_at']) ?></td>
                                <td class="admin-table-actions">
                                    <a href="/admin/pages/edit?page=<?= urlencode($slug) ?>&section=<?= urlencode($key) ?>"
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