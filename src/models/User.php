<?php
declare(strict_types=1);

class User
{
    public static function all(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByUsername(string $username): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, role)
            VALUES (:username, :email, :password_hash, :role)');
        $stmt->execute([
            ':username' => $data['username'] ?? '',
            ':email' => $data['email'] ?? '',
            ':password_hash' => $data['password_hash'],
            ':role' => $data['role'] ?? 'editor',
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = getDB();
        if (!empty($data['password'])) {
            $stmt = $pdo->prepare('UPDATE users SET username = :username, email = :email, role = :role, password_hash = :password_hash WHERE id = :id');
            $stmt->execute([
                ':username' => $data['username'] ?? '',
                ':email' => $data['email'] ?? '',
                ':role' => $data['role'] ?? 'editor',
                ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
                ':id' => $id,
            ]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id');
            $stmt->execute([
                ':username' => $data['username'] ?? '',
                ':email' => $data['email'] ?? '',
                ':role' => $data['role'] ?? 'editor',
                ':id' => $id,
            ]);
        }
    }

    public static function delete(int $id): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}