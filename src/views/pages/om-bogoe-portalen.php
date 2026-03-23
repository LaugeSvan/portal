<?php
declare(strict_types=1);
$pageTitle = 'Om Bogø Portalen · Bogø Portalen';
?>
<section class="page-head">
    <h1>Om Bogø Portalen</h1>
    <p class="page-intro">
        <?= getPageContent('om-bogoe-portalen', 'intro') ?: 'Bogø Portalen er en digital samlingsplads for øens fællesskab – her samles nyheder, begivenheder og foreninger på ét sted.' ?>
    </p>
</section>

<section class="page-body">
    <?php
    $content = getPageContent('om-bogoe-portalen', 'main');
    if ($content): ?>
        <div class="prose"><?= $content ?></div>
    <?php else: ?>
        <div class="empty-card">
            <p>Indhold til denne side er endnu ikke tilføjet.</p>
        </div>
    <?php endif; ?>
</section>