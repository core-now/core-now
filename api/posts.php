<?php
ini_set('display_errors', '0');
// api/posts.php — GET: published posts als JSON
// Parameter: ?limit=3&offset=0

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../db.php';

$limit  = min((int)($_GET['limit']  ?? 10), 50);
$offset = max((int)($_GET['offset'] ?? 0),  0);

$db   = getDB();
$stmt = $db->prepare("
    SELECT id, slug, title_de, title_en, body_de, body_en,
           category, attachments, published_at
    FROM insights
    WHERE published_at IS NOT NULL AND published_at <= GETUTCDATE()
    ORDER BY published_at DESC
    OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY
");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

foreach ($rows as &$row) {
    $atts = $row['attachments'] ? json_decode($row['attachments'], true) : [];
    $row['attachments'] = $atts ?: [];
    $row['post_type'] = 'article';
    foreach ($atts as $a) {
        if (($a['type'] ?? '') === 'embed') {
            $row['post_type']  = 'embed';
            $row['embed_lang'] = $a['embed_lang'] ?? 'all';
            // Teaser aus Embed-Code extrahieren falls body leer
            if (empty(trim($row['body_de']))) {
                $text = preg_replace('/\s+/', ' ', trim(strip_tags($a['url'] ?? '')));
                $row['body_de'] = mb_substr($text, 0, 120);
            }
            break;
        }
    }
    $row['published_at'] = $row['published_at']
        ? (new DateTime($row['published_at']))->format('c')
        : null;
}

echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
