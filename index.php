<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Range Markets — Secure Crypto Deposit</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
  --bg:#03060f;
  --bg2:#070d1c;
  --card:rgba(12,20,40,0.92);
  --border:rgba(0,212,255,.12);
  --border2:rgba(0,212,255,.25);
  --cyan:#00d4ff;
  --purple:#7c3aed;
  --gold:#e8b84b;
  --text:#f0f6ff;
  --muted:#64748b;
  --muted2:#94a3b8;
  --green:#10b981;
  --red:#ef4444;
}
html{scroll-behavior:smooth}
body{
  font-family:'DM Sans',sans-serif;
  background:var(--bg);
  color:var(--text);
  min-height:100vh;
  overflow-x:hidden;
}

/* ANIMATED BG */
body::before{
  content:'';position:fixed;inset:0;
  background:
    radial-gradient(ellipse at 15% 50%,rgba(0,212,255,.06) 0%,transparent 55%),
    radial-gradient(ellipse at 85% 20%,rgba(124,58,237,.07) 0%,transparent 55%),
    radial-gradient(ellipse at 50% 90%,rgba(232,184,75,.04) 0%,transparent 50%);
  pointer-events:none;z-index:0;
}

/* GRID PATTERN */
body::after{
  content:'';position:fixed;inset:0;
  background-image:
    linear-gradient(rgba(0,212,255,.025) 1px,transparent 1px),
    linear-gradient(90deg,rgba(0,212,255,.025) 1px,transparent 1px);
  background-size:60px 60px;
  pointer-events:none;z-index:0;
}

/* ══ HEADER ══════════════════════════════════════════════════════ */
.header{
  position:relative;z-index:10;
  padding:0 40px;
  background:rgba(3,6,15,.9);
  backdrop-filter:blur(30px);
  border-bottom:1px solid var(--border);
}
.header-inner{
  max-width:1100px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 0;
}

/* LOGO */
.logo{display:flex;align-items:center;gap:12px;text-decoration:none}
.logo-mark{
  width:42px;height:42px;border-radius:10px;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  display:flex;align-items:center;justify-content:center;
  font-family:'Cormorant Garamond',serif;
  font-size:1.4rem;font-weight:700;color:#fff;
  box-shadow:0 4px 16px rgba(0,212,255,.3);
  flex-shrink:0;
}
.logo-text{
  display:flex;flex-direction:column;line-height:1;
}
.logo-name{
  font-family:'Cormorant Garamond',serif;
  font-size:1.35rem;font-weight:700;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;letter-spacing:.02em;
}
.logo-sub{
  font-size:.6rem;font-weight:600;letter-spacing:.22em;
  text-transform:uppercase;color:var(--muted2);margin-top:2px;
}

.header-right{display:flex;align-items:center;gap:18px}
.secure-badge{
  display:flex;align-items:center;gap:6px;
  font-size:.72rem;font-weight:600;letter-spacing:.06em;
  color:var(--green);
  background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);
  padding:6px 14px;border-radius:100px;
}
.secure-dot{width:6px;height:6px;border-radius:50%;background:var(--green);
  animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:.4}50%{opacity:1}}

