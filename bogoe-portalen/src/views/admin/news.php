<?php
declare(strict_types=1);
$pageTitle = 'Nyheder · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1>Nyheder</h1>
    <a href="/admin/news/create" class="admin-btn">+ Ny nyhed</a>
</div>

<section class="admin-panel">
    <?php if (empty($news)): ?>
        <p class="admin-muted">Ingen nyheder endnu.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Forfatter</th>
                    <th>Udgivet</th>
                    <th>Dato</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news as $article): ?>
                    <tr>
                        <td><?= sanitize($article['title']) ?></td>
                        <td><?= $article['author'] ? sanitize($article['author']) : '<span class="admin-muted">–</span>' ?></td>
                        <td><?= $article['published_at'] ? sanitize($article['published_at']) : '<span class="admin-muted">–</span>' ?></td>
                        <td><?= sanitize($article['created_at']) ?></td>
                        <td>
                            <?php if ($article['is_published']): ?>
                                <span class="badge badge-published">Udgivet</span>
                            <?php else: ?>
                                <span class="badge badge-draft">Kladde</span>
                            <?php endif; ?>
                        </td>
                        <td class="admin-table-actions">
                            <a href="/admin/news/edit?id=<?= (int)$article['id'] ?>" class="admin-btn admin-btn-sm">Rediger</a>
                            <form method="post" action="/admin/news/delete" onsubmit="return confirm('Slet denne nyhed?')">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                <input type="hidden" name="id" value="<?= (int)$article['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Slet</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>