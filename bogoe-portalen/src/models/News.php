<?php
declare(strict_types=1);

class News
{
    public static function all(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM news ORDER BY COALESCE(published_at, created_at) DESC');
        return $stmt->fetchAll();
    }

    public static function published(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM news WHERE is_published = 1 ORDER BY COALESCE(published_at, created_at) DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM news WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('INSERT INTO news (title, body, author, image_path, is_published, published_at)
            VALUES (:title, :body, :author, :image_path, :is_published, :published_at)');
        $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':body' => $data['body'] ?? null,
            ':author' => $data['author'] ?? null,
            ':image_path' => $data['image_path'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':published_at' => $data['published_at'] ?: null,
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('UPDATE news SET
            title = :title,
            body = :body,
            author = :author,
            image_path = :image_path,
            is_published = :is_published,
            published_at = :published_at
            WHERE id = :id');
        $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':body' => $data['body'] ?? null,
            ':author' => $data['author'] ?? null,
            ':image_path' => $data['image_path'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':published_at' => $data['published_at'] ?: null,
            ':id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('DELETE FROM news WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}

