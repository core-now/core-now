<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>CORENOW – IT & KI-Lösungen</title>
  <meta name="description" content="Professionelle IT-Beratung und KI-Integration. CMS-Support, Webentwicklung, maßgeschneiderte Anwendungen und lokale KI-Infrastrukturen."/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,600&family=Figtree:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>

<!-- NAV -->
<nav id="nav" class="on-dark">
  <a href="#" class="nav-logo">CORE<em>NOW</em></a>
  <ul class="nav-links">
    <li><a href="#services" data-i18n="nav-services">Leistungen</a></li>
    <li><a href="#why" data-i18n="nav-about">Über uns</a></li>
    <li><a href="#ai" data-i18n="nav-ai">KI & Technologie</a></li>
    <li><a href="#process" data-i18n="nav-process">Vorgehen</a></li>
    <li><a href="#projekte" data-i18n="nav-refs">Referenzen</a></li>
    <li><a href="#insights" data-i18n="nav-insights">Insights</a></li>
    <li><a href="#partner" data-i18n="nav-partner">Partner</a></li>
    <li><a href="#contact" class="nav-cta" data-i18n="nav-contact">Kontakt aufnehmen</a></li>
  </ul>
  <div style="display:flex;align-items:center;gap:8px">
    <div class="lang-sw">
      <button class="lbtn active" onclick="setLang('de')" title="Deutsch"><img src="https://flagcdn.com/de.svg" alt="DE" width="22" height="16"></button>
      <button class="lbtn" onclick="setLang('en')" title="English"><img src="https://flagcdn.com/gb.svg" alt="EN" width="22" height="16"></button>
      <button class="lbtn" onclick="setLang('es')" title="Español"><img src="https://flagcdn.com/es.svg" alt="ES" width="22" height="16"></button>
      <button class="lbtn" onclick="setLang('nl')" title="Nederlands"><img src="https://flagcdn.com/nl.svg" alt="NL" width="22" height="16"></button>
      <button class="lbtn" onclick="setLang('fr')" title="Français"><img src="https://flagcdn.com/fr.svg" alt="FR" width="22" height="16"></button>
    </div>
    <button class="hamburger" id="hamBtn" aria-label="Menü">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="mob-overlay" id="mobMenu">
  <button class="mob-close" id="mobClose">✕</button>
  <a href="#services" class="ml" data-i18n="nav-services">Leistungen</a>
  <a href="#why" class="ml" data-i18n="nav-about">Über uns</a>
  <a href="#ai" class="ml" data-i18n="nav-ai">KI & Technologie</a>
  <a href="#process" class="ml" data-i18n="nav-process">Vorgehen</a>
  <a href="#projekte" class="ml" data-i18n="nav-refs">Referenzen</a>
  <a href="#insights" class="ml" data-i18n="nav-insights">Insights</a>
  <a href="#partner" class="ml" data-i18n="nav-partner">Partner</a>
  <a href="#contact" class="ml" data-i18n="nav-contact">Kontakt</a>
  <div class="mob-lang">
    <button onclick="setLang('de')" title="Deutsch"><img src="https://flagcdn.com/de.svg" alt="DE" width="22" height="16"></button>
    <button onclick="setLang('en')" title="English"><img src="https://flagcdn.com/gb.svg" alt="EN" width="22" height="16"></button>
    <button onclick="setLang('es')" title="Español"><img src="https://flagcdn.com/es.svg" alt="ES" width="22" height="16"></button>
    <button onclick="setLang('nl')" title="Nederlands"><img src="https://flagcdn.com/nl.svg" alt="NL" width="22" height="16"></button>
    <button onclick="setLang('fr')" title="Français"><img src="https://flagcdn.com/fr.svg" alt="FR" width="22" height="16"></button>
  </div>
</div>

