/* insights.js — Frontend-Sektion #insights */
(function () {
  const section = document.getElementById('insights');
  if (!section) return;

  const grid = section.querySelector('.insights-grid');
  if (!grid) return;

  function fmt(dateStr) {
    const d = new Date(dateStr);
    const lang = window.currentLang || 'de';
    return d.toLocaleDateString(lang === 'de' ? 'de-DE' : 'en-GB', {
      day: 'numeric', month: 'long', year: 'numeric'
    });
  }

  function teaser(text, len) {
    const t = text.replace(/<[^>]*>/g, '');
    return t.length > len ? t.substring(0, len) + '…' : t;
  }

  function currentLang() {
    return window.currentLang || document.documentElement.lang || 'de';
  }

  const platforms = {
    tiktok:    { key: 'tiktok',    name: 'TikTok',    match: ['tiktok'] },
    x:         { key: 'x',         name: 'X',          match: ['von x', 'x news', 'neues von x'] },
    instagram: { key: 'instagram', name: 'Instagram',  match: ['instagram'] },
    facebook:  { key: 'facebook',  name: 'Facebook',   match: ['facebook'] },
    youtube:   { key: 'youtube',   name: 'YouTube',    match: ['youtube'] },
    linkedin:  { key: 'linkedin',  name: 'LinkedIn',   match: ['linkedin'] },
  };

  function detectPlatform(title) {
    const t = title.toLowerCase();
    for (const p of Object.values(platforms)) {
      if (p.match.some(m => t.includes(m))) return p;
    }
    return { key: 'social', name: title };
  }

  function renderEmbedCard(post, lang) {
    const title   = (lang !== 'de' && post.title_en) ? post.title_en : post.title_de;
    const date    = fmt(post.published_at);
    const plat    = detectPlatform(title);
    const cat     = post.category ? ((lang !== 'de' && catEN[post.category]) ? catEN[post.category] : post.category) : null;
    const viewTxt = (T && T[lang] && T[lang]['insights-view-post']) || 'Zum Post →';
    const snippet = post.body_de ? teaser(post.body_de, 80) : '';

    return `<a href="/insights/post.php?slug=${encodeURIComponent(post.slug)}"
               class="insight-card insight-card--embed" data-platform="${plat.key}" data-embed-lang="${post.embed_lang || 'all'}">
      <div class="insight-meta">
        ${cat ? `<span class="insight-tag insight-tag--embed">${cat}</span>` : ''}
        <span class="insight-date insight-date--embed">${date}</span>
      </div>
      <div class="embed-card-body">
        <span class="embed-card-name">${plat.name}</span>
        ${snippet ? `<span class="embed-card-snippet">${snippet}</span>` : ''}
      </div>
      <span class="insight-card-arrow">${viewTxt}</span>
    </a>`;
  }

  const catEN = {
    'Webentwicklung':'Web Development','KI':'AI','Tooling':'Tooling',
    'Design':'Design','Server':'Server','Full-Stack':'Full-Stack',
    'DevOps':'DevOps','Sicherheit':'Security','Performance':'Performance',
    'Automatisierung':'Automation','Allgemein':'General'
  };

  function renderCard(post, lang) {
    lang = lang || currentLang();
    if (post.post_type === 'embed') return renderEmbedCard(post, lang);
    const title = (lang !== 'de' && post.title_en) ? post.title_en : post.title_de;
    const body  = (lang !== 'de' && post.body_en)  ? post.body_en  : post.body_de;
    const date  = fmt(post.published_at);
    const short = teaser(body, 160);
    const cat   = post.category ? ((lang !== 'de' && catEN[post.category]) ? catEN[post.category] : post.category) : null;

    return `<a href="/insights/post.php?slug=${encodeURIComponent(post.slug)}" class="insight-card">
      <div class="insight-meta">
        ${cat ? `<span class="insight-tag">${cat}</span>` : ''}
        <span class="insight-date">${date}</span>
      </div>
      <h3 class="insight-card-title">${title}</h3>
      <p class="insight-card-teaser">${short}</p>
      <span class="insight-card-arrow">${(T && T[lang] && T[lang]['insights-read-more']) || 'Weiterlesen →'}</span>
    </a>`;
  }

  let cachedPosts = null;

  function render(lang) {
    if (!cachedPosts) return;
    grid.innerHTML = cachedPosts
      .filter(p => {
        if (p.post_type !== 'embed') return true;
        const el = p.embed_lang || 'all';
        if (el === 'all') return true;
        if (el === 'de')  return lang === 'de';
        if (el === 'en')  return lang !== 'de';
        return true;
      })
      .map(p => renderCard(p, lang)).join('');
  }

  // Sprachwechsel abfangen und neu rendern
  const _orig = window.setLang;
  if (typeof _orig === 'function') {
    window.setLang = function(lang) {
      _orig(lang);
      render(lang);
    };
  }

  let loaded = false;

  const observer = new IntersectionObserver((entries) => {
    if (!entries[0].isIntersecting || loaded) return;
    loaded = true;
    observer.disconnect();

    fetch('/api/posts.php?limit=3')
      .then(r => r.ok ? r.json() : Promise.reject())
      .then(posts => {
        if (!posts || !posts.length) return;
        cachedPosts = posts;
        render();
      })
      .catch(() => {});
  }, { threshold: 0.1 });

  observer.observe(section);
})();
