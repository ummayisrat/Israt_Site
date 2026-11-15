<?php

session_start();

$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) { @mkdir($dataDir, 0777, true); }
$likesFile       = $dataDir . '/likes.json';
$viewsFile       = $dataDir . '/views.json';
$transFile       = $dataDir . '/transmissions.json';
$subsFile        = $dataDir . '/subscribers.json';

function readJson($file, $default) {
    if (!file_exists($file)) return $default;
    $raw = @file_get_contents($file);
    $d = json_decode($raw, true);
    return is_array($d) ? $d : $default;
}
function writeJson($file, $data) {
    @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
}

/*  contact sheet*/
$posts = [
    [
        'slug'    => 'the-noise-floor',
        'frame'   => '001',
        'date'    => 'Aug 24, 2026',
        'title'   => 'The Noise Floor',
        'tags'    => ['film', 'process'],
        'excerpt' => 'Every negative has a noise floor — the grain you can\'t develop away, only work with.',
        'body'    => "I stopped fighting grain around roll forty. Push a 400-speed stock to 1600 and the noise floor rises until it's practically the subject. For a while I tried to print around it — softer enlarger light, longer development, anything to smooth it out. Then I printed one frame at full contrast, grain and all, and it was the first print that looked like the night actually felt. The floor isn't the enemy. It's the room tone.",
    ],
    [
        'slug'    => 'dead-air-at-2am',
        'frame'   => '002',
        'date'    => 'Aug 18, 2026',
        'title'   => 'Dead Air at 2 A.M.',
        'tags'    => ['sound', 'city'],
        'excerpt' => 'The city doesn\'t go quiet — it just changes frequency, and I got a mic close enough to hear it.',
        'body'    => "There's a stretch between the last trains and the first deliveries where the city sounds almost synthetic — HVAC hum, a transformer somewhere, the specific static of sodium streetlights. I've started recording it the same nights I shoot. The photographs need the tape to make sense later; without it the frames just look empty. With it, you can tell the emptiness was full of something.",
    ],
    [
        'slug'    => 'chromatic-drift',
        'frame'   => '003',
        'date'    => 'Aug 11, 2026',
        'title'   => 'Chromatic Drift',
        'tags'    => ['film', 'color'],
        'excerpt' => 'Expired color stock doesn\'t fail evenly. It fails in one channel first, and that channel tells on the whole roll.',
        'body'    => "A roll of Kodak that sat in a drawer for six years came back last week with the reds gone soft and the blues holding on stubbornly, like the emulsion aged one layer at a time instead of all at once. I used to think color shift was just decay. Now I think it's more like a fingerprint — every expired roll drifts a slightly different way depending on where it was stored, and you can date a photograph by how far the channels have drifted apart.",
    ],
    [
        'slug'    => 'the-fourth-wall-of-glass',
        'frame'   => '004',
        'date'    => 'Aug 02, 2026',
        'title'   => 'The Fourth Wall of Glass',
        'tags'    => ['city', 'process'],
        'excerpt' => 'Shooting through a window adds a wall the viewer can\'t see but can somehow feel.',
        'body'    => "Reflections in glass are usually treated as a problem to eliminate — a polarizer, a different angle, wait for the light to change. I've started leaving them in on purpose. A photograph taken through a window carries an extra layer of information: whatever's behind the camera gets folded into whatever's in front of it. It's the closest thing a still photograph has to depth of time.",
    ],
    [
        'slug'    => 'signal-to-noise',
        'frame'   => '005',
        'date'    => 'Jul 27, 2026',
        'title'   => 'Signal to Noise',
        'tags'    => ['sound', 'color'],
        'excerpt' => 'The ratio matters more than either number alone — a loud signal in a louder room says nothing.',
        'body'    => "Engineers talk about signal-to-noise ratio like it's purely technical, but it's the most useful idea I've stolen for photography. A perfectly sharp, perfectly exposed frame of nothing in particular has a terrible ratio — all signal, no noise, and somehow still empty. My favorite frames have plenty of noise: grain, blur, a reflection, a cut-off edge. What they also have is one thing in the frame loud enough to cut through it. That's the only ratio I'm trying to get right anymore.",
    ],
];

$slugs = array_map(function($p){ return $p['slug']; }, $posts);
$likes = readJson($likesFile, array_fill_keys($slugs, 0));
$views = readJson($viewsFile, array_fill_keys($slugs, 0));
foreach ($slugs as $s) {
    if (!isset($likes[$s])) $likes[$s] = 0;
    if (!isset($views[$s])) $views[$s] = 0;
}
$transmissions = readJson($transFile, []);
$subscribers   = readJson($subsFile, []);

