<?php
declare(strict_types=1);
$pageTitle = 'Nyheder · Bogø Portalen';
?>
<section class="page-head">
    <h1>Nyheder</h1>
    <div class="prose">
        <p class="page-intro">
            <?= sanitize(getPageContent('nyheder', 'intro') ?: 'Seneste nyt fra Bogø og lokalsamfundet.') ?>
        </p>
    </div>
</section>

<?php if (empty($news)): ?>
    <div class="empty-state">
        <div class="empty-card">
            <p>Indhold til denne side er endnu ikke tilføjet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="news-list" style="margin-top:2rem;display:flex;flex-direction:column;gap:1.5rem;">
        <?php foreach ($news as $article): ?>
            <article class="card news-card">
                <?php if (!empty($article['image_path'])): ?>
                    <img src="<?= sanitize($article['image_path']) ?>"
                         alt="<?= sanitize($article['title']) ?>"
                         style="width:100%;max-height:260px;object-fit:cover;border-radius:10px;margin-bottom:0.8rem;">
                <?php endif; ?>
                <header>
                    <h3><?= sanitize($article['title']) ?></h3>
                    <p class="meta">
                        <?php if (!empty($article['author'])): ?>
                            <?= sanitize($article['author']) ?> ·
                        <?php endif; ?>
                        <?= date('d. F Y', strtotime($article['published_at'] ?? $article['created_at'])) ?>
                    </p>
                </header>
                <?php if (!empty($article['body'])): ?>
                    <div class="prose" style="margin-top:0.5rem;">
                        <?= nl2br(sanitize($article['body'])) ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>