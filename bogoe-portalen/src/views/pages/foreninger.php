<?php
declare(strict_types=1);
$pageTitle = 'Bogøs foreninger · Bogø Portalen';
?>
<section class="page-head">
    <h1>Bogøs foreninger</h1>
    <p class="page-intro">
        <?= sanitize(getPageContent('foreninger', 'intro') ?: 'Bogø har et rigt foreningsliv. Her finder du en oversigt over øens aktive foreninger og frivillige fællesskaber.') ?>
    </p>
</section>

<?php if (empty($associations)): ?>
    <div class="empty-state">
        <div class="empty-card">
            <p>Indhold til denne side er endnu ikke tilføjet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="cards-grid" style="margin-top:2rem;">
        <?php foreach ($associations as $assoc): ?>
            <article class="card">
                <?php if (!empty($assoc['logo_path'])): ?>
                    <img src="<?= sanitize($assoc['logo_path']) ?>"
                         alt="<?= sanitize($assoc['name']) ?> logo"
                         style="height:48px;object-fit:contain;margin-bottom:0.6rem;">
                <?php endif; ?>
                <h3><?= sanitize($assoc['name']) ?></h3>
                <?php if (!empty($assoc['description'])): ?>
                    <p><?= nl2br(sanitize($assoc['description'])) ?></p>
                <?php endif; ?>
                <div class="meta" style="margin-top:0.6rem;display:flex;flex-direction:column;gap:0.2rem;">
                    <?php if (!empty($assoc['contact_email'])): ?>
                        <span><a href="mailto:<?= sanitize($assoc['contact_email']) ?>" class="text-link"><?= sanitize($assoc['contact_email']) ?></a></span>
                    <?php endif; ?>
                    <?php if (!empty($assoc['contact_phone'])): ?>
                        <span><?= sanitize($assoc['contact_phone']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($assoc['website_url'])): ?>
                        <span><a href="<?= sanitize($assoc['website_url']) ?>" class="text-link" target="_blank" rel="noopener">Besøg hjemmeside</a></span>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>