/* AJAX endpoints (same file) */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    if ($action === 'like') {
        $slug = $_POST['slug'] ?? '';
        if (isset($likes[$slug])) {
            $key = 'liked_' . $slug;
            if (empty($_SESSION[$key])) {
                $likes[$slug]++;
                $_SESSION[$key] = true;
                writeJson($likesFile, $likes);
            }
            echo json_encode(['ok' => true, 'count' => $likes[$slug]]);
        } else { echo json_encode(['ok' => false]); }
        exit;
    }

    if ($action === 'view') {
        $slug = $_POST['slug'] ?? '';
        if (isset($views[$slug])) {
            $key = 'viewed_' . $slug;
            if (empty($_SESSION[$key])) {
                $views[$slug]++;
                $_SESSION[$key] = true;
                writeJson($viewsFile, $views);
            }
            echo json_encode(['ok' => true, 'count' => $views[$slug]]);
        } else { echo json_encode(['ok' => false]); }
        exit;
    }

    if ($action === 'transmit') {
        $name    = trim(strip_tags($_POST['name'] ?? ''));
        $message = trim(strip_tags($_POST['message'] ?? ''));
        if ($name === '') $name = 'Unidentified signal';
        $name    = mb_substr($name, 0, 40);
        $message = mb_substr($message, 0, 500);
        if ($message !== '') {
            $entry = [
                'name'    => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
                'time'    => date('M j, Y · g:ia'),
                'hue'     => array_sum(array_map('ord', str_split($name))) % 360,
            ];
            array_unshift($transmissions, $entry);
            $transmissions = array_slice($transmissions, 0, 80);
            writeJson($transFile, $transmissions);
            echo json_encode(['ok' => true, 'entry' => $entry]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'empty']);
        }
        exit;
    }

    if ($action === 'subscribe') {
        $email = trim($_POST['email'] ?? '');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (!in_array($email, $subscribers, true)) {
                $subscribers[] = $email;
                writeJson($subsFile, $subscribers);
            }
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'invalid email']);
        }
        exit;
    }
}

/* server-generated "signal" for the on-air meter */
$signal = random_int(58, 99);
$totalLikes = array_sum($likes);
$totalViews = array_sum($views);
$totalTransmissions = count($transmissions);

/* posts payload for client-side JS (search/filter/lightbox) */
$postsPublic = array_map(function($p) use ($likes, $views) {
    return [
        'slug' => $p['slug'], 'frame' => $p['frame'], 'date' => $p['date'],
        'title' => $p['title'], 'tags' => $p['tags'], 'excerpt' => $p['excerpt'],
        'body' => $p['body'], 'likes' => $likes[$p['slug']], 'views' => $views[$p['slug']],
    ];
}, $posts);
$allTags = [];
foreach ($posts as $p) foreach ($p['tags'] as $t) $allTags[$t] = true;
$allTags = array_keys($allTags);
sort($allTags);
?><!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aperture &amp; Static — contact sheet no. 5</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700&family=Literata:ital,wght@0,400;0,500;1,400&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#121213; --surface:#18181a; --surface-2:#1f1f21;
  --ink:#eeeae1; --ink-dim:#9c968a;
  --amber:#e8a33d; --teal:#3ecfc1;
  --line: rgba(238,234,225,0.12);
  --shadow: 0 40px 80px -40px rgba(0,0,0,0.6);
  --ease: cubic-bezier(.22,1,.36,1);
  --grain-opacity: .045;
}
html[data-theme="light"]{
  --bg:#f3ede1; --surface:#fffdf8; --surface-2:#ece4d3;
  --ink:#1c1a17; --ink-dim:#6b665c;
  --amber:#c9791f; --teal:#0f8f83;
  --line: rgba(28,26,23,0.14);
  --shadow: 0 40px 80px -40px rgba(28,26,23,0.25);
  --grain-opacity: .035;
}

*{ box-sizing:border-box; }
html{ scroll-behavior:smooth; }
body{
  margin:0; background: var(--bg); color: var(--ink);
  font-family:'Literata', Georgia, serif; font-weight:400; line-height:1.7;
  -webkit-font-smoothing:antialiased;
  transition: background .5s var(--ease), color .5s var(--ease);
  overflow-x:hidden;
}
body::before{
  content:""; position:fixed; inset:0; z-index:3000; pointer-events:none;
  opacity: var(--grain-opacity); mix-blend-mode: overlay;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='140' height='140'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}
::selection{ background: var(--amber); color:#121213; }
a{ color:inherit; }
button{ font-family:inherit; }

.mono{ font-family:'IBM Plex Mono', monospace; }
.eyebrow{
  font-family:'IBM Plex Mono', monospace; font-size:.7rem; letter-spacing:.18em;
  text-transform:uppercase; color: var(--ink-dim);
}

/* progress bar */
#progress{
  position:fixed; top:0; left:0; height:2px; width:0%;
  background: linear-gradient(90deg, var(--amber), var(--teal));
  z-index:4000; transition: width .1s linear;
}

.wrap{ max-width: 980px; margin:0 auto; padding: 0 28px; }

