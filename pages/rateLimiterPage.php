<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Trop de requêtes | Chebbi Librairie</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --navy: #0f1b4c;
    --blue: #3b82f6;
    --yellow: #fbbf24;
    --red: #f4616d;
    --text: #4b5563;
    --bg: #f9fafc;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  html, body { height: 100%; }
  body {
    font-family: 'Poppins', system-ui, sans-serif;
    background: var(--bg);
    color: var(--text);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
  }

  /* ---------- Animated background (low opacity) ---------- */
  .bg { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
  .blob {
    position: absolute; border-radius: 50%; filter: blur(60px); opacity: .35;
    animation: drift 18s ease-in-out infinite alternate;
  }
  .blob.b1 { width: 420px; height: 420px; background: #dbe7ff; top: -140px; right: -100px; }
  .blob.b2 { width: 380px; height: 380px; background: #fdf0c4; bottom: -140px; left: -120px; animation-duration: 22s; }
  .blob.b3 { width: 340px; height: 340px; background: #e4ecff; bottom: -120px; right: -80px; animation-duration: 26s; }
  @keyframes drift {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(40px, -30px) scale(1.12); }
  }
  .float {
    position: absolute; bottom: -80px; opacity: 0;
    animation: rise linear infinite;
  }
  .float svg { width: 100%; height: 100%; display: block; }
  @keyframes rise {
    0%   { transform: translateY(0) rotate(0deg); opacity: 0; }
    10%  { opacity: var(--o, .1); }
    90%  { opacity: var(--o, .1); }
    100% { transform: translateY(-115vh) rotate(var(--r, 180deg)); opacity: 0; }
  }

  /* ---------- Content ---------- */
  main {
    position: relative; z-index: 1;
    text-align: center;
    padding: 24px;
    max-width: 720px;
    width: 100%;
  }
  .illustration { width: min(440px, 80vw); height: auto; margin: 0 auto 28px; display: block; }
  .sweep { transform-origin: 210px 118px; animation: tick 60s linear infinite; }
  .stop { transform-origin: 322px 150px; animation: pulse 2.4s ease-in-out infinite; }
  .spark { animation: blink 1.8s ease-in-out infinite; }
  .spark:nth-child(2) { animation-delay: .3s; }
  .spark:nth-child(3) { animation-delay: .6s; }
  @keyframes tick  { to { transform: rotate(360deg); } }
  @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.06); } }
  @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: .25; } }

  h1 {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--navy);
    letter-spacing: -.5px;
    margin-bottom: 14px;
  }
  p.lead { font-size: 1.1rem; line-height: 1.7; max-width: 560px; margin: 0 auto 28px; }

  .timer {
    display: inline-flex; align-items: center; gap: 18px;
    background: #eaf0ff;
    border-radius: 28px;
    padding: 18px 44px 18px 32px;
    margin-bottom: 32px;
    text-align: left;
  }
  .timer svg { width: 44px; height: 44px; flex: none; }
  .timer .label { color: var(--blue); font-weight: 500; font-size: .95rem; }
  .timer .count { color: var(--navy); font-weight: 600; font-size: 1.9rem; line-height: 1.2; font-variant-numeric: tabular-nums; }

  .btn {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--yellow); color: var(--navy);
    font-family: inherit; font-weight: 600; font-size: .95rem;
    text-decoration: none; border: 0; cursor: pointer;
    padding: 16px 38px; border-radius: 999px;
    box-shadow: 0 8px 20px rgba(251, 191, 36, .35);
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(251, 191, 36, .45); }
  .btn:focus-visible { outline: 3px solid var(--blue); outline-offset: 3px; }
  .btn svg { width: 18px; height: 18px; }

  @media (max-width: 520px) {
    .timer { padding: 14px 26px 14px 20px; gap: 14px; }
    .timer .count { font-size: 1.6rem; }
  }
  @media (prefers-reduced-motion: reduce) {
    .blob, .float, .sweep, .stop, .spark { animation: none; }
    .float { opacity: .06; bottom: auto; }
  }
</style>
</head>
<body>

<!-- Animated background -->
<div class="bg" aria-hidden="true">
  <span class="blob b1"></span>
  <span class="blob b2"></span>
  <span class="blob b3"></span>
  <div id="floaters"></div>
</div>