<!-- HERO -->
<section id="hero">
  <div class="h-ring h-ring-1"></div>
  <div class="h-ring h-ring-2"></div>
  <div class="h-ring h-ring-3"></div>
  <div class="h-glow"></div>
  <span class="h-eyebrow" data-i18n="hero-eyebrow">IT-Beratung & KI-Integration · Remote · deutschlandweit</span>
  <div class="h-lang">
    <button class="lbtn active" onclick="setLang('de')" title="Deutsch"><img src="https://flagcdn.com/de.svg" alt="DE" width="28" height="21"></button>
    <button class="lbtn" onclick="setLang('en')" title="English"><img src="https://flagcdn.com/gb.svg" alt="EN" width="28" height="21"></button>
    <button class="lbtn" onclick="setLang('es')" title="Español"><img src="https://flagcdn.com/es.svg" alt="ES" width="28" height="21"></button>
    <button class="lbtn" onclick="setLang('nl')" title="Nederlands"><img src="https://flagcdn.com/nl.svg" alt="NL" width="28" height="21"></button>
    <button class="lbtn" onclick="setLang('fr')" title="Français"><img src="https://flagcdn.com/fr.svg" alt="FR" width="28" height="21"></button>
  </div>
  <h1 class="h-title" data-i18n-html="hero-title">Technologie, die<br><em>Wirkung entfaltet.</em></h1>
  <div class="h-rule"></div>
  <p class="h-sub" data-i18n="hero-sub">Von der CMS-Wartung bis zur vollständigen KI-Infrastruktur – wir liefern verlässliche IT-Lösungen, die in Ihrem Betrieb wirklich funktionieren.</p>
  <div class="h-actions">
    <a href="#contact" class="btn btn-solid" data-i18n="hero-btn1">Projekt besprechen</a>
    <a href="#services" class="btn btn-ghost-light" data-i18n="hero-btn2">Leistungsübersicht</a>
  </div>
  <div class="h-scroll"><div class="h-scroll-line"></div><span data-i18n="h-scroll">Scroll</span></div>
</section>

<!-- SERVICES -->
<section id="services" class="s-light" data-theme="light">
  <div class="inner">
    <div class="reveal">
      <span class="label" data-i18n="s-services-label">Leistungen</span>
      <h2 class="s-heading" data-i18n="s-services-heading">Was wir für Sie umsetzen</h2>
      <div class="rule"></div>
      <p class="s-body" data-i18n="s-services-body">Sechs klar definierte Kompetenzbereiche – praxiserprobt und auf Ihre betrieblichen Anforderungen zugeschnitten.</p>
    </div>
    <div class="svc-grid">
      <div class="svc-card reveal"><span class="svc-n">01</span><span class="svc-icon">🛠</span><h3 data-i18n="svc1-title">CMS-Support & Wartung</h3><p data-i18n="svc1-desc">Zuverlässige Betreuung bestehender CMS-Installationen: Updates, Fehlerbehebung, Performance-Optimierung und Sicherheits-Patches mit kurzen Reaktionszeiten.</p><div class="svc-tags"><span class="svc-tag">TYPO3</span><span class="svc-tag">WordPress</span><span class="svc-tag">Joomla</span><span class="svc-tag">Contao</span></div></div>
      <div class="svc-card reveal"><span class="svc-n">02</span><span class="svc-icon">🌐</span><h3 data-i18n="svc2-title">Webseitenerstellung</h3><p data-i18n="svc2-desc">Moderne, schnelle Webpräsenzen – vom Konzept bis zur Übergabe. Responsiv, barrierefrei, SEO-optimiert und technisch sauber umgesetzt.</p><div class="svc-tags"><span class="svc-tag">React / Next.js</span><span class="svc-tag">SEO</span><span class="svc-tag">Performance</span></div></div>
      <div class="svc-card reveal"><span class="svc-n">03</span><span class="svc-icon">⚙️</span><h3 data-i18n="svc3-title">Individuelle Anwendungen</h3><p data-i18n="svc3-desc">Softwarelösungen, die exakt zu Ihren Prozessen passen – keine Kompromisse durch Standardprodukte. Von der Anforderungsanalyse bis zum produktiven Betrieb.</p><div class="svc-tags"><span class="svc-tag">Web-Apps</span><span class="svc-tag">APIs</span><span class="svc-tag">Automatisierung</span></div></div>
      <div class="svc-card reveal"><span class="svc-n">04</span><span class="svc-icon">🤖</span><h3 data-i18n="svc4-title">KI-Integration & Workflows</h3><p data-i18n="svc4-desc">KI-gestützte Prozesse, die echten Mehrwert schaffen: Dokumentenerkennung, LLM-Verarbeitung und Bildgenerierung – produktionsreif integriert.</p><div class="svc-tags"><span class="svc-tag">Stable Diffusion</span><span class="svc-tag">Claude / GPT</span><span class="svc-tag">n8n</span></div></div>
      <div class="svc-card reveal"><span class="svc-n">05</span><span class="svc-icon">🏢</span><h3 data-i18n="svc5-title">Lokale KI-Umgebungen</h3><p data-i18n="svc5-desc">Datenschutzkonforme KI-Infrastrukturen ohne Internetanbindung. Wissen und Regeln intern vermitteln – via interaktivem Mentor-Assistent auf Basis lokaler Sprachmodelle.</p><div class="svc-tags"><span class="svc-tag">Ollama</span><span class="svc-tag">Offline / DSGVO</span><span class="svc-tag">RAG</span></div></div>
      <div class="svc-card reveal"><span class="svc-n">06</span><span class="svc-icon">📡</span><h3 data-i18n="svc6-title">Full-Stack-Plattformen</h3><p data-i18n="svc6-desc">Komplexe Systeme von Grund auf – Echtzeit-Videochat (WebRTC/Pleep), kollaborative Plattformen, skalierbare Backend-Infrastrukturen.</p><div class="svc-tags"><span class="svc-tag">WebRTC / Pleep</span><span class="svc-tag">Node.js</span><span class="svc-tag">Docker</span></div></div>
    </div>
  </div>
