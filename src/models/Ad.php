<?php
declare(strict_types=1);

class Ad
{
    public static function all(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM ads ORDER BY sort_order ASC, created_at DESC');
        return $stmt->fetchAll();
    }

    public static function published(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM ads WHERE is_published = 1 ORDER BY sort_order ASC, created_at DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM ads WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('INSERT INTO ads (title, image_path, link_url, is_published, sort_order)
            VALUES (:title, :image_path, :link_url, :is_published, :sort_order)');
        $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':image_path' => $data['image_path'] ?? '',
            ':link_url' => $data['link_url'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':sort_order' => (int)($data['sort_order'] ?? 0),
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('UPDATE ads SET
            title = :title,
            image_path = :image_path,
            link_url = :link_url,
            is_published = :is_published,
            sort_order = :sort_order
            WHERE id = :id');
        $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':image_path' => $data['image_path'] ?? '',
            ':link_url' => $data['link_url'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':sort_order' => (int)($data['sort_order'] ?? 0),
            ':id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('DELETE FROM ads WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