/* ══ HERO STRIP ══════════════════════════════════════════════════ */
.hero-strip{
  position:relative;z-index:5;
  text-align:center;
  padding:52px 24px 40px;
  border-bottom:1px solid var(--border);
}
.hero-eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  background:rgba(0,212,255,.07);border:1px solid rgba(0,212,255,.18);
  color:var(--cyan);font-size:.68rem;font-weight:700;
  letter-spacing:.18em;text-transform:uppercase;
  padding:5px 16px;border-radius:100px;margin-bottom:16px;
}
.hero-strip h1{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(2rem,5vw,3.2rem);font-weight:700;
  letter-spacing:-.02em;line-height:1.1;
  margin-bottom:12px;
}
.hero-strip h1 em{font-style:italic;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero-strip p{
  font-size:.92rem;color:var(--muted2);
  max-width:480px;margin:0 auto;line-height:1.7;
}

/* ══ TRUST BADGES ════════════════════════════════════════════════ */
.trust-row{
  position:relative;z-index:5;
  display:flex;justify-content:center;gap:14px;
  padding:28px 24px;
  border-bottom:1px solid var(--border);
  flex-wrap:wrap;
}
.tbadge{
  display:flex;align-items:center;gap:9px;
  background:var(--card);
  border:1px solid var(--border);
  border-radius:12px;padding:12px 18px;
  font-size:.78rem;font-weight:600;color:var(--muted2);
  transition:border-color .25s,transform .25s;
  backdrop-filter:blur(20px);
}
.tbadge:hover{border-color:var(--border2);transform:translateY(-2px)}
.tbadge i{color:var(--cyan);font-size:1rem}

/* ══ MAIN LAYOUT ═════════════════════════════════════════════════ */
.main{
  position:relative;z-index:5;
  max-width:560px;margin:0 auto;
  padding:44px 24px 60px;
}

/* ══ CARD ════════════════════════════════════════════════════════ */
.card{
  background:var(--card);
  border:1px solid var(--border2);
  border-radius:24px;
  padding:36px 32px;
  box-shadow:0 32px 64px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.04);
  backdrop-filter:blur(30px);
  animation:cardIn .6s cubic-bezier(.34,1.56,.64,1);
}
@keyframes cardIn{from{opacity:0;transform:translateY(30px) scale(.97)}to{opacity:1;transform:none}}

.card-title{
  display:flex;align-items:center;gap:10px;
  font-family:'Cormorant Garamond',serif;
  font-size:1.5rem;font-weight:700;
  margin-bottom:28px;
}
.card-title i{
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

/* FORM */
.form-group{margin-bottom:20px;position:relative}
.form-group label{
  display:block;font-size:.72rem;font-weight:700;
  letter-spacing:.1em;text-transform:uppercase;color:var(--muted2);
  margin-bottom:8px;
}
.input-wrap{position:relative}
.input-icon{
  position:absolute;left:14px;top:50%;transform:translateY(-50%);
  color:var(--muted);font-size:.9rem;pointer-events:none;z-index:2;
  transition:color .2s;
}
.form-group select,.form-group input{
  width:100%;padding:13px 14px 13px 42px;
  background:rgba(255,255,255,.04);
  border:1.5px solid rgba(255,255,255,.08);
  border-radius:12px;color:var(--text);
  font-size:.92rem;font-family:'DM Sans',sans-serif;
  outline:none;transition:border-color .2s,box-shadow .2s,background .2s;
  appearance:none;
}
.form-group select option{background:#0d1220;color:#f0f6ff}
.form-group select:focus,.form-group input:focus{
  border-color:var(--cyan);
  box-shadow:0 0 0 3px rgba(0,212,255,.12);
  background:rgba(0,212,255,.04);
}
.form-group select:focus~.input-icon,
.form-group input:focus~.input-icon{color:var(--cyan)}
.form-group input::placeholder{color:var(--muted)}

/* QR SECTION */
.qr-box{
  text-align:center;
  padding:28px 20px;
  background:rgba(0,212,255,.04);
  border:1.5px dashed rgba(0,212,255,.25);
  border-radius:16px;
  margin:20px 0;
  animation:fadeIn .4s ease;
}
@keyframes fadeIn{from{opacity:0;transform:scale(.97)}to{opacity:1;transform:scale(1)}}
#qr-image{
  width:210px;height:210px;
  border-radius:14px;
  box-shadow:0 8px 32px rgba(0,0,0,.4),0 0 0 4px rgba(0,212,255,.1);
  margin-bottom:14px;
}
.qr-label{font-size:.8rem;color:var(--muted2);margin-bottom:10px;font-weight:500}
#qr-address{
  font-family:'Courier New',monospace;font-size:.75rem;
  color:var(--cyan);word-break:break-all;
  background:rgba(0,212,255,.07);
  border:1px solid rgba(0,212,255,.15);
  border-left:3px solid var(--cyan);
  border-radius:8px;padding:10px 14px;
  display:flex;align-items:center;gap:8px;justify-content:space-between;
  text-align:left;
}
.copy-btn{
  background:none;border:none;color:var(--cyan);
  cursor:pointer;font-size:.82rem;padding:4px 8px;
  border-radius:6px;white-space:nowrap;
  transition:background .2s;flex-shrink:0;
  font-family:'DM Sans',sans-serif;font-weight:600;
}
.copy-btn:hover{background:rgba(0,212,255,.12)}