<main>
  <svg class="illustration" viewBox="0 0 420 270" role="img" aria-label="Chronomètre et livres, accès temporairement bloqué">
    <ellipse cx="210" cy="250" rx="190" ry="10" fill="#dfe8fb" opacity=".7"/>
    <path d="M70 120c10-50 70-70 120-60 40-15 110-10 140 40 40 20 50 80 10 120-30 25-90 25-130 20-60 5-150-5-140-120z" fill="#e8efff" opacity=".8"/>

    <!-- books -->
    <g>
      <rect x="22" y="196" width="130" height="22" rx="11" fill="none" stroke="#3b82f6" stroke-width="5"/>
      <rect x="30" y="203" width="110" height="8" rx="4" fill="#fff"/>
      <rect x="24" y="170" width="120" height="24" rx="8" fill="#fbbf24"/>
      <rect x="34" y="177" width="90" height="8" rx="4" fill="#fff" opacity=".85"/>
      <rect x="30" y="146" width="112" height="24" rx="8" fill="#f4b73a"/>
      <rect x="38" y="152" width="40" height="8" rx="4" fill="#fff" opacity=".8"/>
      <rect x="36" y="124" width="118" height="22" rx="6" fill="#3b82f6"/>
      <rect x="44" y="130" width="50" height="7" rx="3.5" fill="#fff" opacity=".85"/>
    </g>

    <!-- stopwatch -->
    <rect x="186" y="14" width="48" height="16" rx="8" fill="#3b82f6"/>
    <rect x="203" y="28" width="14" height="12" fill="#3b82f6"/>
    <rect x="128" y="50" width="16" height="9" rx="4.5" fill="#8db5fb" transform="rotate(-40 136 54)"/>
    <circle cx="210" cy="118" r="88" fill="#3b82f6"/>
    <circle cx="210" cy="118" r="72" fill="#fff"/>
    <g stroke="#1e2a5a" stroke-width="5" stroke-linecap="round">
      <line x1="210" y1="58" x2="210" y2="70"/>
      <line x1="210" y1="166" x2="210" y2="178"/>
      <line x1="150" y1="118" x2="162" y2="118"/>
      <line x1="258" y1="118" x2="270" y2="118"/>
    </g>
    <line x1="210" y1="118" x2="190" y2="100" stroke="#1e2a5a" stroke-width="6" stroke-linecap="round"/>
    <g class="sweep">
      <line x1="210" y1="118" x2="210" y2="72" stroke="#f4616d" stroke-width="4" stroke-linecap="round"/>
    </g>
    <circle cx="210" cy="118" r="7" fill="#f4616d"/>
    <circle cx="210" cy="118" r="3" fill="#fff"/>

    <!-- stop badge -->
    <g class="stop">
      <circle cx="322" cy="150" r="48" fill="#f4616d"/>
      <rect x="300" y="143" width="44" height="14" rx="7" fill="#fff" opacity=".9"/>
    </g>

    <!-- sparks -->
    <g stroke="#fbbf24" stroke-width="5" stroke-linecap="round">
      <line class="spark" x1="320" y1="40" x2="324" y2="58"/>
      <line class="spark" x1="336" y1="52" x2="350" y2="64"/>
      <line class="spark" x1="338" y1="74" x2="360" y2="80"/>
    </g>
  </svg>

  <h1>Trop de requêtes !</h1>
  <p class="lead">Vous avez dépassé la limite de requêtes autorisées.<br>Veuillez patienter quelques instants avant de réessayer.</p>

  <div class="timer" role="timer" aria-live="off">
    <svg viewBox="0 0 48 48" fill="none" stroke="#3b82f6" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <circle cx="24" cy="24" r="20"/><path d="M24 12v13l8 5"/>
    </svg>
    <div>
      <div class="label" id="label">Vous pourrez réessayer dans :</div>
      <div class="count" id="count" data-seconds="<?= (int) $_GET["retry"] ?>">01:00</div>
    </div>
  </div>

  <div>
    <a class="btn" id="home" href="/">
      <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 3 2 12h3v8h5v-5h4v5h5v-8h3L12 3z"/></svg>
      Retour à l'accueil
    </a>
  </div>
</main>

<script>
  // ---------- Countdown ----------
  // In Symfony, replace data-seconds with the Retry-After value, e.g. data-seconds="{{ retry_after }}"
  const countEl = document.getElementById('count');
  const labelEl = document.getElementById('label');
  let remaining = parseInt(countEl.dataset.seconds, 10) || 60;

  const fmt = s => String(Math.floor(s / 60)).padStart(2, '0') + ':' + String(s % 60).padStart(2, '0');
  countEl.textContent = fmt(remaining);

  const timer = setInterval(() => {
    remaining--;
    countEl.textContent = fmt(Math.max(remaining, 0));
    if (remaining <= 0) {
      clearInterval(timer);
      labelEl.textContent = 'Vous pouvez réessayer maintenant';
      document.getElementById('home').textContent = 'Réessayer';
      document.getElementById('home').href = document.referrer || '/';
    }
  }, 1000);

  // ---------- Floating school supplies ----------
  const icons = [
    // pencil
    '<svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="1.6" stroke-linejoin="round"><path d="M4 20l1-5L16 4l4 4L9 19l-5 1z"/><path d="M14 6l4 4"/></svg>',
    // book
    '<svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.6" stroke-linejoin="round"><path d="M4 5a2 2 0 0 1 2-2h13v16H6a2 2 0 0 0-2 2V5z"/><path d="M8 7h7"/></svg>',
    // ruler
    '<svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="1.6" stroke-linejoin="round"><rect x="2" y="8" width="20" height="8" rx="1.5"/><path d="M6 8v3M10 8v4M14 8v3M18 8v4"/></svg>',
    // paperclip
    '<svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11l-8 8a5 5 0 0 1-7-7l9-9a3.5 3.5 0 0 1 5 5l-9 9a2 2 0 0 1-3-3l8-8"/></svg>',
    // star
    '<svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="1.6" stroke-linejoin="round"><path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9L12 3z"/></svg>',
    // clock
    '<svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="1.6" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
    // notebook
    '<svg viewBox="0 0 24 24" fill="none" stroke="#6b8ff0" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 3v18M12 8h4M12 12h4"/></svg>'
  ];

  const host = document.getElementById('floaters');
  const rand = (a, b) => a + Math.random() * (b - a);

  for (let i = 0; i < 22; i++) {
    const el = document.createElement('span');
    el.className = 'float';
    const size = rand(28, 72);
    el.style.cssText =
      `left:${rand(0, 98)}%;width:${size}px;height:${size}px;` +
      `--o:${rand(.06, .13).toFixed(2)};--r:${Math.round(rand(-300, 300))}deg;` +
      `animation-duration:${rand(22, 44).toFixed(1)}s;animation-delay:${(-rand(0, 40)).toFixed(1)}s;`;
    el.innerHTML = icons[i % icons.length];
    host.appendChild(el);
  }
</script>
</body>
</html>