header.top{
  position:sticky; top:0; z-index:900;
  backdrop-filter: blur(12px);
  background: color-mix(in srgb, var(--bg) 80%, transparent);
  border-bottom:1px solid var(--line);
}
.top-inner{ max-width:980px; margin:0 auto; padding:16px 28px; display:flex; align-items:center; justify-content:space-between; gap:16px; }
.brand{ font-family:'Bricolage Grotesque', sans-serif; font-weight:600; font-size:1.05rem; letter-spacing:-0.01em; display:flex; align-items:center; gap:10px;}
.brand .dot{ width:8px; height:8px; border-radius:50%; background: var(--teal); animation: blink 1.8s ease-in-out infinite; }
@keyframes blink{ 0%,100%{ opacity:1; } 50%{ opacity:.25; } }
.top-right{ display:flex; align-items:center; gap:18px; }
.rec{ font-size:.68rem; letter-spacing:.08em; color: var(--ink-dim); display:flex; align-items:center; gap:6px;}
.rec .dot{ width:6px; height:6px; border-radius:50%; background: var(--amber); animation: blink 1s steps(2) infinite; }
.theme-btn{
  background:none; border:1px solid var(--line); border-radius:999px;
  width:34px; height:34px; cursor:pointer; color: var(--ink); font-size:.9rem;
  display:flex; align-items:center; justify-content:center; transition: border-color .3s, transform .3s;
}
.theme-btn:hover{ border-color: var(--amber); transform: rotate(20deg); }

/* hero */
.hero{ position:relative; padding:110px 0 70px; overflow:hidden; }
.hero-blob{
  position:absolute; border-radius:50%; filter: blur(70px); pointer-events:none;
  transition: transform .3s var(--ease);
}
.hero-blob.b1{ width:340px; height:340px; background: var(--amber); opacity:.18; top:-100px; right:-60px; }
.hero-blob.b2{ width:280px; height:280px; background: var(--teal); opacity:.16; bottom:-120px; left:-40px; }

.signal{ display:flex; align-items:center; gap:10px; margin-bottom:26px; }
.signal-bar{ width:120px; height:4px; background:var(--line); border-radius:2px; overflow:hidden; }
.signal-fill{ height:100%; width:0%; background: linear-gradient(90deg,var(--teal),var(--amber)); transition: width 1.4s var(--ease) .2s; }

.hero h1{
  font-family:'Bricolage Grotesque', sans-serif; font-weight:600;
  font-size: clamp(2.6rem, 7.4vw, 4.6rem); line-height:1.02; letter-spacing:-0.02em;
  margin: 0 0 22px; position:relative; cursor:default;
}
.glitch{ position:relative; display:inline-block; }
.glitch::before, .glitch::after{
  content: attr(data-text); position:absolute; left:0; top:0; width:100%; height:100%;
  opacity:0; mix-blend-mode: screen;
}
.glitch::before{ color: var(--teal); }
.glitch::after{ color: var(--amber); }
.glitch:hover::before{ opacity:.8; animation: glitchShift .32s steps(2,end) infinite; }
.glitch:hover::after{ opacity:.8; animation: glitchShift 0.32s steps(2,end) infinite reverse; }
@keyframes glitchShift{
  0%{ transform: translate(0,0); }
  25%{ transform: translate(-3px,1px); }
  50%{ transform: translate(3px,-1px); }
  75%{ transform: translate(-2px,-1px); }
  100%{ transform: translate(0,0); }
}
.hero p.lede{ max-width:56ch; font-size:1.12rem; color: var(--ink-dim); margin-top:10px; }

/* section head */
.section-head{ display:flex; align-items:baseline; gap:14px; margin: 86px 0 30px; }
.section-head h2{ font-family:'Bricolage Grotesque', sans-serif; font-weight:600; font-size:1.5rem; margin:0; }
.section-head .rule{ flex:1; height:1px; background: var(--line); }
.section-head .count{ font-family:'IBM Plex Mono', monospace; font-size:.7rem; color:var(--ink-dim); }

/* controls: search + tags */
.controls{ display:flex; flex-wrap:wrap; gap:12px; align-items:center; margin-bottom:34px; }
.search-box{
  flex:1; min-width:200px; display:flex; align-items:center; gap:8px;
  border:1px solid var(--line); border-radius:999px; padding:9px 16px;
  background: var(--surface);
}
.search-box input{
  border:none; outline:none; background:transparent; color:var(--ink);
  font-family:'IBM Plex Mono', monospace; font-size:.82rem; width:100%;
}
.search-box input::placeholder{ color: var(--ink-dim); }
.tag-chip{
  font-family:'IBM Plex Mono', monospace; font-size:.7rem; letter-spacing:.04em;
  border:1px solid var(--line); border-radius:999px; padding:7px 14px; cursor:pointer;
  background:transparent; color: var(--ink-dim); transition: all .25s var(--ease);
}
.tag-chip:hover{ border-color: var(--teal); color: var(--ink); }
.tag-chip.active{ background: var(--ink); color: var(--bg); border-color: var(--ink); }

