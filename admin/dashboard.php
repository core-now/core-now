<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/../db.php';

$db   = getDB();
$stmt = $db->query("
    SELECT id, slug, title_de, category, published_at, created_at
    FROM insights
    ORDER BY created_at DESC
");
$posts = $stmt->fetchAll();

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /admin/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Insights – CORENOW Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/admin.css"/>
  <meta name="robots" content="noindex,nofollow"/>
</head>
<body class="admin-page">
  <header class="admin-header">
    <div class="admin-brand">CORE<em>NOW</em> <span>Insights</span></div>
    <div class="admin-header-actions">
      <a href="/admin/edit.php" class="admin-btn-primary">+ Neuer Post</a>
      <a href="/admin/edit.php?embed=1" class="admin-btn-ghost" style="border-color:var(--a-accent);color:var(--a-accent)">⚡ Embed-Post</a>
      <a href="/admin/dashboard.php?logout=1" class="admin-btn-ghost">Abmelden</a>
    </div>
  </header>

  <main class="admin-main">
    <?php if (isset($_GET['saved'])): ?>
      <div class="admin-alert admin-alert-ok">✓ Post gespeichert.</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
      <div class="admin-alert admin-alert-ok">✓ Post gelöscht.</div>
    <?php endif; ?>

    <table class="admin-table">
      <thead>
        <tr>
          <th>Titel</th>
          <th>Kategorie</th>
          <th>Status</th>
          <th>Erstellt</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$posts): ?>
          <tr><td colspan="5" style="text-align:center;color:var(--a-muted)">Noch keine Posts.</td></tr>
        <?php endif; ?>
        <?php foreach ($posts as $p): ?>
          <?php
            $isLive = $p['published_at'] && strtotime($p['published_at']) <= time();
            $isDraft = !$p['published_at'];
            $isScheduled = $p['published_at'] && strtotime($p['published_at']) > time();
          ?>
          <tr>
            <td>
              <strong><?= htmlspecialchars($p['title_de']) ?></strong>
              <br><span class="admin-slug">/insights/<?= htmlspecialchars($p['slug']) ?></span>
            </td>
            <td><?= htmlspecialchars($p['category'] ?? '—') ?></td>
            <td>
              <?php if ($isLive): ?>
                <span class="status-live">⬤ Live</span>
              <?php elseif ($isScheduled): ?>
                <span class="status-scheduled">⏱ Geplant</span>
              <?php else: ?>
                <span class="status-draft">◌ Entwurf</span>
              <?php endif; ?>
            </td>
            <td class="admin-date"><?= (new DateTime($p['created_at']))->format('d.m.Y') ?></td>
            <td class="admin-actions">
              <a href="/admin/edit.php?id=<?= $p['id'] ?>">Bearbeiten</a>
              <?php if ($isLive): ?>
                <a href="/insights/post.php?slug=<?= urlencode($p['slug']) ?>" target="_blank">↗ Ansehen</a>
              <?php endif; ?>
              <form method="POST" action="/admin/delete.php" onsubmit="return confirm('Post wirklich löschen?')">
                <input type="hidden" name="id" value="<?= $p['id'] ?>"/>
                <input type="hidden" name="csrf" value="<?= csrfToken() ?>"/>
                <button type="submit" class="admin-del-btn">Löschen</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
