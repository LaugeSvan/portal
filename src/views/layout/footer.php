<?php
declare(strict_types=1);
?>
            </div> <!-- /.main-content -->

            <aside class="global-sidebar">
                <?php if (!empty($sponsors)): ?>
                    <div class="sidebar-sponsors">
                        <?php foreach ($sponsors as $sponsor): ?>
                            <div class="sidebar-sponsor-card">
                                <?php if ($sponsor['link_url']): ?>
                                    <a href="<?= sanitize($sponsor['link_url']) ?>" target="_blank" rel="noopener">
                                        <img src="<?= sanitize($sponsor['image_path']) ?>" alt="<?= sanitize($sponsor['title']) ?>" class="sponsor-image">
                                    </a>
                                <?php else: ?>
                                    <img src="<?= sanitize($sponsor['image_path']) ?>" alt="<?= sanitize($sponsor['title']) ?>" class="sponsor-image">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </aside>
        </div> <!-- /.global-layout -->
    </div> <!-- /.container -->
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-text">
            <p>&copy; <?= date('Y') ?> Bogø Portalen · En digital samlingsplads for øens fællesskab.</p>
        </div>
        <div class="footer-meta">
            <span>Udviklet til Bogø · Håndlavet uden tunge frameworks</span>
        </div>
        <div class="footer-admin">
            <?php if (isLoggedIn()): ?>
                <a href="/admin/dashboard" class="footer-admin-link">Admin</a>
            <?php else: ?>
                <a href="/admin" class="footer-admin-link">Admin</a>
            <?php endif; ?>
        </div>
    </div>
</footer>

<script src="/assets/js/main.js"></script>
</div> <!-- /.site-shell -->
</body>
</html>

