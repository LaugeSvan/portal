<?php
declare(strict_types=1);

class ActivityLog
{
    public static function log(string $action, ?string $entityType = null, ?int $entityId = null, ?string $description = null): void
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('INSERT INTO admin_activity_log (user_id, action, entity_type, entity_id, description, ip_address)
            VALUES (:user_id, :action, :entity_type, :entity_id, :description, :ip_address)');
        $stmt->execute([
            ':user_id' => isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null,
            ':action' => $action,
            ':entity_type' => $entityType,
            ':entity_id' => $entityId,
            ':description' => $description,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    }

    public static function recent(int $limit = 20): array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare(
            'SELECT a.*, u.username 
             FROM admin_activity_log a 
             LEFT JOIN users u ON a.user_id = u.id
             ORDER BY a.created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