/* STATUS */
.status-bar{
  display:flex;align-items:center;gap:9px;
  padding:11px 16px;border-radius:10px;
  font-size:.82rem;font-weight:600;margin:14px 0;
  animation:fadeIn .3s ease;
}
.status-bar.info{background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2);color:#c4b5fd}
.status-bar.success{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);color:#6ee7b7}
.status-bar.warning{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.2);color:#fcd34d}
.status-bar.error{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#fca5a5}

/* SUBMIT BUTTON */
.submit-btn{
  width:100%;padding:15px;margin-top:8px;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  color:#fff;font-weight:700;font-size:.95rem;
  font-family:'DM Sans',sans-serif;letter-spacing:.04em;
  border:none;border-radius:12px;cursor:pointer;
  display:flex;align-items:center;justify-content:center;gap:9px;
  transition:transform .2s,box-shadow .2s,opacity .2s;
  box-shadow:0 8px 24px rgba(0,212,255,.2);
  position:relative;overflow:hidden;
}
.submit-btn::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,.15),transparent);
  opacity:0;transition:opacity .2s;
}
.submit-btn:hover:not(:disabled){
  transform:translateY(-2px);
  box-shadow:0 16px 36px rgba(0,212,255,.4);
}
.submit-btn:hover:not(:disabled)::after{opacity:1}
.submit-btn:active:not(:disabled){transform:scale(.98)}
.submit-btn:disabled{opacity:.45;cursor:not-allowed;transform:none}
.submit-btn .spinner{
  width:18px;height:18px;border-radius:50%;
  border:2px solid rgba(255,255,255,.3);
  border-top-color:#fff;
  animation:spin .7s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg)}}
/* Pulse animation when enabled */
@keyframes btnPulse{
  0%,100%{box-shadow:0 8px 24px rgba(0,212,255,.2)}
  50%{box-shadow:0 8px 32px rgba(0,212,255,.45),0 0 0 4px rgba(0,212,255,.1)}
}
.submit-btn:not(:disabled){animation:btnPulse 3s ease-in-out infinite}