</section>

<!-- WHY -->
<section id="why" class="s-dark" data-theme="dark">
  <div class="inner">
    <div class="why-grid">
      <div class="reveal">
        <span class="label" data-i18n="s-why-label">Über uns</span>
        <h2 class="s-heading" style="color:var(--chalk)" data-i18n-html="s-why-heading">Verlässlichkeit ist<br><em>kein Zufall.</em></h2>
        <div class="rule"></div>
        <p class="s-body" style="margin-bottom:0;color:var(--chalk-soft)" data-i18n="s-why-body">Wir sind ein kleines, spezialisiertes Team mit dem Anspruch, jeden Auftrag so umzusetzen, als wäre es der einzige. Kein Outsourcing, kein Rätselraten – direkter Kontakt, klare Absprachen, belastbare Ergebnisse.</p>
        <div class="why-box">
          <blockquote data-i18n="why-quote">„Technologie soll Ihr Unternehmen voranbringen – nicht beschäftigen."</blockquote>
          <a href="#contact" class="btn btn-solid" data-i18n="why-cta-btn">Kostenfreies Erstgespräch</a>
        </div>
      </div>
      <div class="why-items reveal">
        <div class="why-item"><span class="why-idx">01</span><div><h4 data-i18n="why1-title">Direkte Kommunikation</h4><p data-i18n="why1-desc">Sie sprechen stets mit der Person, die auch umsetzt. Kein Ticketsystem, das ins Leere läuft.</p></div></div>
        <div class="why-item"><span class="why-idx">02</span><div><h4 data-i18n="why2-title">Datenschutz & Datensouveränität</h4><p data-i18n="why2-desc">Lokale KI-Installationen und DSGVO-konforme Infrastrukturen – Ihre Daten verlassen Ihr Haus nicht.</p></div></div>
        <div class="why-item"><span class="why-idx">03</span><div><h4 data-i18n="why3-title">Aktuelle KI-Kompetenz</h4><p data-i18n="why3-desc">Wir setzen KI-Technologien produktiv ein – nicht als Buzzword, sondern als praktisches Werkzeug.</p></div></div>
        <div class="why-item"><span class="why-idx">04</span><div><h4 data-i18n="why4-title">Transparente Preise</h4><p data-i18n="why4-desc">Klare Angebote, keine versteckten Kosten, verbindliche Zeitpläne.</p></div></div>
        <div class="why-item"><span class="why-idx">05</span><div><h4 data-i18n="why5-title">Langfristige Betreuung</h4><p data-i18n="why5-desc">Launch ist der Anfang. Wir begleiten Wartung, Weiterentwicklung und Support dauerhaft.</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- AI -->
