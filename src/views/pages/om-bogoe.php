<?php
declare(strict_types=1);
$pageTitle = 'Om Bogø · Bogø Portalen';
?>
<section class="page-head">
    <h1>Om Bogø</h1>
    <p class="page-intro">
        <?= sanitize(getPageContent('om-bogoe', 'intro') ?: 'Bogø er en lille ø i det sydlige Danmark, forbundet med Møn via en dæmning. Her bor et aktivt lokalsamfund med stærke fællesskaber og smuk natur.') ?>
    </p>
</section>

<section class="page-body">
    <?php
    $content = getPageContent('om-bogoe', 'main');
    if ($content): ?>
        <div class="prose"><?= strip_tags($content, '<h2><h3><h4><p><br><strong><em><ul><ol><li><a><hr>') ?></div>
    <?php else: ?>
        <div class="empty-card">
            <p>Indhold til denne side er endnu ikke tilføjet.</p>
        </div>
    <?php endif; ?>
</section>