<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/../db.php';

$db   = getDB();
$post = null;
$id   = (int)($_GET['id'] ?? 0);

if ($id) {
    $stmt = $db->prepare("SELECT * FROM insights WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    if (!$post) { header('Location: /admin/dashboard.php'); exit; }
}

$attachments = $post ? (json_decode($post['attachments'] ?? '[]', true) ?: []) : [];
$embedMode   = isset($_GET['embed']) || (isset($_POST['embed_mode']) && $_POST['embed_mode']);

$platformTitles = [
    'TikTok'    => ['de' => 'Neues von TikTok',    'en' => 'TikTok News'],
    'X'         => ['de' => 'Neues von X',          'en' => 'X News'],
    'Instagram' => ['de' => 'Neues von Instagram',  'en' => 'Instagram News'],
    'Facebook'  => ['de' => 'Neues von Facebook',   'en' => 'Facebook News'],
    'YouTube'   => ['de' => 'Neues von YouTube',    'en' => 'YouTube News'],
    'LinkedIn'  => ['de' => 'Neues von LinkedIn',   'en' => 'LinkedIn News'],
];

// ── SAVE ─────────────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    // Embed-Mode: Titel aus Plattform-Auswahl generieren
    if (!empty($_POST['embed_mode'])) {
        $platform = trim($_POST['platform'] ?? '');
        if ($platform === 'Sonstiges') {
            $platform = trim($_POST['custom_platform'] ?? 'Sonstiges');
        }
        global $platformTitles;
        $title_de = $platformTitles[$platform]['de'] ?? 'Neues von ' . $platform;
        $title_en = $platformTitles[$platform]['en'] ?? $platform . ' News';
        // Manuell überschrieben?
        if (!empty($_POST['title_de_override'])) $title_de = trim($_POST['title_de_override']);
        if (!empty($_POST['title_en_override'])) $title_en = trim($_POST['title_en_override']);
    } else {
        $title_de = trim($_POST['title_de'] ?? '');
        $title_en = trim($_POST['title_en'] ?? '');
    }
    $body_de  = trim($_POST['body_de']  ?? '');
    $body_en  = trim($_POST['body_en']  ?? '');
    $category = trim($_POST['category'] ?? '');
    $pub_raw  = trim($_POST['published_at'] ?? '');
    $pub      = $pub_raw
        ? (new DateTime($pub_raw, new DateTimeZone('Europe/Berlin')))
            ->setTimezone(new DateTimeZone('UTC'))
            ->format('Y-m-d H:i:s')
        : null;

    // Slug: aus Titel generieren oder manuell
    $slug = trim($_POST['slug'] ?? '');
    if (!$slug) {
        $slug = strtolower($title_de);
        $slug = str_replace(['ä','ö','ü','Ä','Ö','Ü','ß'], ['ae','oe','ue','ae','oe','ue','ss'], $slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        $slug = substr($slug, 0, 100);
        // Embed-Posts: Suffix gegen Slug-Kollisionen
        if (!empty($_POST['embed_mode'])) {
            $slug .= '-' . bin2hex(random_bytes(3)); // z.B. neues-von-x-a3f2b1
        }
    }

    // Attachments sammeln
    $atts = [];
    if (!empty($_POST['embed_mode'])) {
        // Embed-Mode: nur ein direktes Embed-Code-Feld
        $embedCode = trim($_POST['embed_code'] ?? '');
        $embedLang = in_array($_POST['embed_lang'] ?? '', ['de','en','all']) ? $_POST['embed_lang'] : 'all';
        if ($embedCode) {
            $atts[] = ['type' => 'embed', 'url' => $embedCode, 'caption' => '', 'caption_en' => '', 'embed_lang' => $embedLang];
        }
    } else {
        $types    = $_POST['att_type']       ?? [];
        $urls     = $_POST['att_url']        ?? [];
        $caps     = $_POST['att_caption']    ?? [];
        $caps_en  = $_POST['att_caption_en'] ?? [];
        foreach ($types as $i => $type) {
            $url = trim($urls[$i] ?? '');
            if (!$url && $type !== 'image') continue;
            $atts[] = [
                'type'       => htmlspecialchars($type),
                'url'        => $type === 'embed' ? $url : htmlspecialchars($url),
                'caption'    => htmlspecialchars(trim($caps[$i] ?? '')),
                'caption_en' => htmlspecialchars(trim($caps_en[$i] ?? '')),
            ];
        }
    }

    // Bild-Upload
    if (!empty($_FILES['att_images']['name'][0])) {
        foreach ($_FILES['att_images']['tmp_name'] as $i => $tmp) {
            if (!is_uploaded_file($tmp)) continue;
            $orig = $_FILES['att_images']['name'][$i];
            $ext  = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','webp'])) continue;
            if ($_FILES['att_images']['size'][$i] > 5 * 1024 * 1024) continue;
            $name = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
            $dest = __DIR__ . '/../assets/img/insights/' . $name;
            if (move_uploaded_file($tmp, $dest)) {
                $atts[] = [
                    'type'    => 'image',
                    'url'     => '/assets/img/insights/' . $name,
                    'caption' => htmlspecialchars($_POST['att_img_caption'][$i] ?? ''),
                ];
            }
        }
    }

    $attsJson = $atts ? json_encode($atts, JSON_UNESCAPED_UNICODE) : null;

    if ($id) {
        $stmt = $db->prepare("
            UPDATE insights SET
                slug=?, title_de=?, title_en=?, body_de=?, body_en=?,
                category=?, attachments=?, published_at=?
            WHERE id=?
        ");
        $stmt->execute([$slug,$title_de,$title_en,$body_de,$body_en,
                        $category,$attsJson,$pub,$id]);
    } else {
        // Embed-Posts dürfen leere body_de haben
        if (!$title_de) { header('Location: /admin/dashboard.php'); exit; }
        $stmt = $db->prepare("
            INSERT INTO insights
                (slug,title_de,title_en,body_de,body_en,category,attachments,published_at)
            VALUES (?,?,?,?,?,?,?,?)
        ");
        $stmt->execute([$slug,$title_de,$title_en,$body_de,$body_en,
                        $category,$attsJson,$pub]);
    }

    header('Location: /admin/dashboard.php?saved=1');
    exit;
}

$cats = ['KI','Webentwicklung','Tooling','Security','DevOps','Allgemein'];
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= $id ? 'Post bearbeiten' : ($embedMode ? 'Embed-Post' : 'Neuer Post') ?> – CORENOW Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/admin.css"/>
  <meta name="robots" content="noindex,nofollow"/>
</head>
<body class="admin-page">
  <header class="admin-header">
    <div class="admin-brand">CORE<em>NOW</em> <span><?= $id ? 'Post bearbeiten' : ($embedMode ? '⚡ Embed-Post' : 'Neuer Post') ?></span></div>
    <a href="/admin/dashboard.php" class="admin-btn-ghost">← Zurück</a>
  </header>

  <main class="admin-main">
    <form method="POST" action="/admin/edit.php<?= $id ? "?id=$id" : '' ?>"
          enctype="multipart/form-data" class="edit-form">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>"/>
      <?php if ($embedMode): ?>
        <input type="hidden" name="embed_mode" value="1"/>
        <input type="hidden" name="body_de" value=""/>
        <input type="hidden" name="body_en" value=""/>
      <?php endif; ?>

      <!-- Kern -->
      <div class="edit-grid">
        <div class="edit-col-main">
          <?php if ($embedMode): ?>
          <!-- ── EMBED MODE: Plattform-Auswahl statt Titel/Text ── -->
          <div class="embed-platform-box">
            <div class="f-grp">
              <label>Plattform</label>
              <select name="platform" id="platformSel">
                <?php foreach (array_keys($platformTitles) as $p): ?>
                  <option value="<?= $p ?>"><?= $p ?></option>
                <?php endforeach; ?>
                <option value="Sonstiges">Sonstiges …</option>
              </select>
            </div>
            <div class="f-grp" id="customPlatformGrp" style="display:none">
              <label>Plattform-Name</label>
              <input type="text" name="custom_platform" placeholder="z.B. Threads"/>
            </div>
            <div class="embed-title-preview">
              <span class="embed-title-label">Titel DE:</span>
              <span id="prevDe">Neues von TikTok</span>
              <span class="embed-title-label" style="margin-left:16px">EN:</span>
              <span id="prevEn">TikTok News</span>
            </div>
            <details class="embed-title-override">
              <summary>Titel manuell überschreiben</summary>
              <div class="f-grp" style="margin-top:8px">
                <input type="text" name="title_de_override" placeholder="Titel DE überschreiben (optional)"/>
              </div>
              <div class="f-grp">
                <input type="text" name="title_en_override" placeholder="Title EN override (optional)"/>
              </div>
            </details>
          </div>
          <div class="f-grp">
            <label>Embed-Code *</label>
            <textarea name="embed_code" rows="8" required
                      placeholder="Embed-Code hier einfügen (von X, Instagram, TikTok, Facebook …)"
                      style="font-family:'JetBrains Mono',monospace;font-size:.75rem"></textarea>
            <span class="f-hint">Den vollständigen Embed-Code des Anbieters einfügen — inkl. &lt;script&gt;-Tag falls vorhanden.</span>
          </div>
          <div class="f-grp">
            <label>Sprache des Posts</label>
            <div class="embed-lang-radios">
              <label class="embed-lang-opt">
                <input type="radio" name="embed_lang" value="de" checked/>
                <img src="https://flagcdn.com/de.svg" alt="DE" width="22" height="16"> Deutsch
              </label>
              <label class="embed-lang-opt">
                <input type="radio" name="embed_lang" value="en"/>
                <img src="https://flagcdn.com/gb.svg" alt="EN" width="22" height="16"> Englisch / International
              </label>
              <label class="embed-lang-opt">
                <input type="radio" name="embed_lang" value="all"/>
                🌍 Alle Sprachen
              </label>
            </div>
            <span class="f-hint">Nur für Besucher der gewählten Sprache sichtbar. "Alle" = immer anzeigen.</span>
          </div>
          <?php else: ?>
          <div class="f-grp">
            <label>Titel (DE) *</label>
            <input type="text" name="title_de" required
                   value="<?= htmlspecialchars($post['title_de'] ?? '') ?>"
                   placeholder="Titel auf Deutsch"/>
          </div>
          <div class="f-grp">
            <label>Titel (EN)</label>
            <input type="text" name="title_en"
                   value="<?= htmlspecialchars($post['title_en'] ?? '') ?>"
                   placeholder="Title in English (optional)"/>
          </div>
          <div class="f-grp">
            <label>Inhalt (DE) *</label>
            <textarea name="body_de" rows="12" required
                      placeholder="Text auf Deutsch …"><?= htmlspecialchars($post['body_de'] ?? '') ?></textarea>
          </div>
          <div class="f-grp">
            <label>Inhalt (EN)</label>
            <textarea name="body_en" rows="12"
                      placeholder="Content in English (optional) …"><?= htmlspecialchars($post['body_en'] ?? '') ?></textarea>
          </div>
          <?php endif; ?>
        </div>

        <div class="edit-col-side">
          <div class="side-box">
            <h4>Veröffentlichung</h4>
            <div class="f-grp">
              <label>Slug</label>
              <input type="text" name="slug"
                     value="<?= htmlspecialchars($post['slug'] ?? '') ?>"
                     placeholder="auto-generiert aus Titel"/>
            </div>
            <div class="f-grp">
              <label>Kategorie</label>
              <select name="category">
                <option value="">— keine —</option>
                <?php foreach ($cats as $c): ?>
                  <option value="<?= $c ?>"
                    <?= ($post['category'] ?? '') === $c ? 'selected' : '' ?>>
                    <?= $c ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="f-grp">
              <label>Veröffentlichen am</label>
              <input type="datetime-local" name="published_at"
                     value="<?= $post['published_at']
                        ? (new DateTime($post['published_at'], new DateTimeZone('UTC')))
                            ->setTimezone(new DateTimeZone('Europe/Berlin'))
                            ->format('Y-m-d\TH:i')
                        : '' ?>"/>
              <span class="f-hint">Leer lassen = Entwurf</span>
            </div>
            <button type="submit" class="admin-btn-primary w-full">Speichern</button>
          </div>

          <!-- Attachments -->
          <?php if ($embedMode): ?><?php else: ?>
          <div class="side-box">
            <h4 style="display:flex;align-items:center;justify-content:space-between">
              Anhänge
              <span class="att-lang-sw">
                <button type="button" class="att-lang-btn active" data-lang="de"><img src="https://flagcdn.com/de.svg" alt="DE" width="20" height="15"></button>
                <button type="button" class="att-lang-btn" data-lang="en"><img src="https://flagcdn.com/gb.svg" alt="EN" width="20" height="15"></button>
              </span>
            </h4>
            <div id="att-list">
              <?php foreach ($attachments as $i => $att): ?>
              <div class="att-block">
                <select name="att_type[]" class="att-type-sel">
                  <?php foreach (['youtube','url','social','image-url','embed'] as $t): ?>
                    <option value="<?= $t ?>" <?= $att['type']===$t?'selected':'' ?>><?= ['image-url'=>'Bild-URL','embed'=>'Embed (X/IG/…)'][$t] ?? ucfirst($t) ?></option>
                  <?php endforeach; ?>
                </select>
                <?php if ($att['type'] === 'embed'): ?>
                  <textarea name="att_url[]" class="att-embed-code" rows="3"
                            placeholder="Embed-Code einfügen …"><?= htmlspecialchars($att['url']) ?></textarea>
                <?php else: ?>
                  <input type="url" name="att_url[]"
                         value="<?= htmlspecialchars($att['url']) ?>"
                         placeholder="URL"/>
                <?php endif; ?>
                <input type="text" name="att_caption[]" class="att-cap-de"
                       value="<?= htmlspecialchars($att['caption'] ?? '') ?>"
                       placeholder="Beschriftung (DE)"/>
                <input type="text" name="att_caption_en[]" class="att-cap-en"
                       value="<?= htmlspecialchars($att['caption_en'] ?? '') ?>"
                       placeholder="Caption (EN)" style="display:none"/>
                <button type="button" class="att-remove" onclick="this.closest('.att-block').remove()">✕</button>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="att-add-btns">
              <button type="button" class="admin-btn-ghost" onclick="addAtt('youtube')">+ YouTube</button>
              <button type="button" class="admin-btn-ghost" onclick="addAtt('url')">+ Link</button>
              <button type="button" class="admin-btn-ghost" onclick="addAtt('social')">+ Social</button>
              <button type="button" class="admin-btn-ghost" onclick="addAtt('image-url')">+ Bild-URL</button>
              <button type="button" class="admin-btn-ghost" onclick="addAtt('embed')">+ Embed</button>
            </div>

            <div class="paste-zone" id="pasteZone">
              <span>📋 Bild hier einfügen (Strg+V) oder hineinziehen</span>
              <input type="file" id="pasteFileInput" accept="image/*"
                     style="position:absolute;inset:0;opacity:0;cursor:pointer"/>
            </div>
            <div id="pasteStatus" class="f-hint" style="margin-top:4px"></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </main>

  <script>
  // ── Embed-Mode: Plattform-Dropdown ──────────────────────────────────
  const platformTitles = {
    TikTok:    { de: 'Neues von TikTok',    en: 'TikTok News' },
    X:         { de: 'Neues von X',          en: 'X News' },
    Instagram: { de: 'Neues von Instagram',  en: 'Instagram News' },
    Facebook:  { de: 'Neues von Facebook',   en: 'Facebook News' },
    YouTube:   { de: 'Neues von YouTube',    en: 'YouTube News' },
    LinkedIn:  { de: 'Neues von LinkedIn',   en: 'LinkedIn News' },
  };
  const platformSel = document.getElementById('platformSel');
  if (platformSel) {
    platformSel.addEventListener('change', function() {
      const val = this.value;
      document.getElementById('customPlatformGrp').style.display = val === 'Sonstiges' ? '' : 'none';
      const t = platformTitles[val] || { de: 'Neues von ' + val, en: val + ' News' };
      document.getElementById('prevDe').textContent = t.de;
      document.getElementById('prevEn').textContent = t.en;
    });
  }

  // aktive Sprache im Attachment-Toggle
  let attLang = 'de';

  function addAtt(type, url, caption) {
    const labels = {
      youtube: 'YouTube-URL',
      url: 'Link-URL',
      social: 'Social-URL',
      'image-url': 'Bild-URL (https://…)'
    };
    const urlField = type === 'embed'
      ? `<textarea name="att_url[]" class="att-embed-code" rows="3"
                   placeholder="Embed-Code einfügen (von X, Instagram, TikTok …)">${url || ''}</textarea>`
      : `<input type="url" name="att_url[]"
               placeholder="${labels[type] || 'URL'}"
               value="${url || ''}"/>`;

    const block = document.createElement('div');
    block.className = 'att-block';
    block.innerHTML = `
      <select name="att_type[]" class="att-type-sel">
        <option value="youtube"   ${type==='youtube'   ?'selected':''}>YouTube</option>
        <option value="url"       ${type==='url'       ?'selected':''}>Link</option>
        <option value="social"    ${type==='social'    ?'selected':''}>Social</option>
        <option value="image-url" ${type==='image-url' ?'selected':''}>Bild-URL</option>
        <option value="embed"     ${type==='embed'     ?'selected':''}>Embed (X/IG/…)</option>
      </select>
      ${urlField}
      <input type="text" name="att_caption[]" class="att-cap-de"
             placeholder="Beschriftung (DE)"
             value="${caption || ''}"
             style="${attLang === 'en' ? 'display:none' : ''}"/>
      <input type="text" name="att_caption_en[]" class="att-cap-en"
             placeholder="Caption (EN)"
             style="${attLang === 'de' ? 'display:none' : ''}"/>
      <button type="button" class="att-remove"
              onclick="this.closest('.att-block').remove()">✕</button>
    `;
    document.getElementById('att-list').appendChild(block);
  }

  // DE/EN Toggle
  document.querySelectorAll('.att-lang-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      attLang = btn.dataset.lang;
      document.querySelectorAll('.att-lang-btn').forEach(b => b.classList.toggle('active', b.dataset.lang === attLang));
      document.querySelectorAll('.att-cap-de').forEach(el => el.style.display = attLang === 'de' ? '' : 'none');
      document.querySelectorAll('.att-cap-en').forEach(el => el.style.display = attLang === 'en' ? '' : 'none');
    });
  });

  // ── Upload-Helfer ──────────────────────────────────────────────────
  function uploadImage(file) {
    const status = document.getElementById('pasteStatus');
    if (!file || !file.type.startsWith('image/')) return;
    status.textContent = '⏳ Wird hochgeladen …';

    const fd = new FormData();
    fd.append('file', file);

    fetch('/admin/upload.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(data => {
        if (data.url) {
          addAtt('image-url', window.location.origin + data.url, '');
          status.textContent = '✓ Hochgeladen: ' + data.url;
          setTimeout(() => status.textContent = '', 3000);
        } else {
          status.textContent = '✗ Fehler: ' + (data.error || 'unbekannt');
        }
      })
      .catch(() => { status.textContent = '✗ Upload fehlgeschlagen.'; });
  }

  // ── Strg+V Paste (nur wenn kein Text-Feld fokussiert) ────────────
  document.addEventListener('paste', e => {
    const tag = document.activeElement?.tagName;
    if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return;

    const items = e.clipboardData?.items;
    if (!items) return;
    for (const item of items) {
      if (item.type.startsWith('image/')) {
        e.preventDefault();
        uploadImage(item.getAsFile());
        return;
      }
    }
  });

  // ── Drag & Drop / File-Input ───────────────────────────────────────
  const zone  = document.getElementById('pasteZone');
  const finput = document.getElementById('pasteFileInput');

  finput.addEventListener('change', () => {
    if (finput.files[0]) uploadImage(finput.files[0]);
    finput.value = '';
  });

  zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
  zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
  zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('drag-over');
    const file = e.dataTransfer?.files[0];
    if (file) uploadImage(file);
  });
  </script>
</body>
</html>