<section id="ai" class="s-light" data-theme="light">
  <div class="inner">
    <div class="reveal">
      <span class="label" data-i18n="s-ai-label">KI & Technologie</span>
      <h2 class="s-heading" data-i18n-html="s-ai-heading">Künstliche Intelligenz<br><em>praktisch eingesetzt</em></h2>
      <div class="rule"></div>
      <p class="s-body" data-i18n="s-ai-body">Nicht Hype, sondern Handwerk. Wir integrieren KI dort, wo sie echte Effizienzgewinne bringt.</p>
    </div>
    <div class="ai-tabs reveal">
      <div class="ai-tab-nav">
        <button class="ai-tab active" data-tab="0" data-i18n="ai-feat-label">Offline · DSGVO-konform</button>
        <button class="ai-tab" data-tab="1" data-i18n="ai2-label">Cloud AI</button>
        <button class="ai-tab" data-tab="2" data-i18n="ai3-label">Bildgenerierung</button>
        <button class="ai-tab" data-tab="3" data-i18n="ai4-label">Dokumentenverarbeitung</button>
      </div>
      <div class="ai-panels">
        <div class="ai-panel active" data-panel="0">
          <span class="ai-panel-lbl" data-i18n="ai-feat-label">Offline · DSGVO-konform</span>
          <h3 data-i18n="ai-feat-title">Lokaler KI-Assistent für Ihr Unternehmen</h3>
          <p data-i18n-html="ai-feat-body">Wir richten vollständige Sprachmodell-Infrastrukturen lokal in Ihrem Netzwerk ein – ohne Internetverbindung, ohne externe Datenweitergabe.<br><br>Der integrierte Mentor-Assistent beantwortet Mitarbeiterfragen zu internen Prozessen, Regelwerken und Wissensbeständen – rund um die Uhr, automatisiert und sicher.</p>
          <div class="ai-panel-tags"><span class="ai-panel-tag">Ollama</span><span class="ai-panel-tag">LLaMA 3 / Mistral</span><span class="ai-panel-tag">RAG</span><span class="ai-panel-tag">Document AI</span><span class="ai-panel-tag">Intranet</span></div>
        </div>
        <div class="ai-panel" data-panel="1">
          <span class="ai-panel-lbl" data-i18n="ai2-label">Cloud AI</span>
          <h3 data-i18n="ai2-title">API-Anbindung & Cloud-Modelle</h3>
          <p data-i18n="ai2-body">Integration von Claude, GPT-4, Gemini und weiteren Modellen in Ihre bestehenden Systeme und Workflows.</p>
          <div class="ai-panel-tags"><span class="ai-panel-tag">Claude</span><span class="ai-panel-tag">GPT-4</span><span class="ai-panel-tag">Gemini</span><span class="ai-panel-tag">REST API</span><span class="ai-panel-tag">Webhooks</span></div>
        </div>
        <div class="ai-panel" data-panel="2">
          <span class="ai-panel-lbl" data-i18n="ai3-label">Bildgenerierung</span>
          <h3 data-i18n="ai3-title">Stable Diffusion für Agenturen</h3>
          <p data-i18n="ai3-body">Automatisierte Bildproduktion, Custom-Workflows und API-Integration für kreative Teams und Medienhäuser.</p>
          <div class="ai-panel-tags"><span class="ai-panel-tag">Stable Diffusion</span><span class="ai-panel-tag">SDXL</span><span class="ai-panel-tag">ComfyUI</span><span class="ai-panel-tag">Batch-Produktion</span></div>
        </div>
        <div class="ai-panel" data-panel="3">
          <span class="ai-panel-lbl" data-i18n="ai4-label">Dokumentenverarbeitung</span>
          <h3 data-i18n="ai4-title">OCR, Klassifizierung & LLM-Extraktion</h3>
          <p data-i18n="ai4-body">Vollautomatische Verarbeitung von Rechnungen, Formularen und Verträgen – strukturierte Daten ohne manuelle Arbeit.</p>
          <div class="ai-panel-tags"><span class="ai-panel-tag">OCR</span><span class="ai-panel-tag">PDF-Extraktion</span><span class="ai-panel-tag">LLM-Parsing</span><span class="ai-panel-tag">n8n</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section id="process" class="s-white" data-theme="light">
  <div class="inner">
    <div class="reveal">
      <span class="label" data-i18n="s-proc-label">Vorgehen</span>
      <h2 class="s-heading" data-i18n-html="s-proc-heading">Strukturiert.<br><em>Von Anfang an.</em></h2>
      <div class="rule"></div>
      <p class="s-body" data-i18n="s-proc-body">Ein erprobter Ablauf, der Überraschungen vermeidet und Sie jederzeit auf dem aktuellen Stand hält.</p>
    </div>
    <div class="proc-grid">
      <div class="proc-step reveal"><div class="proc-n">01</div><h4 data-i18n="proc1-title">Erstgespräch</h4><p data-i18n="proc1-desc">Kostenfrei und unverbindlich. Wir hören zu, stellen Fragen und klären, ob wir die richtige Wahl für Ihr Vorhaben sind.</p></div>
      <div class="proc-step reveal"><div class="proc-n">02</div><h4 data-i18n="proc2-title">Konzept & Angebot</h4><p data-i18n="proc2-desc">Klares schriftliches Angebot mit Leistungsbeschreibung, Zeitplan und transparenter Preisgestaltung – kein Kleingedrucktes.</p></div>
      <div class="proc-step reveal"><div class="proc-n">03</div><h4 data-i18n="proc3-title">Umsetzung</h4><p data-i18n="proc3-desc">Schrittweise Entwicklung mit regelmäßigen Zwischenständen. Sie entscheiden, Sie kontrollieren, Sie steuern.</p></div>
      <div class="proc-step reveal"><div class="proc-n">04</div><h4 data-i18n="proc4-title">Launch & Betrieb</h4><p data-i18n="proc4-desc">Produktiver Start inklusive Dokumentation, Einweisung und – auf Wunsch – fortlaufender Betreuung.</p></div>
    </div>
  </div>