/* ══ TRUST SECTION ═══════════════════════════════════════════════ */
.trust-section{
  position:relative;z-index:5;
  border-top:1px solid var(--border);
  padding:56px 24px;
  text-align:center;
}
.trust-section-inner{max-width:900px;margin:0 auto}
.trust-tagline{
  font-size:.72rem;font-weight:700;letter-spacing:.18em;
  text-transform:uppercase;color:var(--cyan);margin-bottom:12px;
}
.trust-heading{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;
  line-height:1.15;margin-bottom:14px;
}
.trust-heading em{font-style:italic;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.trust-sub{
  font-size:.92rem;color:var(--muted2);
  max-width:520px;margin:0 auto 44px;line-height:1.75;
}
.trust-grid{
  display:grid;grid-template-columns:repeat(3,1fr);gap:20px;
  margin-bottom:40px;
}
.trust-card{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:16px;padding:28px 22px;
  text-align:left;
  transition:border-color .25s,transform .25s;
  backdrop-filter:blur(20px);
}
.trust-card:hover{border-color:var(--border2);transform:translateY(-3px)}
.trust-card-icon{
  width:44px;height:44px;border-radius:11px;
  background:linear-gradient(135deg,rgba(0,212,255,.15),rgba(124,58,237,.15));
  border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;margin-bottom:14px;
  color:var(--cyan);
}
.trust-card h4{
  font-family:'Cormorant Garamond',serif;
  font-size:1.05rem;font-weight:700;margin-bottom:7px;
}
.trust-card p{font-size:.8rem;color:var(--muted2);line-height:1.65}

.trust-quote{
  font-family:'Cormorant Garamond',serif;
  font-size:1.3rem;font-style:italic;
  color:var(--muted2);
  border-top:1px solid var(--border);
  padding-top:32px;max-width:600px;margin:0 auto;
  line-height:1.6;
}
.trust-quote span{color:var(--text)}

/* ══ FOOTER ══════════════════════════════════════════════════════ */
footer{
  position:relative;z-index:5;
  border-top:1px solid var(--border);
  padding:24px 40px;
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:12px;
}
.footer-left{display:flex;align-items:center;gap:10px}
.footer-logo-name{
  font-family:'Cormorant Garamond',serif;
  font-size:1rem;font-weight:700;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.footer-copy{font-size:.72rem;color:var(--muted)}
.footer-right{font-size:.72rem;color:var(--muted);display:flex;gap:16px}
.footer-right a{color:var(--muted);text-decoration:none;transition:color .2s}
.footer-right a:hover{color:var(--cyan)}

/* ══ SUCCESS POPUP ═══════════════════════════════════════════════ */
.popup-overlay{
  position:fixed;inset:0;z-index:1000;
  background:rgba(0,0,0,.75);backdrop-filter:blur(8px);
  display:flex;align-items:center;justify-content:center;
  padding:24px;
  opacity:0;pointer-events:none;
  transition:opacity .3s;
}
.popup-overlay.show{opacity:1;pointer-events:all}
.popup-box{
  background:rgba(10,18,35,.97);
  border:1px solid rgba(16,185,129,.3);
  border-radius:24px;padding:44px 36px;
  text-align:center;max-width:420px;width:100%;
  box-shadow:0 40px 80px rgba(0,0,0,.6),0 0 0 1px rgba(255,255,255,.04);
  transform:scale(.9) translateY(20px);
  transition:transform .4s cubic-bezier(.34,1.56,.64,1);
}
.popup-overlay.show .popup-box{transform:scale(1) translateY(0)}

.popup-icon{
  width:72px;height:72px;border-radius:50%;
  background:linear-gradient(135deg,rgba(16,185,129,.2),rgba(0,212,255,.2));
  border:2px solid rgba(16,185,129,.4);
  display:flex;align-items:center;justify-content:center;
  font-size:2rem;margin:0 auto 20px;
  animation:popIn .5s cubic-bezier(.34,1.56,.64,1) .2s both;
}
@keyframes popIn{from{transform:scale(0) rotate(-180deg)}to{transform:scale(1) rotate(0)}}
.popup-title{
  font-family:'Cormorant Garamond',serif;
  font-size:1.7rem;font-weight:700;margin-bottom:10px;color:var(--text);
}
.popup-sub{font-size:.88rem;color:var(--muted2);line-height:1.65;margin-bottom:8px}
.popup-detail{
  background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.15);
  border-radius:10px;padding:12px 16px;margin:16px 0;
  font-size:.8rem;color:#6ee7b7;
}
.popup-time{font-size:.75rem;color:var(--muted);margin-bottom:24px}
.popup-close{
  width:100%;padding:13px;
  background:linear-gradient(135deg,var(--cyan),var(--purple));
  color:#fff;font-weight:700;font-size:.88rem;
  border:none;border-radius:10px;cursor:pointer;
  font-family:'DM Sans',sans-serif;letter-spacing:.04em;
  transition:transform .2s,box-shadow .2s;
}
.popup-close:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(0,212,255,.3)}

.hidden{display:none!important}

@media(max-width:680px){
  .header-inner{padding:14px 0}
  .hero-strip{padding:36px 16px 28px}
  .trust-grid{grid-template-columns:1fr}
  .main{padding:28px 16px 50px}
  .card{padding:26px 20px}
  footer{padding:18px 20px;flex-direction:column;text-align:center}
  .trust-row{gap:10px}
}
</style>
</head>
<body>

<!-- ══ HEADER ══════════════════════════════════════════════════════ -->
<header class="header">
  <div class="header-inner">
    <a href="#" class="logo">
      <img src="data:image/jpeg;base64,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" alt="Range Markets" style="height:44px;width:auto;display:block;filter:drop-shadow(0 2px 8px rgba(232,184,75,.25))">
    </a>
    <div class="header-right">
      <div class="secure-badge">
        <span class="secure-dot"></span>
        256-bit SSL Secured
      </div>
    </div>
  </div>
