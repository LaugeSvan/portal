<?php
declare(strict_types=1);

class Page
{
    public static function sectionsByPage(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT * FROM page_content ORDER BY page_slug ASC, section_key ASC');
        $rows = $stmt->fetchAll();
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['page_slug']][] = $row;
        }
        return $grouped;
    }

    public static function getSection(string $pageSlug, string $sectionKey): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM page_content WHERE page_slug = :slug AND section_key = :section LIMIT 1');
        $stmt->execute([
            ':slug' => $pageSlug,
            ':section' => $sectionKey,
        ]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function upsertSection(string $pageSlug, string $sectionKey, string $content, string $contentType = 'text'): void
    {
        $pdo = getDB();
        $existing = self::getSection($pageSlug, $sectionKey);
        if ($existing) {
            $stmt = $pdo->prepare('UPDATE page_content SET content = :content, content_type = :type WHERE id = :id');
            $stmt->execute([
                ':content' => $content,
                ':type' => $contentType,
                ':id' => $existing['id'],
            ]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO page_content (page_slug, section_key, content_type, content)
                VALUES (:slug, :section, :type, :content)');
            $stmt->execute([
                ':slug' => $pageSlug,
                ':section' => $sectionKey,
                ':type' => $contentType,
                ':content' => $content,
            ]);
        }
    }
}

