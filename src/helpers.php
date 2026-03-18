<?php
declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

function sanitize(string $input): string {
    return htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        redirect('/admin');
    }
}

function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(string $token): bool {
    if (empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function getPageContent(string $pageSlug, string $sectionKey): string {
    $pdo = getDB();
    $stmt = $pdo->prepare('SELECT content FROM page_content WHERE page_slug = :slug AND section_key = :section LIMIT 1');
    $stmt->execute([
        ':slug' => $pageSlug,
        ':section' => $sectionKey,
    ]);
    $row = $stmt->fetch();
    return $row['content'] ?? '';
}

function isSudoAdmin(): bool {
    return ($_SESSION['role'] ?? '') === 'sudoadmin';
}

function requireSudoAdmin(): void {
    if (!isSudoAdmin()) {
        http_response_code(403);
        echo '403 - Adgang nægtet';
        exit;
    }
}