</header>

<!-- ══ HERO ════════════════════════════════════════════════════════ -->
<div class="hero-strip">
  <div class="hero-eyebrow">
    <i class="fas fa-shield-alt"></i>
    Instant Crypto Deposit Portal
  </div>
  <h1>Your Trust Is Our<br><em>Hardwork</em></h1>
  <p>Fast, secure, and transparent crypto deposits — processed in minutes, not hours. Every transaction monitored and verified by our dedicated operations team.</p>
</div>

<!-- ══ TRUST BADGES ═════════════════════════════════════════════════ -->
<div class="trust-row">
  <div class="tbadge"><i class="fas fa-shield-alt"></i> Regulated Broker</div>
  <div class="tbadge"><i class="fas fa-lock"></i> End-to-End Encrypted</div>
  <div class="tbadge"><i class="fas fa-bolt"></i> 3–5 Min Approval</div>
  <div class="tbadge"><i class="fas fa-headset"></i> 24/7 Support</div>
  <div class="tbadge"><i class="fas fa-check-double"></i> Verified Wallets</div>
</div>

<!-- ══ DEPOSIT FORM ══════════════════════════════════════════════════ -->
<div class="main">
  <div class="card">
    <div class="card-title">
      <i class="fas fa-coins"></i>
      Crypto Deposit
    </div>

    <!-- Network -->
    <div class="form-group">
      <label><i class="fas fa-network-wired" style="margin-right:6px;color:var(--cyan)"></i>Select Network</label>
      <div class="input-wrap">
        <i class="fas fa-chevron-down input-icon" style="right:14px;left:auto"></i>
        <select id="payment-method" onchange="generateQR()">
          <option value="">Choose deposit network...</option>
          <option value="TRC20">🟢 TRC20 — TRON Network (USDT)</option>
          <option value="ERC20">🔵 ERC20 — Ethereum Network (USDT)</option>
        </select>
      </div>
    </div>

    <!-- QR Section -->
    <div id="qr-section" class="qr-box hidden">
      <img id="qr-image" src="" alt="Deposit QR Code">
      <div class="qr-label">Scan QR Code · Send exact USDT amount</div>
      <div id="qr-address">
        <span id="addr-text"></span>
        <button class="copy-btn" onclick="copyAddress()">
          <i class="fas fa-copy"></i> Copy
        </button>
      </div>
    </div>

    <!-- Name -->
    <div class="form-group">
      <label><i class="fas fa-user" style="margin-right:6px;color:var(--cyan)"></i>Full Name</label>
      <div class="input-wrap">
        <i class="fas fa-user input-icon"></i>
        <input type="text" id="name" placeholder="Enter your registered full name">
      </div>
    </div>

    <!-- Email -->
    <div class="form-group">
      <label><i class="fas fa-envelope" style="margin-right:6px;color:var(--cyan)"></i>Email Address</label>
      <div class="input-wrap">
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" id="email" placeholder="Enter your email address">
      </div>
    </div>

    <!-- TX Hash -->
    <div class="form-group">
      <label><i class="fas fa-hashtag" style="margin-right:6px;color:var(--cyan)"></i>Transaction Hash</label>
      <div class="input-wrap">
        <i class="fas fa-hashtag input-icon"></i>
        <input type="text" id="transaction-hash" placeholder="Paste your transaction hash here">
      </div>
    </div>

    <!-- Status bar -->
    <div id="status" class="status-bar info hidden">
      <i class="fas fa-info-circle"></i>
      <span id="status-text">Select a network to generate your deposit address</span>
    </div>

    <!-- Submit -->
    <button class="submit-btn" id="submit-btn" onclick="submitDeposit()" disabled>
      <i class="fas fa-paper-plane"></i>
      Submit Deposit
    </button>
  </div>
</div>

