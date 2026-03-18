<?php
declare(strict_types=1);
$pageTitle = 'Begivenheder · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1>Begivenheder</h1>
    <a href="/admin/events/create" class="admin-btn">+ Ny begivenhed</a>
</div>

<section class="admin-panel">
    <?php if (empty($events)): ?>
        <p class="admin-muted">Ingen begivenheder endnu.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Dato</th>
                    <th>Sted</th>
                    <th>Gentagelse</th>
                    <th>Status</th>
                    <th>Rækkefølge</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= sanitize($event['title']) ?></td>
                        <td><?= $event['event_date'] ? sanitize($event['event_date']) : '<span class="admin-muted">–</span>' ?></td>
                        <td><?= $event['location'] ? sanitize($event['location']) : '<span class="admin-muted">–</span>' ?></td>
                        <td><?= sanitize($event['recurring'] ?? 'none') ?></td>
                        <td>
                            <?php if ($event['is_published']): ?>
                                <span class="badge badge-published">Udgivet</span>
                            <?php else: ?>
                                <span class="badge badge-draft">Kladde</span>
                            <?php endif; ?>
                        </td>
                        <td><?= (int)$event['sort_order'] ?></td>
                        <td class="admin-table-actions">
                            <a href="/admin/events/edit?id=<?= (int)$event['id'] ?>" class="admin-btn admin-btn-sm">Rediger</a>
                            <form method="post" action="/admin/events/delete" onsubmit="return confirm('Slet denne begivenhed?')">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                <input type="hidden" name="id" value="<?= (int)$event['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Slet</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>