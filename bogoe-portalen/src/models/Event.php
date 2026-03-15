<?php
declare(strict_types=1);

class Event
{
    public static function all(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM events ORDER BY sort_order ASC, event_date ASC, created_at DESC');
        return $stmt->fetchAll();
    }

    public static function publishedUpcoming(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query("SELECT * FROM events WHERE is_published = 1 ORDER BY sort_order ASC, event_date ASC, created_at DESC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM events WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('INSERT INTO events (title, description, event_date, recurring, location, external_url, image_path, is_published, sort_order)
            VALUES (:title, :description, :event_date, :recurring, :location, :external_url, :image_path, :is_published, :sort_order)');
        $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':description' => $data['description'] ?? null,
            ':event_date' => $data['event_date'] ?: null,
            ':recurring' => $data['recurring'] ?? 'none',
            ':location' => $data['location'] ?? null,
            ':external_url' => $data['external_url'] ?? null,
            ':image_path' => $data['image_path'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':sort_order' => (int)($data['sort_order'] ?? 0),
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('UPDATE events SET
            title = :title,
            description = :description,
            event_date = :event_date,
            recurring = :recurring,
            location = :location,
            external_url = :external_url,
            image_path = :image_path,
            is_published = :is_published,
            sort_order = :sort_order
            WHERE id = :id');
        $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':description' => $data['description'] ?? null,
            ':event_date' => $data['event_date'] ?: null,
            ':recurring' => $data['recurring'] ?? 'none',
            ':location' => $data['location'] ?? null,
            ':external_url' => $data['external_url'] ?? null,
            ':image_path' => $data['image_path'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':sort_order' => (int)($data['sort_order'] ?? 0),
            ':id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('DELETE FROM events WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}

