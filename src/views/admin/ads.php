<?php
declare(strict_types=1);
$pageTitle = 'Annoncer · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1>Annoncer</h1>
    <a href="/admin/ads/create" class="admin-btn">+ Ny annonce</a>
</div>

<section class="admin-panel">
    <?php if (empty($ads)): ?>
        <p class="admin-muted">Ingen annoncer endnu.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Billede</th>
                    <th>Titel</th>
                    <th>Link</th>
                    <th>Rækkefølge</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td>
                            <?php if ($ad['image_path']): ?>
                                <img src="<?= sanitize($ad['image_path']) ?>" alt="" style="max-height: 50px; border-radius: 4px;">
                            <?php else: ?>
                                <span class="admin-muted">–</span>
                            <?php endif; ?>
                        </td>
                        <td><?= sanitize($ad['title']) ?></td>
                        <td>
                            <?php if ($ad['link_url']): ?>
                                <a href="<?= sanitize($ad['link_url']) ?>" target="_blank" class="admin-link"><?= sanitize($ad['link_url']) ?></a>
                            <?php else: ?>
                                <span class="admin-muted">–</span>
                            <?php endif; ?>
                        </td>
                        <td><?= (int)$ad['sort_order'] ?></td>
                        <td>
                            <?php if ($ad['is_published']): ?>
                                <span class="badge badge-published">Aktiv</span>
                            <?php else: ?>
                                <span class="badge badge-draft">Inaktiv</span>
                            <?php endif; ?>
                        </td>
                        <td class="admin-table-actions">
                            <a href="/admin/ads/edit?id=<?= (int)$ad['id'] ?>" class="admin-btn admin-btn-sm">Rediger</a>
                            <form method="post" action="/admin/ads/delete" onsubmit="return confirm('Slet denne annonce?')">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                <input type="hidden" name="id" value="<?= (int)$ad['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Slet</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
