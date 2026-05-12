<?php
require_once __DIR__ . '/../db.php';

// Slug aus URL-Segment oder GET-Parameter
$slug = basename($_SERVER['REQUEST_URI'] ?? '');
$slug = strtok($slug, '?');
if (!$slug || $slug === 'post.php') {
    $slug = trim($_GET['slug'] ?? '');
}

if (!$slug) { header('Location: /insights/'); exit; }

$db   = getDB();
$stmt = $db->prepare("
    SELECT * FROM insights
    WHERE slug = ? AND published_at IS NOT NULL AND published_at <= GETUTCDATE()
");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$atts = $post['attachments'] ? json_decode($post['attachments'], true) : [];
$date = (new DateTime($post['published_at']))->format('d. F Y');

// OG-Bild: erstes Bild-Attachment falls vorhanden
$ogImage = '';
foreach ($atts as $a) {
    if (in_array($a['type'], ['image', 'image-url'])) { $ogImage = $a['url']; break; }
}
$baseUrl = 'https://core-now.com';

function renderBody(string $text): string {
    $text = htmlspecialchars($text);
    // Absätze: Leerzeile → <p>
    $text = preg_replace('/\n{2,}/', '</p><p>', $text);
    return '<p>' . $text . '</p>';
}

function capHtml(string $de, string $en, string $tag = 'figcaption'): string {
    if (!$de && !$en) return '';
    if ($en) {
        return '<' . $tag . '>'
            . '<span class="lv lv-de">' . $de . '</span>'
            . '<span class="lv lv-en" hidden>' . $en . '</span>'
            . '</' . $tag . '>';
    }
    return '<' . $tag . '>' . $de . '</' . $tag . '>';
}

function renderAttachment(array $att): string {
    $url    = htmlspecialchars($att['url']);
    $cap_de = htmlspecialchars($att['caption']    ?? '');
    $cap_en = htmlspecialchars($att['caption_en'] ?? '');

    switch ($att['type']) {
        case 'image':
        case 'image-url':
            return '<figure class="att-image">
                <img src="' . $url . '" alt="' . $cap_de . '" loading="lazy"/>
                ' . capHtml($cap_de, $cap_en) . '
            </figure>';

        case 'youtube':
            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
            $vid = $m[1] ?? '';
            if (!$vid) return '';
            return '<div class="att-youtube">
                <iframe src="https://www.youtube-nocookie.com/embed/' . $vid . '"
                    title="' . $cap_de . '" frameborder="0" loading="lazy"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                ' . capHtml($cap_de, $cap_en, 'p') . '
            </div>';

        case 'url':
        case 'social':
            $domain = parse_url($url, PHP_URL_HOST) ?: $url;
            $cap_html = $cap_en
                ? '<span class="lv lv-de">' . ($cap_de ?: $url) . '</span>'
                  . '<span class="lv lv-en" hidden>' . $cap_en . '</span>'
                : ($cap_de ?: htmlspecialchars($att['url']));
            return '<a href="' . $url . '" class="att-link" target="_blank" rel="noopener">
                <span class="att-link-domain">' . htmlspecialchars($domain) . '</span>
                <span class="att-link-cap">' . $cap_html . '</span>
                <span class="att-link-arrow">↗</span>
            </a>';

        case 'embed':
            // Roher Embed-Code (X, Instagram, TikTok …) – kein htmlspecialchars
            $code = $att['url'] ?? '';
            if (!$code) return '';
            return '<div class="att-embed">' . $code
                . capHtml($cap_de, $cap_en, 'p')
                . '</div>';
    }
    return '';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= htmlspecialchars($post['title_de']) ?> – CORENOW Insights</title>
  <meta name="description" content="<?= htmlspecialchars(mb_substr(strip_tags($post['body_de']), 0, 160)) ?>"/>
  <!-- Open Graph -->
  <meta property="og:title" content="<?= htmlspecialchars($post['title_de']) ?>"/>
  <meta property="og:description" content="<?= htmlspecialchars(mb_substr(strip_tags($post['body_de']), 0, 160)) ?>"/>
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="<?= $baseUrl ?>/insights/<?= urlencode($slug) ?>"/>
  <?php if ($ogImage): ?>
  <meta property="og:image" content="<?= $baseUrl . htmlspecialchars($ogImage) ?>"/>
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Figtree:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/style.css"/>
  <link rel="stylesheet" href="/assets/css/insights.css"/>
</head>
<body>

<nav id="nav" class="on-dark scrolled">
  <a href="/" class="nav-logo">CORE<em>NOW</em></a>
  <a href="/insights/" class="nav-back">← Alle Insights</a>
</nav>

<article class="post-page">
  <div class="post-inner">
    <header class="post-header">
      <div class="post-meta-top">
        <?php if ($post['category']): ?>
          <span class="insight-tag" data-cat="<?= htmlspecialchars($post['category']) ?>"><?= htmlspecialchars($post['category']) ?></span>
        <?php endif; ?>
        <span class="insight-date"><?= $date ?></span>
        <?php if (!empty($post['title_en'])): ?>
          <div class="lang-toggle">
            <button class="lt-btn active" data-lang="de"><img src="https://flagcdn.com/de.svg" alt="DE" width="20" height="15"></button>
            <button class="lt-btn" data-lang="en"><img src="https://flagcdn.com/gb.svg" alt="EN" width="20" height="15"></button>
          </div>
        <?php endif; ?>
      </div>
      <h1 class="post-title">
        <span class="lv lv-de"><?= htmlspecialchars($post['title_de']) ?></span>
        <?php if (!empty($post['title_en'])): ?>
          <span class="lv lv-en" hidden><?= htmlspecialchars($post['title_en']) ?></span>
        <?php endif; ?>
      </h1>
      <div class="rule"></div>
    </header>

    <div class="post-body">
      <div class="lv lv-de"><?= renderBody($post['body_de']) ?></div>
      <?php if (!empty($post['body_en'])): ?>
        <div class="lv lv-en" hidden><?= renderBody($post['body_en']) ?></div>
      <?php endif; ?>
    </div>

    <?php if ($atts): ?>
    <div class="post-attachments">
      <?php foreach ($atts as $att): ?>
        <?= renderAttachment($att) ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <footer class="post-footer">
      <a href="/insights/" class="btn btn-ghost-dark">← Alle Insights</a>
    </footer>
  </div>
</article>

<script>
const catEN = {
  'Webentwicklung':'Web Development','KI':'AI','Tooling':'Tooling',
  'Design':'Design','Server':'Server','Full-Stack':'Full-Stack',
  'DevOps':'DevOps','Sicherheit':'Security','Performance':'Performance',
  'Automatisierung':'Automation','Allgemein':'General'
};
function applyLang(lang) {
  document.querySelectorAll('.lt-btn').forEach(b => b.classList.toggle('active', b.dataset.lang === lang));
  document.querySelectorAll('.lv').forEach(el => {
    el.hidden = !el.classList.contains('lv-' + lang);
  });
  document.querySelectorAll('.insight-tag[data-cat]').forEach(el => {
    const orig = el.dataset.cat;
    el.textContent = (lang !== 'de' && catEN[orig]) ? catEN[orig] : orig;
  });
  try { localStorage.setItem('cnLang', lang); } catch(e) {}
}
document.querySelectorAll('.lt-btn').forEach(btn => {
  btn.addEventListener('click', () => applyLang(btn.dataset.lang));
});
(function() {
  let lang = 'de';
  try { lang = localStorage.getItem('cnLang') || 'de'; } catch(e) {}
  if (lang !== 'de') applyLang(lang);
})();
</script>

<footer id="footer" data-theme="dark">
  <div class="ft-inner">
    <div class="ft-brand">CORE<em>NOW</em></div>
    <div class="ft-copy">© <?= date('Y') ?> CORENOW. Alle Rechte vorbehalten.</div>
    <ul class="ft-links">
      <li><a href="/impressum.php">Impressum</a></li>
      <li><a href="/datenschutz.php">Datenschutz</a></li>
      <li><a href="/agb.php">AGB</a></li>
    </ul>
  </div>
</footer>

</body>
</html>
