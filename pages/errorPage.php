<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Page introuvable | Librairie Chebbi</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@400;600;700&family=Kalam:wght@400;700&display=swap" rel="stylesheet">
<style>
  :root { --navy:#14275f; --yellow:#fdbf1f; --bg:#fbfaf7; --text:#4a5878; }
  * { box-sizing:border-box; margin:0; padding:0; }
  body {
    min-height:100vh; background:var(--bg); color:var(--text);
    font-family:'Nunito',system-ui,sans-serif;
    display:flex; align-items:center; justify-content:center;
    overflow:hidden; position:relative;
  }

  /* decorations */
  .blob { position:absolute; z-index:0; pointer-events:none; }
  .blob.yellow { left:-120px; bottom:-170px; width:460px; height:360px; background:#fdefc2; border-radius:50% 60% 40% 30%; }
  .blob.blue { right:-140px; bottom:-120px; width:520px; height:460px; background:#e6effb; border-radius:60% 40% 30% 50%; }
  .deco { position:absolute; z-index:1; pointer-events:none; }
  .plane { top:6%; right:4%; width:130px; animation:fly 6s ease-in-out infinite; }
  .open-book { left:5%; bottom:4%; width:150px; animation:float 5s ease-in-out infinite; }
  .stack { right:2%; bottom:3%; width:210px; }
  @keyframes fly   { 0%,100%{transform:translate(0,0) rotate(0)} 50%{transform:translate(-14px,10px) rotate(-4deg)} }
  @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }

  /* layout */
  .wrap {
    position:relative; z-index:2;
    width:min(1200px,100%); padding:32px 24px;
    display:grid; grid-template-columns:1.1fr 1fr; align-items:center; gap:24px;
  }
  .scene { width:100%; max-width:640px; justify-self:center; }
  .scene .mascot { transform-origin:370px 420px; animation:wobble 4.5s ease-in-out infinite; }
  .scene .q { font-family:'Baloo 2'; font-weight:800; fill:var(--yellow); animation:bob 2.4s ease-in-out infinite; }
  .scene .q:nth-of-type(2) { animation-delay:.5s; }
  @keyframes wobble { 0%,100%{transform:rotate(0)} 50%{transform:rotate(-1.6deg)} }
  @keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

  .content { text-align:center; }
  .code { position:relative; display:inline-block; font-family:'Baloo 2'; font-weight:800; line-height:1; font-size:clamp(6rem,13vw,10.5rem); color:var(--navy); letter-spacing:-2px; }
  .code .zero { color:var(--yellow); }
  .code .spark { position:absolute; width:46px; height:46px; }
  .code .spark.l { left:-52px; top:22%; }
  .code .spark.r { right:-46px; top:2%; }
  h1 { font-family:'Baloo 2'; font-weight:700; font-size:clamp(1.8rem,3.6vw,2.7rem); color:var(--navy); line-height:1.2; margin:6px 0 14px; }
  .lead { font-size:1.15rem; line-height:1.7; max-width:420px; margin:0 auto 30px; }
  .lead b { font-weight:700; }
  .btn {
    display:inline-flex; align-items:center; gap:14px;
    background:var(--yellow); color:var(--navy); text-decoration:none;
    font-weight:700; font-size:1.1rem; padding:18px 48px; border-radius:999px;
    box-shadow:0 10px 24px rgba(253,191,31,.35);
    transition:transform .2s, box-shadow .2s;
  }
  .btn:hover { transform:translateY(-3px); box-shadow:0 14px 30px rgba(253,191,31,.45); }
  .btn:hover svg { transform:translateX(-4px); }
  .btn svg { width:22px; height:22px; transition:transform .2s; }
  .btn:focus-visible { outline:3px solid var(--navy); outline-offset:3px; }
  .note { margin-top:42px; font-family:'Kalam',cursive; color:var(--navy); font-size:1.1rem; line-height:1.6; transform:rotate(-5deg); display:inline-block; }
  .note b { font-weight:700; }
  .note svg { display:block; margin:4px auto 0; width:130px; }

  @media (max-width:900px) {
    body { overflow:auto; align-items:flex-start; }
    .wrap { grid-template-columns:1fr; padding-top:16px; }
    .scene { max-width:460px; }
    .plane { width:80px; }
    .stack, .open-book { display:none; }
  }
  @media (prefers-reduced-motion:reduce) { * { animation:none !important; } }
</style>
</head>
<body>
<?php  include(__DIR__ . "/../includes/header.php") ?>
<span class="blob yellow"></span>
<span class="blob blue"></span>

<!-- paper plane -->
<svg class="deco plane" viewBox="0 0 130 150" fill="none" aria-hidden="true">
  <path d="M120 8 62 40l22 12 36-44z" fill="#fdbf1f"/>
  <path d="M120 8 84 52l-6 22-16-34z" fill="#f4a90f"/>
  <path d="M30 62C6 80 12 112 40 118c20 4 36-8 22-20-8-6-18 2-10 10M40 118c16 8 40 16 62 28" stroke="#14275f" stroke-width="2" stroke-dasharray="5 6" stroke-linecap="round"/>
</svg>

<!-- open book -->
<svg class="deco open-book" viewBox="0 0 150 130" fill="none" stroke="#6fa8e8" stroke-width="3" stroke-linejoin="round" stroke-linecap="round" aria-hidden="true">
  <path d="M10 50 70 34l16 56-60 16z" fill="#eef5ff"/>
  <path d="M70 34l60 4-10 58-34-6z" fill="#e1eeff"/>
  <path d="M24 60l40-10M28 72l38-9M32 84l34-8M84 48l32 4M82 60l30 3M80 72l26 3" stroke-width="2"/>
  <path d="M18 24l8 12M36 14l4 14M54 12l-2 12" stroke="#6fa8e8"/>
</svg>

<!-- right-bottom stack -->
<svg class="deco stack" viewBox="0 0 210 190" aria-hidden="true">
  <g stroke="#14275f" stroke-width="0">
    <path d="M10 140 90 120l110 14v32L100 182 10 168z" fill="#ef5b5b"/>
    <path d="M100 150l100-16v32l-100 16z" fill="#fdf7ea"/>
    <path d="M30 100 100 86l90 10v30l-90 14-70-8z" fill="#fdbf1f"/>
    <path d="M100 112l90-16v30l-90 14z" fill="#fdf7ea"/>
    <path d="M44 62 110 46l70 12v28l-70 14-66-10z" fill="#2f7be0"/>
    <path d="M110 72l70-14v28l-70 14z" fill="#fdf7ea"/>
  </g>
  <g stroke="#2f7be0" stroke-width="4" stroke-linecap="round"><path d="M150 12l-6 14M172 18l-12 12"/></g>
</svg>

<div class="wrap">

  <!-- Illustration -->
  <svg class="scene" viewBox="0 0 640 560" role="img" aria-label="Un livre perdu qui lit une carte">
    <ellipse cx="340" cy="500" rx="300" ry="30" fill="#ece6df"/>

    <!-- bookshelf -->
    <rect x="96" y="70" width="48" height="400" fill="#fbe6b4" opacity=".7"/>
    <rect x="0" y="60" width="96" height="430" fill="#8fbfd9"/>
    <rect x="12" y="76" width="72" height="120" fill="#6ea3c3"/>
    <rect x="12" y="206" width="72" height="120" fill="#6ea3c3"/>
    <rect x="12" y="336" width="72" height="140" fill="#6ea3c3"/>
    <rect x="12" y="92" width="22" height="100" rx="3" fill="#ef6d6d"/><rect x="38" y="102" width="26" height="90" rx="3" fill="#fdc82f"/>
    <rect x="12" y="222" width="20" height="100" rx="3" fill="#ef6d6d"/><rect x="36" y="232" width="22" height="90" rx="3" fill="#3aa89a"/><rect x="62" y="226" width="20" height="96" rx="3" fill="#f2b64a"/>
    <rect x="12" y="352" width="18" height="120" rx="3" fill="#ef6d6d"/><rect x="34" y="362" width="22" height="110" rx="3" fill="#3aa89a"/><rect x="60" y="356" width="22" height="116" rx="3" fill="#f2b64a"/>

    <!-- plant -->
    <g fill="#2f8159">
      <path d="M92 440C40 420 30 360 60 320c40 20 60 70 32 120z"/>
      <path d="M100 430c-10-60 10-120 60-150 20 50 0 120-60 150z" fill="#3a9468"/>
      <path d="M104 440c40-40 90-50 130-30-20 40-80 50-130 30z"/>
      <path d="M86 440c-40-10-70-40-60-80 40 0 70 30 60 80z" fill="#3a9468"/>
    </g>
    <path d="M52 440h84l-8 56H62z" fill="#f4f1ec"/><rect x="48" y="434" width="92" height="12" rx="6" fill="#fff"/>

    <!-- stack of books -->
    <path d="M168 462h300l28 14v18H196l-28-14z" fill="#1f9e86"/>
    <rect x="176" y="470" width="300" height="20" fill="#fdf7ea"/>
    <path d="M178 412h300l24 12v38H202l-24-12z" fill="#ef5b5b"/>
    <rect x="186" y="428" width="300" height="24" fill="#fdf7ea"/>
    <path d="M184 372h260l22 10v42H206l-22-12z" fill="#2f7be0"/>
    <rect x="190" y="384" width="260" height="24" fill="#fdf7ea"/>

    <!-- legs + shoes -->
    <path d="M440 400c10 30 6 60-10 84" stroke="#111" stroke-width="12" stroke-linecap="round" fill="none"/>
    <path d="M520 410c20 20 22 50 10 78" stroke="#111" stroke-width="12" stroke-linecap="round" fill="none"/>
    <path d="M404 484c10-16 40-12 50 2l-4 18c-14 12-40 12-50 4z" fill="#fff" stroke="#6c6f95" stroke-width="3"/>
    <path d="M504 480c14-22 40-24 54-8l-2 40c-14 14-36 6-46-6z" fill="#fff" stroke="#6c6f95" stroke-width="3"/>

    <!-- mascot book -->
    <g class="mascot">
      <g transform="rotate(-6 370 300)">
        <rect x="270" y="170" width="230" height="260" rx="14" fill="#fdc82f"/>
        <path d="M270 184c0-8 6-14 14-14h30v260h-30c-8 0-14-6-14-14z" fill="#eaa918"/>
        <path d="M284 170 500 150v22L318 190z" fill="#fff6dc"/>
        <!-- glasses -->
        <circle cx="365" cy="300" r="34" fill="#fff4bf" stroke="#14213d" stroke-width="5"/>
        <circle cx="455" cy="300" r="34" fill="#fff4bf" stroke="#14213d" stroke-width="5"/>
        <path d="M399 300h22" stroke="#14213d" stroke-width="5"/>
        <circle cx="372" cy="306" r="15" fill="#14213d"/><circle cx="448" cy="306" r="15" fill="#14213d"/>
        <circle cx="378" cy="300" r="5" fill="#fff"/><circle cx="454" cy="300" r="5" fill="#fff"/>
        <!-- brows + mouth -->
        <path d="M340 260c14-6 28-6 38 2M440 262c10-8 24-8 36-2" stroke="#14213d" stroke-width="4" fill="none" stroke-linecap="round"/>
        <path d="M410 356c8-8 20-8 28 0" stroke="#14213d" stroke-width="4" fill="none" stroke-linecap="round"/>
      </g>
      <!-- arms -->
      <path d="M296 340c-20 40-4 90 40 108" stroke="#111" stroke-width="12" stroke-linecap="round" fill="none"/>
      <path d="M500 390c40 10 70 40 66 72" stroke="#111" stroke-width="12" stroke-linecap="round" fill="none"/>
      <!-- map -->
      <path d="M330 440 410 412 470 422 560 390 590 470 500 480 440 470 360 495z" fill="#cfe2f3"/>
      <path d="M410 412l-20 74M470 422l-8 56M520 440l-16 40M340 460l210-20" stroke="#fff" stroke-width="3" fill="none"/>
      <path d="M470 440c-16-22-16-32-6-40 10-6 22-2 24 10 2 10-6 20-18 30z" fill="#ef5b5b"/><circle cx="470" cy="418" r="5" fill="#fff"/>
      <circle cx="326" cy="446" r="22" fill="#fff" stroke="#d8d8e2" stroke-width="2"/>
      <circle cx="574" cy="460" r="20" fill="#fff" stroke="#d8d8e2" stroke-width="2"/>
    </g>

    <!-- question marks -->
    <text class="q" x="470" y="140" font-size="86" transform="rotate(-10 470 140)">?</text>
    <text class="q" x="540" y="200" font-size="64" transform="rotate(15 540 200)">?</text>
  </svg>

  <!-- Text -->
  <div class="content">
    <div class="code">
      <svg class="spark l" viewBox="0 0 46 46" fill="none" stroke="#fdbf1f" stroke-width="5" stroke-linecap="round"><path d="M6 14l14 8M4 34l12-4"/></svg>
      4<span class="zero">0</span>4
      <svg class="spark r" viewBox="0 0 46 46" fill="none" stroke="#fdbf1f" stroke-width="5" stroke-linecap="round"><path d="M6 6l4 14M22 20l16-8M26 36l12 2"/></svg>
    </div>
    <h1>Oups&nbsp;! Page introuvable</h1>
    <p class="lead"><b>La page que vous recherchez</b> n'existe pas ou a peut-être été déplacée.</p>

    <a class="btn" href="/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12H5M11 5l-7 7 7 7"/></svg>
      Retour à l'accueil
    </a>

    <div>
      <p class="note">Pas de panique&nbsp;!<br>Chez <b>Librairie Chebbi</b>, chaque page compte&nbsp;!
        <svg viewBox="0 0 130 10" fill="none"><path d="M3 6c30-5 70-5 124-2" stroke="#fdbf1f" stroke-width="3" stroke-linecap="round"/></svg>
      </p>
    </div>
  </div>

</div>
</body>
</html>