<?php
declare(strict_types=1);
$pageTitle = 'Foreninger · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1>Foreninger</h1>
    <a href="/admin/associations/create" class="admin-btn">+ Ny forening</a>
</div>

<section class="admin-panel">
    <?php if (empty($associations)): ?>
        <p class="admin-muted">Ingen foreninger endnu.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Navn</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Website</th>
                    <th>Status</th>
                    <th>Rækkefølge</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($associations as $assoc): ?>
                    <tr>
                        <td>
                            <?php if (!empty($assoc['logo_path'])): ?>
                                <img src="<?= sanitize($assoc['logo_path']) ?>" alt="" style="height:24px;width:24px;object-fit:contain;vertical-align:middle;margin-right:0.4rem;border-radius:3px;">
                            <?php endif; ?>
                            <?= sanitize($assoc['name']) ?>
                        </td>
                        <td><?= $assoc['contact_email'] ? sanitize($assoc['contact_email']) : '<span class="admin-muted">–</span>' ?></td>
                        <td><?= $assoc['contact_phone'] ? sanitize($assoc['contact_phone']) : '<span class="admin-muted">–</span>' ?></td>
                        <td>
                            <?php if ($assoc['website_url']): ?>
                                <a href="<?= sanitize($assoc['website_url']) ?>" target="_blank" rel="noopener" style="color:var(--admin-accent);">↗</a>
                            <?php else: ?>
                                <span class="admin-muted">–</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($assoc['is_published']): ?>
                                <span class="badge badge-published">Udgivet</span>
                            <?php else: ?>
                                <span class="badge badge-draft">Kladde</span>
                            <?php endif; ?>
                        </td>
                        <td><?= (int)$assoc['sort_order'] ?></td>
                        <td class="admin-table-actions">
                            <a href="/admin/associations/edit?id=<?= (int)$assoc['id'] ?>" class="admin-btn admin-btn-sm">Rediger</a>
                            <form method="post" action="/admin/associations/delete" onsubmit="return confirm('Slet denne forening?')">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                <input type="hidden" name="id" value="<?= (int)$assoc['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Slet</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>