<!-- ══ TRUST SECTION ════════════════════════════════════════════════ -->
<section class="trust-section">
  <div class="trust-section-inner">
    <div class="trust-tagline">Why Range Markets</div>
    <h2 class="trust-heading">Your Trust Is Our<br><em>Greatest Responsibility</em></h2>
    <p class="trust-sub">We've built Range Markets on a foundation of transparency, speed, and unwavering commitment to protecting every client's capital and confidence.</p>
    <div class="trust-grid">
      <div class="trust-card">
        <div class="trust-card-icon"><i class="fas fa-shield-alt"></i></div>
        <h4>Military-Grade Security</h4>
        <p>All deposits are protected with 256-bit SSL encryption and multi-layer wallet verification before any approval.</p>
      </div>
      <div class="trust-card">
        <div class="trust-card-icon"><i class="fas fa-bolt"></i></div>
        <h4>Lightning Fast Approvals</h4>
        <p>Our dedicated operations team processes and approves verified crypto deposits within 3–5 minutes, round the clock.</p>
      </div>
      <div class="trust-card">
        <div class="trust-card-icon"><i class="fas fa-eye"></i></div>
        <h4>Full Transparency</h4>
        <p>Every transaction is logged, timestamped, and confirmation sent to you. No hidden fees. No delays. No surprises.</p>
      </div>
      <div class="trust-card">
        <div class="trust-card-icon"><i class="fas fa-headset"></i></div>
        <h4>24 / 7 Operations</h4>
        <p>Our support and operations team is always available — deposits accepted and monitored 24 hours, 7 days a week.</p>
      </div>
      <div class="trust-card">
        <div class="trust-card-icon"><i class="fas fa-wallet"></i></div>
        <h4>Verified Wallets Only</h4>
        <p>All wallet addresses are regularly audited. TRC20 and ERC20 addresses are verified and rotated for maximum safety.</p>
      </div>
      <div class="trust-card">
        <div class="trust-card-icon"><i class="fas fa-chart-line"></i></div>
        <h4>Regulated Operations</h4>
        <p>Range Markets operates under strict compliance protocols ensuring every client's funds are handled with full accountability.</p>
      </div>
    </div>
    <div class="trust-quote">
      "<span>We don't just process deposits — we protect dreams.</span><br>Every transaction you make is backed by our promise of security, speed, and trust."
    </div>
  </div>
</section>

<!-- ══ FOOTER ════════════════════════════════════════════════════════ -->
<footer>
  <div class="footer-left">
    <img src="data:image/jpeg;base64,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" alt="Range Markets" style="height:28px;width:auto;display:block;opacity:.8">
  </div>
  <div class="footer-copy">© 2026 Range Markets · Deposits processed 24/7 · Avg approval: 3–5 min</div>
  <div class="footer-right">
    <a href="#">Privacy Policy</a>
    <a href="#">Terms</a>
    <a href="/cdn-cgi/l/email-protection#2b445b4e594a5f424445586b594a454c4e4d44594e5305484446">Support</a>
  </div>
</footer>

