<?php
declare(strict_types=1);

class Association
{
    public static function all(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM associations ORDER BY sort_order ASC, name ASC');
        return $stmt->fetchAll();
    }

    public static function published(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM associations WHERE is_published = 1 ORDER BY sort_order ASC, name ASC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM associations WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('INSERT INTO associations (name, description, contact_email, contact_phone, website_url, logo_path, is_published, sort_order)
            VALUES (:name, :description, :contact_email, :contact_phone, :website_url, :logo_path, :is_published, :sort_order)');
        $stmt->execute([
            ':name' => $data['name'] ?? '',
            ':description' => $data['description'] ?? null,
            ':contact_email' => $data['contact_email'] ?? null,
            ':contact_phone' => $data['contact_phone'] ?? null,
            ':website_url' => $data['website_url'] ?? null,
            ':logo_path' => $data['logo_path'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':sort_order' => (int)($data['sort_order'] ?? 0),
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('UPDATE associations SET
            name = :name,
            description = :description,
            contact_email = :contact_email,
            contact_phone = :contact_phone,
            website_url = :website_url,
            logo_path = :logo_path,
            is_published = :is_published,
            sort_order = :sort_order
            WHERE id = :id');
        $stmt->execute([
            ':name' => $data['name'] ?? '',
            ':description' => $data['description'] ?? null,
            ':contact_email' => $data['contact_email'] ?? null,
            ':contact_phone' => $data['contact_phone'] ?? null,
            ':website_url' => $data['website_url'] ?? null,
            ':logo_path' => $data['logo_path'] ?? null,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':sort_order' => (int)($data['sort_order'] ?? 0),
            ':id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('DELETE FROM associations WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}

