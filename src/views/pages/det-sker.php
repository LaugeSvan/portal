<?php
declare(strict_types=1);

$pageTitle = 'Det sker på Bogø';
?>
<section class="page-head">
    <h1>Det sker på Bogø</h1>
    <div class="prose">
        <p class="page-intro">
            <?= sanitize(getPageContent('det-sker', 'intro') ?: 'Her samler vi store og små begivenheder på Bogø – fra loppemarkeder og naturformidling til festivaler og fællesspisninger.') ?>
        </p>
    </div>
</section>

<div class="events-container">
    <div class="events-main">
        <div class="section-heading">
            <h2>Kommende begivenheder</h2>
        </div>

        <?php if (empty($events)): ?>
            <div class="empty-state">
                <div class="empty-card">
                    <p>Indhold til denne side er endnu ikke tilføjet.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="cards-grid events-grid">
                <?php foreach ($events as $event): ?>
                    <article class="card event-card">
                        <header>
                            <h3><?= sanitize($event['title']) ?></h3>
                            <?php if (!empty($event['event_date'])): ?>
                                <p class="meta">
                                    <?= date('d. F Y', strtotime($event['event_date'])) ?>
                                </p>
                            <?php endif; ?>
                        </header>
                        <?php if (!empty($event['description'])): ?>
                            <p><?= nl2br(sanitize($event['description'])) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($event['location'])): ?>
                            <p class="meta meta-location"><?= sanitize($event['location']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($event['external_url'])): ?>
                            <p><a href="<?= sanitize($event['external_url']) ?>" class="text-link" target="_blank" rel="noopener">Læs mere</a></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="events-sidebar-extra">
        <div class="sidebar-card">
            <h2>Det kommer (snart)</h2>
            <p>Vi arbejder på at samle faste formater for:</p>
            <ul class="pill-list">
                <li>Det sker</li>
                <li>Naturformidling for børn</li>
                <li>Skaberglæde</li>
                <li>Loppeshopperoad</li>
                <li>Havblik</li>
                <li>Jazzfestival i Østerskov</li>
                <li>Grundlovsdag</li>
                <li>Repaircafe</li>
                <li>Juleteater i Bogø Mølle</li>
                <li>Halloween</li>
            </ul>
        </div>
        <div class="sidebar-card muted">
            <h3>Find mere på nettet</h3>
            <p>Indtil det hele bor her, finder du også aktiviteter via Møns fælles sider og lokale Facebook-grupper.</p>
        </div>
    </div>
</div>

 