/* contact sheet grid */
.sheet{ display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:2px; background: var(--line); border:1px solid var(--line); }
.frame{
  background: var(--surface); padding:24px 20px; cursor:pointer; position:relative;
  opacity:0; transform: translateY(18px); transition: opacity .6s var(--ease), transform .6s var(--ease), background .3s;
  overflow:hidden;
}
.frame.visible{ opacity:1; transform:none; }
.frame.hidden-by-filter{ display:none; }
.frame::before{
  content:""; position:absolute; inset:0; background:
    repeating-linear-gradient(180deg, transparent 0 3px, rgba(255,255,255,0.015) 3px 4px);
  pointer-events:none;
}
.frame:hover{ background: var(--surface-2); }
.frame-no{ font-family:'IBM Plex Mono', monospace; font-size:.68rem; color: var(--amber); letter-spacing:.06em; }
.frame-title{ font-family:'Bricolage Grotesque', sans-serif; font-weight:600; font-size:1.2rem; margin:10px 0 8px; line-height:1.2; }
.frame-excerpt{ font-size:.92rem; color: var(--ink-dim); margin:0 0 14px; }
.frame-meta{ display:flex; gap:12px; font-family:'IBM Plex Mono', monospace; font-size:.68rem; color: var(--ink-dim); }
.frame-tags{ margin-top:12px; display:flex; gap:6px; flex-wrap:wrap; }
.frame-tags span{ font-family:'IBM Plex Mono', monospace; font-size:.62rem; padding:3px 8px; border:1px solid var(--line); border-radius:999px; color: var(--ink-dim); }
.no-results{ padding:40px 20px; text-align:center; color: var(--ink-dim); font-family:'IBM Plex Mono', monospace; font-size:.8rem; grid-column:1/-1; background:var(--surface); }