</section>

<!-- PROJECTS -->
<section id="projekte" class="s-light" data-theme="light">
  <div class="inner">
    <div class="reveal">
      <span class="label" data-i18n="s-proj-label">Referenzen</span>
      <h2 class="s-heading" data-i18n-html="s-proj-heading">Projekte, die<br><em>für sich sprechen.</em></h2>
      <div class="rule"></div>
      <p class="s-body" data-i18n="s-proj-body">Reale Lösungen für reale Anforderungen – von der Agentur-Website bis zur eigenen Chat-Plattform.</p>
    </div>
    <div class="proj-grid">
      <!-- Sub-header: Kundenprojekte -->
      <div class="proj-sub reveal">
        <span class="proj-sub-line"></span>
        <span class="proj-sub-label" data-i18n="subheader-clients">Kundenprojekte</span>
        <span class="proj-sub-line"></span>
      </div>

      <!-- TVN: featured full-width, live -->
      <div class="proj-card featured reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-tvn-cm-cat">Web-Entwicklung · CMS</span>
          <span class="proj-badge badge-live">⬤ Live</span>
        </div>
        <h3>TVN Corporate Media</h3>
        <p data-i18n="proj-tvn-cm-desc">Vollständige Agentur-Webpräsenz für eine der führenden Videoproduktionsfirmen Deutschlands – Teil der TVN Group (Hannover). Imagefilme, KI-Produktion, Social Media und mehr.</p>
        <div class="proj-tags"><span class="proj-tag">Coding</span><span class="proj-tag">TVN Group</span><span class="proj-tag">Webdesign</span></div>
        <div class="proj-btns">
          <a href="https://www.tvn-cm.de" target="_blank" rel="noopener" class="proj-btn"><span>www.tvn-cm.de</span><span>↗</span></a>
        </div>
      </div>

      <!-- TVN: featured full-width, live -->
      <div class="proj-card featured reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-tvn-cat">CMS Maintenance</span>
          <span class="proj-badge badge-live">⬤ Live</span>
        </div>
        <h3>TVN</h3>
        <p data-i18n="proj-tvn-desc">Beratung & Betreuung der Typo3 Webpräsenz - Hauptkonzern der TVN Group (Hannover).</p>
        <div class="proj-tags"><span class="proj-tag">Consulting</span><span class="proj-tag">TVN Group</span><span class="proj-tag">CMS Maintenance</span></div>
        <div class="proj-btns">
          <a href="https://www.tvn.de" target="_blank" rel="noopener" class="proj-btn"><span>www.tvn.de</span><span>↗</span></a>
        </div>
      </div>

      <!-- SweatAttack: featured full-width, live -->
      <div class="proj-card featured reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-sweat-cat">Web-App · Activity-Tracker</span>
          <span class="proj-badge badge-live">⬤ Live</span>
        </div>
        <h3>SweatAttack</h3>
        <p data-i18n="proj-sweat-desc">Web-App für Activity-Tracking mit dynamischer Aktivitätsverwaltung und Datenbankanbindung. Entwickelt für eine Privatkundin – einfaches Verwalten und Verfolgen sportlicher Aktivitäten im Freundeskreis.</p>
        <div class="proj-tags"><span class="proj-tag">JS</span><span class="proj-tag">CSS</span><span class="proj-tag">HTML</span><span class="proj-tag">SQL</span></div>
        <div class="proj-btns">
          <a href="https://sweatattack.core-now.com" target="_blank" rel="noopener" class="proj-btn"><span>sweatattack.core-now.com</span><span>↗</span></a>
        </div>
      </div>

      <!-- Sub-header: Tech-Lab -->
      <div class="proj-sub reveal" style="margin-top:12px">
        <span class="proj-sub-line"></span>
        <span class="proj-sub-label" data-i18n="subheader-techlab">Tech-Lab</span>
        <span class="proj-sub-line"></span>
      </div>

      <!-- IEL: Sim-Racing Plattform -->
      <a href="https://iel.core-now.com" target="_blank" rel="noopener" class="proj-card lab featured reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-iel-cat">Full-Stack · Sim-Racing</span>
          <span class="proj-badge badge-live">⬤ Live</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>IEL – Sim-Racing Platform</h3>
        <p data-i18n="proj-iel-desc">Kompetitive Sim-Racing-Plattform mit Echtzeit-Telemetrie, Rundenzeiten und Live-Daten. Onboarding via Discord-Bot (/register), API-Key-System und ein natives Tool, das sich in den Shared Memory des Simulators einklinkt und Telemetrie- sowie Rundendaten liefert.</p>
        <div class="proj-tags"><span class="proj-tag">Discord Bot</span><span class="proj-tag">Telemetry</span><span class="proj-tag">Shared Memory</span><span class="proj-tag">API</span><span class="proj-tag">Live Data</span></div>
      </a>

      <!-- PleepChat: in Entwicklung -->
      <a href="https://core-now.com/pleep" target="_blank" rel="noopener" class="proj-card featured lab reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-pleep-cat">Full-Stack · Desktop-App</span>
          <span class="proj-badge badge-wip" data-i18n="badge-wip">◌ In Entwicklung</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>PleepChat</h3>
        <p data-i18n="proj-pleep-desc">Moderner IRC-basierter Videochat mit WebRTC-Technologie. Desktop-Anwendung mit Instant Messaging, Chatrooms, Peer-to-Peer-Videoübertragung und flexiblen Videokacheln.</p>
        <div class="proj-tags"><span class="proj-tag">Electron</span><span class="proj-tag">WebRTC</span><span class="proj-tag">Node.js</span><span class="proj-tag">IRC</span></div>
      </a>

      <a href="https://omnivision.core-now.com" target="_blank" rel="noopener" class="proj-card lab reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-omni-cat">Web-App · OSINT-Dashboard</span>
          <span class="proj-badge badge-live">⬤ Live</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>OmniVision</h3>
        <p data-i18n="proj-omni-desc">Interaktives Live-OSINT-Dashboard mit 3D-Globus und 2D-Karte. Echtzeit-Visualisierung von Flugbewegungen (ADS-B), Schiffspositionen (AIS), GPS-Störzonen, Satelliten und Webcams – Open Intelligence auf einer einzigen Karte.</p>
        <div class="proj-tags"><span class="proj-tag">3D Globe</span><span class="proj-tag">ADS-B</span><span class="proj-tag">AIS</span><span class="proj-tag">WebGL</span><span class="proj-tag">OSINT</span><span class="proj-tag">Real-time</span></div>
      </a>

      <!-- angebotRadar + Crucifier moved from Kundenprojekte -->
      <a href="https://core-now.com/angebotRadar" target="_blank" rel="noopener" class="proj-card lab reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-radar-cat">Web-App · Automatisierung</span>
          <span class="proj-badge badge-demo">⬤ Live Demo</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>angebotRadar</h3>
        <p data-i18n="proj-radar-desc">Intelligentes Monitoring-Tool zur automatisierten Erkennung und Auswertung von Angeboten und Ausschreibungen.</p>
        <div class="proj-tags"><span class="proj-tag">Web App</span><span class="proj-tag">Monitoring</span><span class="proj-tag">Automation</span></div>
      </a>

      <a href="https://core-now.com/crucifier" target="_blank" rel="noopener" class="proj-card lab reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-cruc-cat">Web-App · Tool</span>
          <span class="proj-badge badge-demo">⬤ Live Demo</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>Crucifier</h3>
        <p data-i18n="proj-cruc-desc">Browserbasierter Kreuzworträtsel-Generator: Wörter und Definitionen eingeben, Rätsel automatisch generieren und direkt ausdrucken oder exportieren.</p>
        <div class="proj-tags"><span class="proj-tag">Generator</span><span class="proj-tag">Browser-Tool</span></div>
      </a>

      <a href="https://github.com/rubirubsen/J.A.R.V.I.S" target="_blank" rel="noopener" class="proj-card lab reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-jarvis-cat">KI-Assistent · Python</span>
          <span class="proj-badge badge-gh"><svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/></svg> Open Source</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>J.A.R.V.I.S</h3>
        <p data-i18n="proj-jarvis-desc">Persönlicher KI-Assistent mit LLM-Integration, Spracherkennung (STT) und Sprachausgabe (TTS), CUDA-Beschleunigung sowie IMAP-Anbindung. Läuft lokal auf NVIDIA Jetson.</p>
        <div class="proj-tags"><span class="proj-tag">Python</span><span class="proj-tag">LLM</span><span class="proj-tag">CUDA</span><span class="proj-tag">Offline AI</span></div>
      </a>

      <a href="https://github.com/rubirubsen/rzde" target="_blank" rel="noopener" class="proj-card lab featured reveal">
        <div class="proj-meta">
          <span class="proj-cat" data-i18n="proj-rzde-cat">DevOps · Serverinfrastruktur</span>
          <span class="proj-badge badge-gh"><svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/></svg> Open Source</span>
          <span class="proj-link">↗</span>
        </div>
        <h3>rzde – Serverinfrastruktur</h3>
        <p data-i18n="proj-rzde-desc">Vollständige Docker-Compose-Infrastruktur: NGINX & RTMP-Streaming, Node.js, PHP-FPM, MySQL, MSSQL, IRC-Server und TeamSpeak – containerisiert und skalierbar.</p>
        <div class="proj-tags"><span class="proj-tag">Docker</span><span class="proj-tag">NGINX</span><span class="proj-tag">RTMP</span><span class="proj-tag">IRC</span></div>
      </a>
    </div>
  </div>
