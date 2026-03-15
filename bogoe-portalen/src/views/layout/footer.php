<?php
declare(strict_types=1);
?>
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

