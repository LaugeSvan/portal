<?php
declare(strict_types=1);
$pageTitle = 'Brugere · Bogø Portalen Admin';
?>
<div class="admin-page-head">
    <h1>Brugere</h1>
    <a href="/admin/users/create" class="admin-btn">+ Ny bruger</a>
</div>

<section class="admin-panel">
    <?php if (empty($users)): ?>
        <p class="admin-muted">Ingen brugere fundet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Brugernavn</th>
                    <th>E-mail</th>
                    <th>Rolle</th>
                    <th>Oprettet</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= sanitize($u['username']) ?></td>
                        <td><?= sanitize($u['email']) ?></td>
                        <td>
                            <?php
                            $roleColors = [
                                'sudoadmin' => 'background:rgba(231,176,95,0.15);color:#e7b05f;border-color:rgba(231,176,95,0.3);',
                                'admin'     => 'background:rgba(20,184,166,0.15);color:#5eead4;border-color:rgba(20,184,166,0.3);',
                                'editor'    => '',
                            ];
                            $style = $roleColors[$u['role']] ?? '';
                            ?>
                            <span class="badge badge-draft" style="<?= $style ?>"><?= sanitize($u['role']) ?></span>
                        </td>
                        <td><?= sanitize($u['created_at']) ?></td>
                        <td class="admin-table-actions">
                            <?php $isSelf = (int)$u['id'] === (int)($_SESSION['user_id'] ?? 0); ?>
                            <a href="/admin/users/edit?id=<?= (int)$u['id'] ?>" class="admin-btn admin-btn-sm">Rediger</a>
                            <?php if (!$isSelf): ?>
                                <form method="post" action="/admin/users/delete" onsubmit="return confirm('Slet denne bruger?')">
                                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                                    <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Slet</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>