.lightbox{
  position:fixed; inset:0; z-index:3500; display:flex; align-items:flex-start; justify-content:center;
  overflow-y:auto; padding: 60px 20px;
  background: color-mix(in srgb, var(--bg) 92%, transparent);
  backdrop-filter: blur(6px);
  opacity:0; visibility:hidden; transition: opacity .4s var(--ease), visibility 0s .4s;
}
.lightbox.open{ opacity:1; visibility:visible; transition: opacity .4s var(--ease); }
.lb-card{
  max-width:680px; width:100%; background: var(--surface); border:1px solid var(--line);
  border-radius:6px; padding:44px 40px; position:relative; box-shadow: var(--shadow);
  transform: scale(.94) translateY(20px); transition: transform .45s var(--ease);
}
.lightbox.open .lb-card{ transform:none; }
.lb-close{
  position:absolute; top:18px; right:18px; width:34px; height:34px; border-radius:50%;
  border:1px solid var(--line); background:transparent; color:var(--ink); cursor:pointer; font-size:1rem;
  display:flex; align-items:center; justify-content:center; transition: border-color .3s, transform .3s;
}
.lb-close:hover{ border-color: var(--amber); transform: rotate(90deg); }
.lb-frame-no{ font-family:'IBM Plex Mono', monospace; color:var(--amber); font-size:.75rem; letter-spacing:.08em; }
.lb-title{ font-family:'Bricolage Grotesque', sans-serif; font-weight:600; font-size:2rem; margin:12px 0 18px; line-height:1.08; }
.lb-body p{ font-size:1.05rem; }
.lb-foot{ display:flex; align-items:center; gap:18px; margin-top:30px; padding-top:22px; border-top:1px dashed var(--line); flex-wrap:wrap; }
.like-btn{
  display:inline-flex; align-items:center; gap:8px; font-family:'IBM Plex Mono', monospace; font-size:.75rem;
  background:transparent; border:1px solid var(--line); border-radius:999px; padding:8px 16px; cursor:pointer;
  color: var(--ink-dim); transition: all .3s var(--ease);
}
.like-btn:hover{ border-color: var(--amber); color: var(--amber); }
.like-btn.liked{ background: var(--amber); border-color: var(--amber); color:#121213; }
.like-btn.pulse .drop{ animation: splash .5s var(--ease); }
@keyframes splash{ 0%{transform:scale(1);} 35%{transform:scale(1.7);} 100%{transform:scale(1);} }
.view-count{ font-family:'IBM Plex Mono', monospace; font-size:.72rem; color: var(--ink-dim); }

/* transmissions (guestbook) */
.gb-form{ display:grid; gap:12px; margin-bottom:36px; padding:26px; border:1px solid var(--line); border-radius:6px; background: var(--surface); }
.gb-row{ display:grid; grid-template-columns: 1fr 2fr; gap:12px; }
input, textarea{
  font-family:'Literata', serif; font-size:.96rem; background: var(--bg); border:1px solid var(--line);
  border-radius:4px; padding:11px 13px; color: var(--ink); outline:none; resize:vertical; transition: border-color .3s;
}
input:focus, textarea:focus{ border-color: var(--teal); }
textarea{ min-height:80px; }
.gb-submit{
  justify-self:start; font-family:'IBM Plex Mono', monospace; font-size:.74rem; letter-spacing:.06em; text-transform:uppercase;
  background: var(--ink); color: var(--bg); border:none; border-radius:999px; padding:11px 24px; cursor:pointer;
  transition: background .3s, transform .3s var(--ease);
}
.gb-submit:hover{ background: var(--amber); color:#121213; transform: translateY(-1px); }
.gb-status{ font-family:'IBM Plex Mono', monospace; font-size:.7rem; color: var(--teal); min-height:1em; }
.gb-item{ display:flex; gap:14px; padding:18px 4px; border-top:1px solid var(--line); opacity:0; transform: translateY(-8px); animation: settle .5s var(--ease) forwards; }
@keyframes settle{ to{ opacity:1; transform:none; } }
.gb-avatar{ width:34px; height:34px; border-radius:50%; flex:none; margin-top:2px; }
.gb-who{ font-family:'IBM Plex Mono', monospace; font-size:.72rem; color: var(--teal); }
.gb-who .when{ color: var(--ink-dim); margin-left:8px; }
.gb-item p{ margin:6px 0 0; }
.gb-empty{ color: var(--ink-dim); font-style:italic; padding:18px 4px; }


.freq{
  margin:90px 0 60px; padding:40px; border:1px solid var(--line); border-radius:6px;
  background: linear-gradient(135deg, color-mix(in srgb, var(--amber) 8%, transparent), color-mix(in srgb, var(--teal) 8%, transparent));
  display:flex; flex-wrap:wrap; gap:24px; align-items:center; justify-content:space-between;
}
.freq-copy h3{ font-family:'Bricolage Grotesque', sans-serif; margin:0 0 6px; font-size:1.3rem; }
.freq-copy p{ margin:0; color: var(--ink-dim); max-width:38ch; }
.freq-form{ display:flex; gap:10px; flex-wrap:wrap; }
.freq-form input{ min-width:220px; }
.freq-form button{
  font-family:'IBM Plex Mono', monospace; font-size:.72rem; text-transform:uppercase; letter-spacing:.06em;
  background: var(--ink); color: var(--bg); border:none; border-radius:4px; padding:11px 20px; cursor:pointer;
  transition: background .3s;
}
.freq-form button:hover{ background: var(--teal); color:#0b1210; }
.freq-msg{ font-family:'IBM Plex Mono', monospace; font-size:.72rem; color: var(--teal); width:100%; min-height:1em; }

footer{ border-top:1px solid var(--line); padding:40px 0 70px; }
footer .wrap{ display:flex; justify-content:space-between; flex-wrap:wrap; gap:12px; }
.small{ font-family:'IBM Plex Mono', monospace; font-size:.68rem; color: var(--ink-dim); letter-spacing:.04em; }

@media (max-width:640px){
  .gb-row{ grid-template-columns:1fr; }
  .freq{ flex-direction:column; align-items:flex-start; }
}
@media (prefers-reduced-motion: reduce){
  *{ animation-duration:.01ms !important; transition-duration:.01ms !important; }
  html{ scroll-behavior:auto; }
}
#inkCanvas{ position:fixed; inset:0; pointer-events:none; z-index:2500; }
</style>
</head>
<body>

<div id="progress"></div>
<canvas id="inkCanvas"></canvas>

<header class="top">
  <div class="top-inner">
    <div class="brand"><span class="dot"></span> Aperture &amp; Static</div>
    <div class="top-right">
      <span class="rec"><span class="dot"></span> REC <span id="recClock">00:00:00</span></span>
      <button class="theme-btn" id="themeBtn" title="Toggle theme" aria-label="Toggle theme">◐</button>
    </div>
  </div>
</header>

<main class="wrap">

  <section class="hero" id="heroSection">
    <div class="hero-blob b1" id="blob1"></div>
    <div class="hero-blob b2" id="blob2"></div>

    <span class="eyebrow">Contact sheet no. 5 — <?= count($posts) ?> frames developed</span>

    <div class="signal">
      <span class="mono" style="font-size:.7rem;color:var(--ink-dim);">SIGNAL</span>
      <div class="signal-bar"><div class="signal-fill" id="signalFill" data-signal="<?= (int)$signal ?>"></div></div>
      <span class="mono" style="font-size:.7rem;color:var(--ink-dim);"><?= (int)$signal ?>%</span>
    </div>

    <h1><span class="glitch" data-text="Photographs, developed">Photographs, developed</span><br><span class="glitch" data-text="with the tape still running.">with the tape still running.</span></h1>
    <p class="lede">Frames from a contact sheet that never quite finished — film grain, city static, and the sound that was playing when the shutter went. Hover the noise. Something underneath moves.</p>
  </section>

  <div class="section-head" id="journal">
    <h2>Contact Sheet</h2>
    <div class="rule"></div>
    <span class="count mono"><?= (int)$totalViews ?> views logged</span>
  </div>

  <div class="controls">
    <div class="search-box">
      <span class="mono" style="color:var(--ink-dim);">⌕</span>
      <input type="text" id="searchInput" placeholder="Search frames…">
    </div>
    <button class="tag-chip active" data-tag="all">all</button>
    <?php foreach ($allTags as $t): ?>
      <button class="tag-chip" data-tag="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></button>
    <?php endforeach; ?>
  </div>

  <div class="sheet" id="sheet">
    <?php foreach ($posts as $p): ?>
    <article class="frame" data-slug="<?= htmlspecialchars($p['slug']) ?>" data-tags="<?= htmlspecialchars(implode(',', $p['tags'])) ?>" data-title="<?= htmlspecialchars(strtolower($p['title'])) ?>" data-excerpt="<?= htmlspecialchars(strtolower($p['excerpt'])) ?>">
      <div class="frame-no mono">No. <?= htmlspecialchars($p['frame']) ?> — <?= htmlspecialchars($p['date']) ?></div>
      <h3 class="frame-title"><?= htmlspecialchars($p['title']) ?></h3>
      <p class="frame-excerpt"><?= htmlspecialchars($p['excerpt']) ?></p>
      <div class="frame-meta">
        <span>♡ <?= (int)$likes[$p['slug']] ?></span>
        <span>◉ <?= (int)$views[$p['slug']] ?></span>
      </div>
      <div class="frame-tags"><?php foreach ($p['tags'] as $t): ?><span>#<?= htmlspecialchars($t) ?></span><?php endforeach; ?></div>
    </article>
    <?php endforeach; ?>
    <div class="no-results mono" id="noResults" style="display:none;">— no frames match that search —</div>
  </div>

  <section class="freq">
    <div class="freq-copy">
      <h3>Tune the frequency</h3>
      <p>New frames, once a week or so, whenever the light or the noise is worth developing.</p>
    </div>
    <form class="freq-form" id="freqForm">
      <input type="email" id="freqEmail" placeholder="you@somewhere.com" required>
      <button type="submit">Subscribe</button>
      <div class="freq-msg" id="freqMsg"></div>
    </form>
  </section>

  <section class="guestbook" id="guestbook">
    <div class="section-head">
      <h2>Transmissions</h2>
      <div class="rule"></div>
      <span class="count mono"><?= (int)$totalTransmissions ?> received</span>
    </div>
    <p style="color:var(--ink-dim); margin-top:-16px;">Leave a signal. It stays in the log for whoever tunes in next.</p>

    <form class="gb-form" id="gbForm">
      <div class="gb-row">
        <input type="text" id="gbName" placeholder="Call sign / name" maxlength="40">
        <input type="text" id="gbContext" placeholder="Optional — re: which frame?" maxlength="60">
      </div>
      <textarea id="gbMessage" placeholder="Send your transmission…" maxlength="500" required></textarea>
      <button type="submit" class="gb-submit">Transmit</button>
      <div class="gb-status" id="gbStatus"></div>
    </form>

    <div class="gb-list" id="gbList">
      <?php if (empty($transmissions)): ?>
        <div class="gb-empty">No transmissions received yet. Be the first signal.</div>
      <?php else: foreach ($transmissions as $c): ?>
        <div class="gb-item">
          <div class="gb-avatar" style="background: conic-gradient(from 0deg, hsl(<?= (int)$c['hue'] ?>,65%,55%), hsl(<?= ((int)$c['hue']+60)%360 ?>,65%,45%));"></div>
          <div>
            <span class="gb-who"><?= $c['name'] ?><span class="when"><?= $c['time'] ?></span></span>
            <p><?= nl2br($c['message']) ?></p>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </section>

</main>

<div class="lightbox" id="lightbox">
  <div class="lb-card">
    <button class="lb-close" id="lbClose">✕</button>
    <div class="lb-frame-no mono" id="lbFrameNo"></div>
    <h3 class="lb-title" id="lbTitle"></h3>
    <div class="lb-body" id="lbBody"></div>
    <div class="lb-foot">
      <button class="like-btn" id="lbLike"><span class="drop">♡</span><span class="like-count" id="lbLikeCount">0</span></button>
      <span class="view-count mono" id="lbViews">0 views</span>
      <span class="mono" style="color:var(--ink-dim);font-size:.7rem;" id="lbTags"></span>
    </div>
  </div>
</div>

<footer>
  <div class="wrap">
    <span class="small">APERTURE &amp; STATIC — contact sheet log, est. 2026</span>
    <span class="small"><?= (int)$totalLikes ?> marks left · <?= (int)$totalViews ?> views · <?= (int)$totalTransmissions ?> transmissions</span>
  </div>
</footer>

<script type="application/json" id="postsData"><?= json_encode($postsPublic, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?></script>

<script>
(function(){
  "use strict";
  var POSTS = JSON.parse(document.getElementById('postsData').textContent);
  var postBySlug = {}; POSTS.forEach(function(p){ postBySlug[p.slug] = p; });

  /* ---------- theme toggle ---------- */
  var root = document.documentElement;
  var themeBtn = document.getElementById('themeBtn');
  var saved = null;
  try { saved = localStorage.getItem('as-theme'); } catch(e){}
  if (saved) root.setAttribute('data-theme', saved);
  themeBtn.addEventListener('click', function(){
    var next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    root.setAttribute('data-theme', next);
    try { localStorage.setItem('as-theme', next); } catch(e){}
  });

  /* ---------- scroll progress ---------- */
  var progress = document.getElementById('progress');
  window.addEventListener('scroll', function(){
    var h = document.documentElement;
    var pct = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
    progress.style.width = (isFinite(pct) ? pct : 0) + '%';
  });

  /* ---------- REC clock (elapsed since load) ---------- */
  var startTime = Date.now();
  var recClock = document.getElementById('recClock');
  setInterval(function(){
    var s = Math.floor((Date.now() - startTime) / 1000);
    var hh = String(Math.floor(s/3600)).padStart(2,'0');
    var mm = String(Math.floor((s%3600)/60)).padStart(2,'0');
    var ss = String(s%60).padStart(2,'0');
    recClock.textContent = hh+':'+mm+':'+ss;
  }, 1000);

  /* ---------- signal meter fill ---------- */
  var fill = document.getElementById('signalFill');
  requestAnimationFrame(function(){
    fill.style.width = fill.getAttribute('data-signal') + '%';
  });

  /* ---------- hero parallax blobs ---------- */
  var hero = document.getElementById('heroSection');
  var b1 = document.getElementById('blob1'), b2 = document.getElementById('blob2');
  hero.addEventListener('mousemove', function(e){
    var r = hero.getBoundingClientRect();
    var x = (e.clientX - r.left) / r.width - 0.5;
    var y = (e.clientY - r.top) / r.height - 0.5;
    b1.style.transform = 'translate(' + (x*30) + 'px,' + (y*30) + 'px)';
    b2.style.transform = 'translate(' + (x*-24) + 'px,' + (y*-24) + 'px)';
  });

  /* ---------- reveal frames on scroll ---------- */
  var frames = document.querySelectorAll('.frame');
  var io = new IntersectionObserver(function(items){
    items.forEach(function(it, i){
      if (it.isIntersecting){
        setTimeout(function(){ it.target.classList.add('visible'); }, (i % 6) * 60);
        io.unobserve(it.target);
      }
    });
  }, { threshold:.12 });
  frames.forEach(function(f){ io.observe(f); });

  /* ---------- search + tag filter ---------- */
  var searchInput = document.getElementById('searchInput');
  var chips = document.querySelectorAll('.tag-chip');
  var noResults = document.getElementById('noResults');
  var activeTag = 'all';

  function applyFilter(){
    var q = searchInput.value.trim().toLowerCase();
    var visibleCount = 0;
    frames.forEach(function(f){
      var tags = f.getAttribute('data-tags').split(',');
      var matchesTag = activeTag === 'all' || tags.indexOf(activeTag) !== -1;
      var haystack = f.getAttribute('data-title') + ' ' + f.getAttribute('data-excerpt') + ' ' + tags.join(' ');
      var matchesSearch = !q || haystack.indexOf(q) !== -1;
      var show = matchesTag && matchesSearch;
      f.classList.toggle('hidden-by-filter', !show);
      if (show) visibleCount++;
    });
    noResults.style.display = visibleCount === 0 ? 'block' : 'none';
  }
  searchInput.addEventListener('input', applyFilter);
  chips.forEach(function(chip){
    chip.addEventListener('click', function(){
      chips.forEach(function(c){ c.classList.remove('active'); });
      chip.classList.add('active');
      activeTag = chip.getAttribute('data-tag');
      applyFilter();
    });
  });

  /* ---------- lightbox ---------- */
  var lightbox = document.getElementById('lightbox');
  var lbTitle = document.getElementById('lbTitle');
  var lbFrameNo = document.getElementById('lbFrameNo');
  var lbBody = document.getElementById('lbBody');
  var lbLike = document.getElementById('lbLike');
  var lbLikeCount = document.getElementById('lbLikeCount');
  var lbViews = document.getElementById('lbViews');
  var lbTags = document.getElementById('lbTags');
  var currentSlug = null;

  function openLightbox(slug){
    var p = postBySlug[slug];
    if (!p) return;
    currentSlug = slug;
    lbFrameNo.textContent = 'No. ' + p.frame + ' — ' + p.date;
    lbTitle.textContent = p.title;
    lbBody.innerHTML = '<p>' + p.body.replace(/\n/g,'<br>') + '</p>';
    lbLikeCount.textContent = p.likes;
    lbLike.classList.remove('liked');
    lbViews.textContent = p.views + ' views';
    lbTags.textContent = p.tags.map(function(t){ return '#'+t; }).join('  ');
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';

    var body = new URLSearchParams({ action:'view', slug: slug });
    fetch(window.location.pathname, { method:'POST', body: body })
      .then(function(r){ return r.json(); })
      .then(function(data){ if (data.ok){ lbViews.textContent = data.count + ' views'; p.views = data.count; } })
      .catch(function(){});
  }
  function closeLightbox(){
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  }
  frames.forEach(function(f){
    f.addEventListener('click', function(){ openLightbox(f.getAttribute('data-slug')); });
  });
  document.getElementById('lbClose').addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', function(e){ if (e.target === lightbox) closeLightbox(); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeLightbox(); });

  lbLike.addEventListener('click', function(){
    if (lbLike.classList.contains('liked') || !currentSlug) return;
    var body = new URLSearchParams({ action:'like', slug: currentSlug });
    fetch(window.location.pathname, { method:'POST', body: body })
      .then(function(r){ return r.json(); })
      .then(function(data){
        if (data.ok){
          lbLikeCount.textContent = data.count;
          lbLike.classList.add('liked','pulse');
          setTimeout(function(){ lbLike.classList.remove('pulse'); }, 500);
        }
      })
      .catch(function(){});
  });

  /* ---------- transmissions (guestbook) form ---------- */
  var gbForm = document.getElementById('gbForm');
  var gbStatus = document.getElementById('gbStatus');
  var gbList = document.getElementById('gbList');
  gbForm.addEventListener('submit', function(e){
    e.preventDefault();
    var name = document.getElementById('gbName').value.trim();
    var context = document.getElementById('gbContext').value.trim();
    var message = document.getElementById('gbMessage').value.trim();
    if (!message){ gbStatus.textContent = 'Nothing to transmit yet.'; return; }
    var full = context ? ('[' + context + '] ' + message) : message;
    var body = new URLSearchParams({ action:'transmit', name:name, message: full });
    gbStatus.textContent = 'Sending…';
    fetch(window.location.pathname, { method:'POST', body: body })
      .then(function(r){ return r.json(); })
      .then(function(data){
        if (data.ok){
          gbStatus.textContent = 'Received.';
          var empty = gbList.querySelector('.gb-empty');
          if (empty) empty.remove();
          var item = document.createElement('div');
          item.className = 'gb-item';
          item.innerHTML = '<div class="gb-avatar" style="background: conic-gradient(from 0deg, hsl(' + data.entry.hue + ',65%,55%), hsl(' + ((data.entry.hue+60)%360) + ',65%,45%));"></div>' +
            '<div><span class="gb-who">' + data.entry.name + '<span class="when">' + data.entry.time + '</span></span><p>' + data.entry.message.replace(/\n/g,'<br>') + '</p></div>';
          gbList.insertBefore(item, gbList.firstChild);
          gbForm.reset();
          setTimeout(function(){ gbStatus.textContent=''; }, 2500);
        } else {
          gbStatus.textContent = "Couldn't send — try again.";
        }
      })
      .catch(function(){ gbStatus.textContent = 'Server unreachable — run with `php -S localhost:8000`.'; });
  });

  /* ---------- frequency / subscribe form ---------- */
  var freqForm = document.getElementById('freqForm');
  var freqMsg = document.getElementById('freqMsg');
  freqForm.addEventListener('submit', function(e){
    e.preventDefault();
    var email = document.getElementById('freqEmail').value.trim();
    var body = new URLSearchParams({ action:'subscribe', email: email });
    freqMsg.textContent = 'Tuning in…';
    fetch(window.location.pathname, { method:'POST', body: body })
      .then(function(r){ return r.json(); })
      .then(function(data){
        if (data.ok){ freqMsg.textContent = "You're on frequency."; freqForm.reset(); }
        else { freqMsg.textContent = data.error === 'invalid email' ? 'That doesn\'t look like an email.' : 'Something went wrong.'; }
      })
      .catch(function(){ freqMsg.textContent = 'Server unreachable — run with `php -S localhost:8000`.'; });
  });

  /* ---------- ambient ink / static cursor trail (fine pointer only) ---------- */
  var canvas = document.getElementById('inkCanvas');
  var isFine = window.matchMedia('(pointer: fine)').matches;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (isFine && !reduced){
    var ctx = canvas.getContext('2d');
    var W, H, drops = [];
    function resize(){ W = canvas.width = innerWidth; H = canvas.height = innerHeight; }
    resize(); addEventListener('resize', resize);
    addEventListener('mousemove', function(e){
      if (Math.random() > 0.5) return;
      drops.push({ x:e.clientX, y:e.clientY, r: 1 + Math.random()*1.6, life:1 });
    });
    function tick(){
      ctx.clearRect(0,0,W,H);
      for (var i = drops.length-1; i >= 0; i--){
        var d = drops[i]; d.life -= 0.02; d.r += 0.18;
        if (d.life <= 0){ drops.splice(i,1); continue; }
        ctx.beginPath(); ctx.arc(d.x,d.y,d.r,0,Math.PI*2);
        ctx.fillStyle = 'rgba(232,163,61,' + (d.life*0.18) + ')';
        ctx.fill();
      }
      requestAnimationFrame(tick);
    }
    tick();
  }

})();
</script>

</body>
</html>