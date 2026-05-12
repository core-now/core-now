<?php
require_once __DIR__ . '/../db.php';

$db   = getDB();
$stmt = $db->query("
    SELECT slug, title_de, title_en, body_de, body_en, category, attachments, published_at
    FROM insights
    WHERE published_at IS NOT NULL AND published_at <= GETUTCDATE()
    ORDER BY published_at DESC
");
$posts = $stmt->fetchAll();

foreach ($posts as &$p) {
    $atts = $p['attachments'] ? json_decode($p['attachments'], true) : [];
    $p['is_embed']   = false;
    $p['embed_code'] = '';
    $p['embed_lang'] = 'all';
    foreach ($atts as $a) {
        if (($a['type'] ?? '') === 'embed') {
            $p['is_embed']   = true;
            $p['embed_code'] = $a['url'];
            $p['embed_lang'] = $a['embed_lang'] ?? 'all';
            break;
        }
    }
}
unset($p);

$hasEn = array_filter($posts, fn($p) => !empty($p['title_en']));

function teaser(string $text, int $len = 200): string {
    $t = strip_tags($text);
    return mb_strlen($t) > $len ? mb_substr($t, 0, $len) . '…' : $t;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Insights – CORENOW</title>
  <meta name="description" content="Trends, Erfahrungen und Werkzeuge aus dem CORENOW-Alltag."/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Figtree:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/style.css"/>
  <link rel="stylesheet" href="/assets/css/insights.css"/>
</head>
<body>

<nav id="nav" class="on-dark scrolled">
  <a href="/" class="nav-logo">CORE<em>NOW</em></a>
  <a href="/" class="nav-back">← Zurück zur Website</a>
</nav>

<section class="insights-page s-white">
  <div class="inner">
    <div class="insights-page-header">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px">
        <div>
          <span class="label">Insights</span>
          <h1 class="s-heading">Gedanken &amp;<br><em>Einblicke.</em></h1>
          <div class="rule"></div>
          <p class="s-body">Trends, Erfahrungen und Werkzeuge aus unserem Arbeitsalltag – und Beiträge aus dem Netz, die uns informieren und weiterbringen.</p>
          <p class="insights-lang-hint insights-lang-hint--en" hidden>🌍 Showing English &amp; international posts only — select the mixed flag for all content.</p>
          <p class="insights-lang-hint insights-lang-hint--de" hidden>🇩🇪 Zeigt nur deutsche Beiträge — wähle die geteilte Flagge für alle Inhalte.</p>
        </div>
        <div class="lang-toggle" style="margin-top:8px;flex-shrink:0">
          <button class="lt-btn" data-lang="de" title="Deutsch"><img src="https://flagcdn.com/de.svg" alt="DE" width="28" height="21"></button>
          <button class="lt-btn lt-btn--mixed" data-lang="all" title="Alle / Mixed"><span class="mixed-flag"></span></button>
          <button class="lt-btn" data-lang="en" title="English"><img src="https://flagcdn.com/gb.svg" alt="EN" width="28" height="21"></button>
        </div>
      </div>
    </div>

    <?php if (!$posts): ?>
      <p style="color:var(--ink-muted);text-align:center;padding:60px 0">Noch keine Beiträge veröffentlicht.</p>
    <?php else: ?>
    <div class="insights-list">
      <?php foreach ($posts as $p):
        $date = (new DateTime($p['published_at']))->format('d. F Y');
      ?>
      <?php if ($p['is_embed']): ?>
      <!-- Embed-Post -->
      <div class="insight-embed-row" data-embed-lang="<?= htmlspecialchars($p['embed_lang']) ?>">
        <div class="insight-row-meta">
          <?php if ($p['category']): ?>
            <span class="insight-tag" data-cat="<?= htmlspecialchars($p['category']) ?>"><?= htmlspecialchars($p['category']) ?></span>
          <?php endif; ?>
          <span class="insight-date"><?= $date ?></span>
        </div>
        <div class="insight-embed-wrap">
          <?= $p['embed_code'] ?>
        </div>
      </div>
      <?php else: ?>
      <!-- Artikel-Post -->
      <a href="/insights/post.php?slug=<?= urlencode($p['slug']) ?>" class="insight-row">
        <div class="insight-row-meta">
          <?php if ($p['category']): ?>
            <span class="insight-tag" data-cat="<?= htmlspecialchars($p['category']) ?>"><?= htmlspecialchars($p['category']) ?></span>
          <?php endif; ?>
          <span class="insight-date"><?= $date ?></span>
        </div>
        <h2 class="insight-row-title">
          <span class="lv lv-de"><?= htmlspecialchars($p['title_de']) ?></span>
          <?php if (!empty($p['title_en'])): ?>
            <span class="lv lv-en" hidden><?= htmlspecialchars($p['title_en']) ?></span>
          <?php endif; ?>
        </h2>
        <p class="insight-row-teaser">
          <span class="lv lv-de"><?= htmlspecialchars(teaser($p['body_de'])) ?></span>
          <?php if (!empty($p['body_en'])): ?>
            <span class="lv lv-en" hidden><?= htmlspecialchars(teaser($p['body_en'])) ?></span>
          <?php endif; ?>
        </p>
        <span class="insight-arrow lv lv-de">Weiterlesen →</span>
        <span class="insight-arrow lv lv-en" hidden>Read more →</span>
      </a>
      <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

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

<script>
const catEN = {
  'Webentwicklung':'Web Development','KI':'AI','Tooling':'Tooling',
  'Design':'Design','Server':'Server','Full-Stack':'Full-Stack',
  'DevOps':'DevOps','Sicherheit':'Security','Performance':'Performance',
  'Automatisierung':'Automation','Allgemein':'General'
};
function applyLang(lang) {
  // Active button
  document.querySelectorAll('.lt-btn').forEach(b => b.classList.toggle('active', b.dataset.lang === lang));

  // Article text: 'all' shows DE text
  const textLang = (lang === 'all') ? 'de' : lang;
  document.querySelectorAll('.lv').forEach(el => {
    el.hidden = !el.classList.contains('lv-' + textLang);
  });

  // Category labels
  document.querySelectorAll('.insight-tag[data-cat]').forEach(el => {
    const orig = el.dataset.cat;
    el.textContent = (textLang !== 'de' && catEN[orig]) ? catEN[orig] : orig;
  });

  // Hint texts
  const hintEn = document.querySelector('.insights-lang-hint--en');
  const hintDe = document.querySelector('.insights-lang-hint--de');
  if (hintEn) hintEn.hidden = (lang !== 'en');
  if (hintDe) hintDe.hidden = (lang !== 'de');

  // Embed rows
  document.querySelectorAll('.insight-embed-row[data-embed-lang]').forEach(el => {
    const el_lang = el.dataset.embedLang;
    if (lang === 'all' || el_lang === 'all') { el.hidden = false; return; }
    if (el_lang === 'de') { el.hidden = lang !== 'de'; return; }
    if (el_lang === 'en') { el.hidden = lang === 'de'; return; }
  });

  try { localStorage.setItem('cnLang', lang); } catch(e) {}
}

document.querySelectorAll('.lt-btn').forEach(btn => {
  btn.addEventListener('click', () => applyLang(btn.dataset.lang));
});

// Auto-detect: DE→de, all→all, alles andere (EN/ES/NL/FR/neu)→en
(function() {
  let lang = 'en';
  try {
    const stored = localStorage.getItem('cnLang');
    if (stored === 'de' || stored === 'all') lang = stored;
  } catch(e) {}
  applyLang(lang);
})();
</script>
</body>
</html>