<!-- ══ SUCCESS POPUP ═════════════════════════════════════════════════ -->
<div class="popup-overlay" id="popupOverlay">
  <div class="popup-box">
    <div class="popup-icon">✅</div>
    <div class="popup-title">Payment Submitted!</div>
    <p class="popup-sub">Your deposit has been successfully submitted to Range Markets operations team.</p>
    <div class="popup-detail">
      <i class="fas fa-envelope" style="margin-right:6px"></i>
      Confirmation sent to <strong><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="264956435447524f494855665447484143404954435e0845494b">[email&#160;protected]</a></strong><br>
      Your deposit will be approved within <strong>3–5 minutes</strong>.
    </div>
    <div class="popup-time" id="popup-timestamp"></div>
    <button class="popup-close" onclick="closePopup()">
      <i class="fas fa-check" style="margin-right:8px"></i>Done — Back to Portal
    </button>
  </div>
</div>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
// ── WALLET ADDRESSES ─────────────────────────────────────────────
const wallets = {
  TRC20: "TYourTRC20AddressHere123456789",   // ← Replace with real TRC20
  ERC20: "0x742d35Cc6634C0532925a3b8D982d8bE9e7E5D5a"  // ← Replace with real ERC20
};

let currentAddress = "";

// ── GENERATE QR ──────────────────────────────────────────────────
function generateQR() {
  const method  = document.getElementById('payment-method').value;
  const qrSec   = document.getElementById('qr-section');
  const qrImg   = document.getElementById('qr-image');
  const addrEl  = document.getElementById('addr-text');
  const submitBtn = document.getElementById('submit-btn');
  const status  = document.getElementById('status');
  const statusTxt = document.getElementById('status-text');

  if (!method) {
    qrSec.classList.add('hidden');
    submitBtn.disabled = true;
    setStatus('info','fas fa-info-circle','Select a network to generate your deposit address');
    return;
  }

  currentAddress = wallets[method];
  const color = method === 'TRC20' ? '00d4ff' : '7c3aed';
  qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=${encodeURIComponent(currentAddress)}&colorDark=${color}&colorLight=0a1223&format=png`;
  addrEl.textContent = `${method}: ${currentAddress}`;
  qrSec.classList.remove('hidden');
  submitBtn.disabled = false;
  setStatus('success','fas fa-check-circle','Deposit address ready — scan QR code and send your USDT');
}

// ── COPY ADDRESS ─────────────────────────────────────────────────
function copyAddress() {
  if (!currentAddress) return;
  navigator.clipboard?.writeText(currentAddress).then(() => {
    const btn = document.querySelector('.copy-btn');
    btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
    btn.style.color = 'var(--green)';
    setTimeout(() => {
      btn.innerHTML = '<i class="fas fa-copy"></i> Copy';
      btn.style.color = '';
    }, 2000);
  });
}

// ── STATUS HELPER ────────────────────────────────────────────────
function setStatus(type, icon, msg) {
  const s = document.getElementById('status');
  const t = document.getElementById('status-text');
  s.className = `status-bar ${type}`;
  s.classList.remove('hidden');
  s.querySelector('i')?.remove();
  const ico = document.createElement('i');
  ico.className = icon;
  s.insertBefore(ico, t);
  t.textContent = msg;
}

// ── SUBMIT DEPOSIT ────────────────────────────────────────────────
function submitDeposit() {
  const name   = document.getElementById('name').value.trim();
  const email  = document.getElementById('email').value.trim();
  const txHash = document.getElementById('transaction-hash').value.trim();
  const method = document.getElementById('payment-method').value;
  const btn    = document.getElementById('submit-btn');

  if (!name || !email || !txHash || !method) {
    setStatus('warning','fas fa-exclamation-triangle','Please complete all fields before submitting');
    return;
  }

  // Simple email validation
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    setStatus('warning','fas fa-exclamation-triangle','Please enter a valid email address');
    return;
  }

  // Loading state
  btn.disabled = true;
  btn.innerHTML = '<div class="spinner"></div> Submitting...';
  setStatus('info','fas fa-circle-notch fa-spin','Sending to operations team...');

  fetch('/.netlify/functions/submit', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name,
      email,
      transaction_hash: txHash,
      method,
      timestamp: new Date().toISOString()
    })
  })
  .then(r => r.json())
  .then(data => {
    if (data.status === 'success') {
      showSuccessPopup(name, method);
      // Reset
      document.getElementById('name').value = '';
      document.getElementById('email').value = '';
      document.getElementById('transaction-hash').value = '';
      document.getElementById('payment-method').value = '';
      document.getElementById('qr-section').classList.add('hidden');
      setStatus('info','fas fa-info-circle','Select a network to generate your deposit address');
      btn.disabled = true;
    } else {
      setStatus('error','fas fa-exclamation-circle', data.error || 'Submission failed. Please try again.');
    }
  })
  .catch(() => {
    setStatus('error','fas fa-wifi','Network error — please check connection and retry');
  })
  .finally(() => {
    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Deposit';
    btn.disabled = false;
  });
}

// ── SUCCESS POPUP ─────────────────────────────────────────────────
function showSuccessPopup(name, method) {
  const now = new Date();
  const timeStr = now.toLocaleString('en-IN', {
    day:'2-digit',month:'short',year:'numeric',
    hour:'2-digit',minute:'2-digit',hour12:true
  });
  document.getElementById('popup-timestamp').textContent =
    `Submitted at ${timeStr} · Ref: RMK${Date.now().toString().slice(-6)}`;
  document.getElementById('popupOverlay').classList.add('sho