</section>

<!-- INSIGHTS -->
<section id="insights" class="s-white" data-theme="light">
  <div class="inner">
    <div class="reveal">
      <span class="label" data-i18n="s-insights-label">Insights</span>
      <h2 class="s-heading" data-i18n-html="s-insights-heading">Gedanken &amp;<br><em>Einblicke.</em></h2>
      <div class="rule"></div>
      <p class="s-body" data-i18n="s-insights-body">Trends, Erfahrungen und Werkzeuge aus unserem Arbeitsalltag – kompakt und ohne Umwege.</p>
    </div>
    <div class="insights-grid"></div>
    <div class="insights-more reveal">
      <a href="/insights/" class="btn btn-ghost-dark" data-i18n="insights-all">Alle Insights ansehen</a>
    </div>
  </div>
</section>

<!-- PARTNER -->
<section id="partner" class="s-dark" data-theme="dark">
  <div class="inner">
    <div class="reveal">
      <span class="label" data-i18n="s-partner-label">Partner</span>
      <h2 class="s-heading" style="color:var(--chalk)" data-i18n-html="s-partner-heading">Starke Partner.<br><em>Gemeinsam weiter.</em></h2>
      <div class="rule"></div>
      <p class="s-body" style="color:var(--chalk-soft)" data-i18n="s-partner-body">Für Projekte, die mehr als IT erfordern – wir arbeiten mit spezialisierten Partnern zusammen, die dasselbe Qualitätsniveau mitbringen.</p>
    </div>
    <div class="partner-grid">
      <div class="partner-card reveal">
        <div class="partner-img-wrap">
          <img src="assets/img/frljp.jpg" alt="Fräulein Jumpcut" class="partner-img"/>
        </div>
        <div class="partner-body">
          <span class="partner-role" data-i18n="partner-jc-role">Grafik & Design</span>
          <h3 class="partner-name">Fräulein Jumpcut</h3>
          <p data-i18n="partner-jc-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam.</p>
          <a href="https://www.xing.com/profile/Jennifer_Kornau" class="partner-link" target="_blank">Xing Profil ↗</a>
        </div>
      </div>
      <div class="partner-card reveal">
        <div class="partner-img-wrap">
          <img src="https://renew.ekinci-it.de/wp-content/uploads/2026/02/Ekinci-IT-LOGO-1000px.png" alt="Ekinci-IT" class="partner-img"/>
        </div>
        <div class="partner-body">
          <span class="partner-role" data-i18n="partner-eki-role">Hosting & Server</span>
          <h3 class="partner-name">Ekinci-IT</h3>
          <p data-i18n="partner-eki-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam.</p>
          <a href="https://www.ekinci-it.de" class="partner-link" target="_blank">ekinci-it.de ↗</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="s-white" data-theme="light">
  <div class="inner">
    <div class="ct-grid">
      <div class="reveal ct-left">
        <span class="label" data-i18n="s-ct-label">Kontakt</span>
        <h2 data-i18n-html="s-ct-heading">Sprechen wir<br><em>über Ihr Projekt.</em></h2>
        <div class="rule"></div>
        <p data-i18n="s-ct-body">Schildern Sie Ihr Vorhaben – wir antworten binnen 24 Stunden mit einer konkreten Einschätzung und nächsten Schritten.</p>
        <div class="ct-detail"><div><strong data-i18n="ct-email-lbl">E-Mail</strong><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="5d34333b321d3e322f387033322a733e3230">[email&#160;protected]</a></div></div>
        <div class="ct-detail"><div><strong data-i18n="ct-phone-lbl">Telefon</strong>0511 – 64712610</div></div>
        <div class="ct-detail"><div><strong data-i18n="ct-loc-lbl">Standort</strong><span data-i18n="ct-loc-val">Remote · deutschlandweit</span></div></div>
        <div class="ct-detail"><div><strong data-i18n="ct-response-lbl">Reaktionszeit</strong><span data-i18n="ct-response-val">Werktags innerhalb von 24 Stunden</span></div></div>
      </div>
      <div class="reveal">
        <form class="ct-form" id="ctForm" action="mail.php" method="POST">
          <div style="position:absolute;left:-9999px;top:-9999px" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"/></label></div>
          <div class="f-row">
            <div class="f-grp"><label data-i18n="f-firstname">Vorname</label><input type="text" name="vorname" data-i18n-ph="f-firstname-ph" placeholder="Max" required/></div>
            <div class="f-grp"><label data-i18n="f-lastname">Nachname</label><input type="text" name="nachname" data-i18n-ph="f-lastname-ph" placeholder="Mustermann" required/></div>
          </div>
          <div class="f-grp"><label data-i18n="f-email-lbl">E-Mail-Adresse</label><input type="email" name="email" placeholder="max@unternehmen.de" required/></div>
          <div class="f-grp">
            <label data-i18n="f-service-lbl">Gewünschte Leistung</label>
            <select name="leistung" id="serviceSelect">
              <option value="" data-i18n="f-service-ph">Bitte wählen …</option>
              <option data-i18n="opt-cms">CMS-Support & Wartung</option>
              <option data-i18n="opt-web">Webseitenerstellung</option>
              <option data-i18n="opt-app">Individuelle Anwendungsentwicklung</option>
              <option data-i18n="opt-ai">KI-Integration & Workflow-Automatisierung</option>
              <option data-i18n="opt-local">Lokale KI-Umgebung (Offline)</option>
              <option data-i18n="opt-full">Full-Stack-Plattform</option>
              <option data-i18n="opt-consulting">Allgemeine Beratung</option>
            </select>
          </div>
          <div class="f-grp"><label data-i18n="f-msg-lbl">Ihre Nachricht</label><textarea name="nachricht" data-i18n-ph="f-msg-ph" placeholder="Beschreiben Sie kurz Ihr Vorhaben …" required></textarea></div>
          <input type="hidden" name="lang" id="langField" value="de"/>
          <button type="submit" class="f-submit" data-i18n="f-submit">Nachricht absenden</button>
          <p class="f-note" data-i18n="f-note">Alle Angaben werden vertraulich behandelt und nicht weitergegeben (DSGVO).</p>
          <div class="f-ok" id="fOk" data-i18n="f-success">✓ Vielen Dank. Wir melden uns innerhalb von 24 Stunden.</div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer id="footer" data-theme="dark">
  <div class="ft-inner">
    <div class="ft-brand">CORE<em>NOW</em></div>
    <div class="ft-copy" data-i18n="ft-copy">© 2025 CORENOW. Alle Rechte vorbehalten.</div>
    <ul class="ft-links">
      <li><a href="/impressum.php" data-i18n="ft-imprint">Impressum</a></li>
      <li><a href="/datenschutz.php" data-i18n="ft-privacy">Datenschutz</a></li>
      <li><a href="/agb.php" data-i18n="ft-terms">AGB</a></li>
    </ul>
  </div>
</footer>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="assets/js/translations.js"></script>
<script src="assets/js/i18n.js"></script>
<script src="assets/js/nav.js"></script>
<script src="assets/js/reveal.js"></script>
<script src="assets/js/tabs.js"></script>
<script src="assets/js/insights.js"></script>
<script src="assets/js/form.js"></script>

</body>
</html>
<!-- 09:40 -->