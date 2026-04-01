<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>dTech Hosting — Premium Cloud Hosting for Bangladesh</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    /* ─────────────────── RESET & ROOT ─────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 100%; }

    :root {
      --primary: #3FD1C0;
      --primary-dark: #14b8a6;
      --primary-darker: #0d9488;
      --primary-glow: rgba(63,209,192,0.4);
      --bg-light: #f0fdf9;
      --bg-dark: #020b0a;

      /* Nav height */
      --nav-h: clamp(52px, 5vw, 64px);
    }

    body {
      font-family: 'Manrope', sans-serif;
      background: var(--bg-light);
      color: #1a1a2e;
      overflow-x: hidden;
      transition: background 0.3s ease, color 0.3s ease;
    }

    /* ─────────────────── DARK MODE ─────────────────── */
    html.dark body { background: var(--bg-dark); color: #e2e8f0; }

    /* ─────────────────── MESH BG ─────────────────── */
    .mesh-bg-light {
      background:
        radial-gradient(at 40% 20%, rgba(63,209,192,0.15) 0px, transparent 50%),
        radial-gradient(at 80% 0%,  rgba(20,184,166,0.10) 0px, transparent 50%),
        radial-gradient(at 0%  50%, rgba(63,209,192,0.08) 0px, transparent 50%),
        radial-gradient(at 80% 50%, rgba(16,185,129,0.08) 0px, transparent 50%),
        radial-gradient(at 0% 100%, rgba(63,209,192,0.10) 0px, transparent 50%),
        #f0fdf9;
    }
    html.dark .mesh-bg-light {
      background:
        radial-gradient(at 40% 20%, rgba(63,209,192,0.12) 0px, transparent 50%),
        radial-gradient(at 80% 0%,  rgba(20,184,166,0.08) 0px, transparent 50%),
        radial-gradient(at 0%  50%, rgba(63,209,192,0.06) 0px, transparent 50%),
        radial-gradient(at 80% 50%, rgba(16,185,129,0.06) 0px, transparent 50%),
        #020b0a;
    }

    /* ─────────────────── GLASS ─────────────────── */
    .glass {
      background: rgba(255,255,255,0.10);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.20);
    }
    html.dark .glass {
      background: rgba(0,0,0,0.20);
      border: 1px solid rgba(255,255,255,0.08);
    }
    .glass-card {
      background: rgba(255,255,255,0.60);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.80);
      box-shadow: 0 8px 32px rgba(63,209,192,0.08), 0 2px 8px rgba(0,0,0,0.04);
    }
    html.dark .glass-card {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: 0 8px 32px rgba(0,0,0,0.40), inset 0 1px 0 rgba(255,255,255,0.05);
    }

    /* ─────────────────── UTILITIES ─────────────────── */
    .text-gradient {
      background: linear-gradient(135deg, #3FD1C0, #14b8a6, #0d9488);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .border-glow {
      border: 1px solid rgba(63,209,192,0.30);
      box-shadow: 0 0 15px rgba(63,209,192,0.10), inset 0 0 15px rgba(63,209,192,0.05);
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    .border-glow:hover {
      border-color: rgba(63,209,192,0.60);
      box-shadow: 0 0 25px rgba(63,209,192,0.20), inset 0 0 20px rgba(63,209,192,0.08);
    }
    .container {
      width: 100%;
      max-width: min(1280px, 95vw);
      margin: 0 auto;
      padding: 0 clamp(1rem, 3vw, 2rem);
    }
    .text-center { text-align: center; }

    /* ─────────────────── SCROLLBAR ─────────────────── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(63,209,192,0.40); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(63,209,192,0.70); }

    /* ─────────────────── ANIMATIONS ─────────────────── */
    @keyframes float {
      0%,100% { transform: translateY(0); }
      50%      { transform: translateY(-10px); }
    }
    @keyframes pulse {
      0%,100% { opacity:1; transform:scale(1); }
      50%      { opacity:.5; transform:scale(0.9); }
    }

    /* ══════════════════════════════════════════
       NAVBAR
    ══════════════════════════════════════════ */
    nav {
      position: fixed; top: 0; left: 0; right: 0;
      z-index: 100;
      transition: all 0.5s ease;
    }
    nav.scrolled {
      background: rgba(255,255,255,0.10);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255,255,255,0.20);
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    html.dark nav.scrolled {
      background: rgba(0,0,0,0.20);
      border-bottom: 1px solid rgba(255,255,255,0.08);
      box-shadow: 0 4px 20px rgba(0,0,0,0.20);
    }

    .nav-inner {
      max-width: min(1280px, 95vw); margin: 0 auto;
      padding: 0 clamp(1rem, 3vw, 2rem);
      display: flex; align-items: center; justify-content: space-between;
      height: var(--nav-h);
      gap: 1rem;
    }

    /* Logo */
    .nav-logo { display: flex; align-items: center; gap: 8px; text-decoration: none; flex-shrink: 0; }
    .nav-logo-icon {
      width: 32px; height: 32px; border-radius: 10px;
      background: var(--primary);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 0 20px rgba(63,209,192,0.40);
      flex-shrink: 0;
    }
    .nav-logo-icon span { color:#fff; font-weight:900; font-size:14px; }
    .nav-logo-text {
      font-size: clamp(16px, 1.5vw, 20px); font-weight: 800;
      background: linear-gradient(135deg,#3FD1C0,#14b8a6,#0d9488);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }

    /* Desktop links */
    .nav-links { display: flex; align-items: center; gap: 4px; }
    .nav-link {
      padding: clamp(6px,0.6vw,8px) clamp(10px,1.2vw,16px); border-radius: 12px;
      font-size: clamp(12px, 1vw, 14px); font-weight: 600;
      color: #475569; text-decoration: none;
      transition: all 0.2s; white-space: nowrap;
    }
    html.dark .nav-link { color: #cbd5e1; }
    .nav-link:hover, .nav-link.active { color: var(--primary); background: rgba(63,209,192,0.10); }

    /* Desktop actions */
    .nav-actions { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .btn-login {
      padding: clamp(6px,0.6vw,8px) clamp(10px,1.2vw,16px); border-radius: 12px;
      font-size: clamp(12px, 1vw, 14px); font-weight: 600;
      color: #475569; text-decoration: none;
      transition: all 0.2s; white-space: nowrap;
    }
    html.dark .btn-login { color: #cbd5e1; }
    .btn-login:hover { color: var(--primary); background: rgba(63,209,192,0.10); }
    .btn-register {
      padding: clamp(6px,0.6vw,8px) clamp(12px,1.5vw,20px); border-radius: 12px;
      font-size: clamp(12px, 1vw, 14px); font-weight: 700;
      background: var(--primary); color: #fff; text-decoration: none;
      transition: all 0.2s; white-space: nowrap;
      box-shadow: 0 0 20px rgba(63,209,192,0.40);
    }
    .btn-register:hover { background: #14b8a6; }

    /* Theme toggle */
    .theme-toggle {
      width: 36px; height: 36px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      background: rgba(255,255,255,0.60);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.80);
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      color: #475569; transition: all 0.2s;
      flex-shrink: 0;
    }
    html.dark .theme-toggle {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      color: #cbd5e1;
    }
    .theme-toggle:hover { color: var(--primary); }

    /* Hamburger */
    .hamburger {
      display: none;
      padding: 8px; border-radius: 12px;
      border: 1px solid rgba(255,255,255,0.20);
      cursor: pointer;
      background: rgba(255,255,255,0.10);
      backdrop-filter: blur(20px);
      color: #475569; flex-shrink: 0;
      align-items: center; justify-content: center;
    }
    html.dark .hamburger { color: #cbd5e1; }

    /* Mobile right group */
    .mobile-right { display: none; align-items: center; gap: 8px; }

    /* Mobile menu */
    .mobile-menu {
      display: none;
      flex-direction: column; gap: 4px;
      padding: 12px 16px 16px;
      margin: 0 12px 12px;
      border-radius: 16px;
    }
    .mobile-menu.open { display: flex; }
    .mobile-menu .nav-link { display: block; padding: 12px 16px; font-size: 15px; }
    .mobile-menu-auth {
      padding-top: 12px;
      border-top: 1px solid rgba(255,255,255,0.20);
      display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
      margin-top: 4px;
    }
    html.dark .mobile-menu-auth { border-color: rgba(255,255,255,0.05); }
    .mobile-menu-auth a {
      text-align: center; padding: 12px 16px;
      border-radius: 12px; font-size: 14px; font-weight: 600;
      text-decoration: none; transition: all 0.2s;
    }
    .mobile-login { border: 1px solid rgba(63,209,192,0.30); color: var(--primary); }
    .mobile-login:hover { background: rgba(63,209,192,0.10); }
    .mobile-register { background: var(--primary); color: #fff; }
    .mobile-register:hover { background: #14b8a6; }

    /* ══════════════════════════════════════════
       HERO
    ══════════════════════════════════════════ */
    .hero {
      position: relative; min-height: 90vh;
      display: flex; align-items: center; overflow: hidden;
      padding-top: var(--nav-h);
    }
    .hero-orb {
      position: absolute; border-radius: 50%; filter: blur(60px);
      pointer-events: none;
    }
    .hero-orb-1 { top: 80px; left: 25%; width: 384px; height: 384px; background: rgba(63,209,192,0.20); animation: float 6s ease-in-out infinite; }
    .hero-orb-2 { bottom: 80px; right: 25%; width: 256px; height: 256px; background: rgba(20,184,166,0.15); animation: float 6s ease-in-out infinite; animation-delay: 400ms; }
    .hero-orb-3 { top: 160px; right: 33%; width: 192px; height: 192px; background: rgba(52,211,153,0.10); animation: float 6s ease-in-out infinite; animation-delay: 200ms; }

    .hero-content { position: relative; z-index: 10; padding: clamp(3rem, 6vw, 5rem) 0 clamp(2rem, 4vw, 4rem); width: 100%; }

    .hero-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: clamp(20px, 3vw, 48px);
      align-items: center;
    }

    /* Badge */
    .hero-badge {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 8px 16px; border-radius: 9999px;
      background: rgba(255,255,255,0.10); backdrop-filter: blur(20px);
      border: 1px solid rgba(63,209,192,0.30);
      font-size: 13px; font-weight: 600; color: var(--primary);
      margin-bottom: 20px;
    }
    .pulse { width: 8px; height: 8px; border-radius: 50%; background: var(--primary); animation: pulse 2s infinite; flex-shrink: 0; }

    /* Hero heading */
    .hero h1 {
      font-size: clamp(2rem, 5.5vw, 4.5rem);
      font-weight: 800; line-height: 1.1;
      color: #0f172a; margin-bottom: 20px;
    }
    html.dark .hero h1 { color: #fff; }

    .hero p {
      font-size: clamp(15px, 2vw, 18px);
      color: #64748b; margin-bottom: 28px;
      max-width: 480px; line-height: 1.7;
    }
    html.dark .hero p { color: #94a3b8; }

    .hero-btns { display: flex; flex-wrap: wrap; gap: 12px; }

    /* Buttons */
    .btn-primary {
      padding: clamp(11px, 1.1vw, 14px) clamp(20px, 2.2vw, 28px); border-radius: 16px;
      font-weight: 700; font-size: clamp(13px, 1vw, 14px);
      background: var(--primary); color: #fff; text-decoration: none;
      box-shadow: 0 0 20px rgba(63,209,192,0.40);
      transition: all 0.3s; display: inline-block;
    }
    .btn-primary:hover { transform: scale(1.05); box-shadow: 0 0 30px rgba(63,209,192,0.60); }

    .btn-secondary {
      padding: clamp(11px, 1.1vw, 14px) clamp(20px, 2.2vw, 28px); border-radius: 16px;
      font-weight: 700; font-size: clamp(13px, 1vw, 14px);
      background: rgba(255,255,255,0.10); backdrop-filter: blur(20px);
      border: 1px solid rgba(63,209,192,0.30); color: var(--primary);
      text-decoration: none; transition: all 0.2s; display: inline-block;
    }
    .btn-secondary:hover { background: rgba(63,209,192,0.10); }

    /* Stats */
    .hero-stats { display: flex; flex-wrap: wrap; gap: clamp(16px, 4vw, 32px); margin-top: 40px; }
    .stat-num { font-size: clamp(18px, 3vw, 24px); font-weight: 800; }
    .stat-lbl { font-size: 12px; color: #94a3b8; font-weight: 600; }

    /* Hero Card */
    .hero-card {
      border-radius: 24px; padding: 24px;
      max-width: 360px; margin-left: auto;
      animation: float 6s ease-in-out infinite;
      width: 100%;
    }
    .hero-card-title { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
    .dot { width: 12px; height: 12px; border-radius: 50%; }
    .dot-red { background: #f87171; }
    .dot-yellow { background: #fbbf24; }
    .dot-green { background: #4ade80; }
    .card-label { font-size: 12px; color: #94a3b8; margin-left: 4px; }
    .service-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: 10px 12px; border-radius: 12px;
      background: rgba(255,255,255,0.30); margin-bottom: 8px;
    }
    html.dark .service-row { background: rgba(255,255,255,0.05); }
    .service-info { display: flex; align-items: center; gap: 8px; }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; animation: pulse 2s infinite; flex-shrink: 0; }
    .s-green { background: #4ade80; }
    .s-blue  { background: #60a5fa; }
    .service-name { font-size: 14px; font-weight: 500; color: #334155; }
    html.dark .service-name { color: #cbd5e1; }
    .service-status { font-size: 12px; font-weight: 700; color: var(--primary); }
    .usage-box {
      padding: 14px; border-radius: 16px;
      background: rgba(63,209,192,0.10);
      border: 1px solid rgba(63,209,192,0.20);
      margin-top: 8px;
    }
    .usage-title { font-size: 12px; font-weight: 700; color: var(--primary); margin-bottom: 8px; }
    .usage-bars { display: flex; align-items: flex-end; gap: 3px; height: 44px; }
    .usage-bar { flex: 1; background: rgba(63,209,192,0.40); border-radius: 2px; }

    /* ══════════════════════════════════════════
       SECTIONS
    ══════════════════════════════════════════ */
    section { padding: clamp(40px, 6vw, 80px) 0; }

    .section-header { text-align: center; margin-bottom: clamp(32px, 5vw, 64px); }
    .section-header h2 {
      font-size: clamp(1.6rem, 3.5vw, 2.5rem); font-weight: 800;
      color: #1e293b; margin-bottom: 14px;
    }
    html.dark .section-header h2 { color: #fff; }
    .section-header p { font-size: clamp(15px, 2vw, 18px); color: #64748b; max-width: 640px; margin: 0 auto; }
    html.dark .section-header p { color: #94a3b8; }

    /* ─── FEATURES ─── */
    .feature-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: clamp(14px, 2vw, 24px);
    }
    .feature-card {
      border-radius: 16px; padding: clamp(14px, 1.8vw, 24px);
      transition: all 0.3s;
    }
    .feature-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(63,209,192,0.10); }
    .feature-icon {
      width: 48px; height: 48px; border-radius: 16px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; margin-bottom: 14px;
      transition: transform 0.3s;
    }
    .feature-card:hover .feature-icon { transform: scale(1.1); }
    .feature-icon.yellow { background: #fef9c3; }
    html.dark .feature-icon.yellow { background: rgba(234,179,8,0.20); }
    .feature-icon.blue { background: #dbeafe; }
    html.dark .feature-icon.blue { background: rgba(59,130,246,0.20); }
    .feature-icon.green { background: #dcfce7; }
    html.dark .feature-icon.green { background: rgba(34,197,94,0.20); }
    .feature-icon.purple { background: #f3e8ff; }
    html.dark .feature-icon.purple { background: rgba(168,85,247,0.20); }
    .feature-icon.orange { background: #ffedd5; }
    html.dark .feature-icon.orange { background: rgba(249,115,22,0.20); }
    .feature-icon.teal { background: #ccfbf1; }
    html.dark .feature-icon.teal { background: rgba(20,184,166,0.20); }
    .feature-card h3 { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    html.dark .feature-card h3 { color: #fff; }
    .feature-card p { font-size: 13px; color: #64748b; line-height: 1.6; }
    html.dark .feature-card p { color: #94a3b8; }

    /* ─── PLANS ─── */
    .plans-section {
      background: linear-gradient(to bottom, transparent, rgba(63,209,192,0.05), transparent);
    }
    .plans-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: clamp(14px, 2vw, 24px);
      max-width: 900px; margin: 0 auto;
    }

    .pricing-card {
      position: relative; border-radius: 16px;
      padding: clamp(16px, 1.8vw, 24px);
      transition: all 0.3s;
    }
    .pricing-card:hover { transform: translateY(-8px); }
    .pricing-card.popular {
      background: var(--primary); color: #fff;
      box-shadow: 0 20px 60px rgba(63,209,192,0.30);
    }
    .popular-badge {
      position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
      background: #fff; color: var(--primary);
      font-size: 10px; font-weight: 900; letter-spacing: 0.05em;
      padding: 4px 14px; border-radius: 9999px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.10);
      white-space: nowrap;
    }
    .plan-name { font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--primary); }
    .pricing-card.popular .plan-name { color: rgba(255,255,255,0.80); }
    .plan-price { display: flex; align-items: baseline; gap: 4px; margin-bottom: 20px; flex-wrap: wrap; }
    .plan-price-num { font-size: clamp(26px, 4vw, 36px); font-weight: 800; color: #1e293b; }
    html.dark .plan-price-num { color: #fff; }
    .pricing-card.popular .plan-price-num { color: #fff; }
    .plan-price-period { font-size: 13px; color: #94a3b8; }
    .pricing-card.popular .plan-price-period { color: rgba(255,255,255,0.70); }
    .plan-features { list-style: none; margin-bottom: 20px; display: flex; flex-direction: column; gap: 10px; }
    .plan-feature { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; }
    .plan-feature svg { width: 16px; height: 16px; margin-top: 1px; flex-shrink: 0; color: var(--primary); }
    .pricing-card.popular .plan-feature svg { color: #fff; }
    .plan-feature span { color: #475569; }
    html.dark .plan-feature span { color: #cbd5e1; }
    .pricing-card.popular .plan-feature span { color: rgba(255,255,255,0.90); }
    .btn-plan {
      width: 100%; padding: 12px; border-radius: 12px;
      font-size: 14px; font-weight: 700; cursor: pointer;
      border: none; text-align: center; display: block;
      text-decoration: none; transition: all 0.3s;
    }
    .btn-plan-default {
      background: rgba(63,209,192,0.10); color: var(--primary);
      border: 1px solid rgba(63,209,192,0.20);
    }
    .btn-plan-default:hover { background: var(--primary); color: #fff; }
    .btn-plan-popular { background: #fff; color: var(--primary); }
    .btn-plan-popular:hover { background: rgba(255,255,255,0.90); }

    /* ─── VPS ─── */
    .vps-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: clamp(12px, 2vw, 16px);
    }
    .vps-card { border-radius: 16px; padding: clamp(14px, 1.8vw, 24px); transition: all 0.3s; }
    .vps-card:hover { transform: translateY(-4px); }
    .vps-name { font-size: 11px; font-weight: 700; color: var(--primary); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
    .vps-price { font-size: clamp(20px, 3vw, 24px); font-weight: 800; color: #1e293b; margin-bottom: 14px; }
    html.dark .vps-price { color: #fff; }
    .vps-price span { font-size: 13px; font-weight: 400; color: #94a3b8; }
    .vps-specs { display: flex; flex-direction: column; gap: 8px; }
    .vps-spec { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b; }
    html.dark .vps-spec { color: #94a3b8; }
    .vps-spec-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--primary); flex-shrink: 0; }

    /* ─── CTA BANNER ─── */
    .cta-banner {
      position: relative; border-radius: 24px; overflow: hidden;
      text-align: center; padding: clamp(48px, 8vw, 80px) clamp(20px, 5vw, 40px);
    }
    .cta-bg {
      position: absolute; inset: 0;
      background: linear-gradient(135deg, var(--primary), #14b8a6, #10b981);
    }
    .cta-highlight {
      position: absolute; inset: 0;
      background: radial-gradient(ellipse at top right, rgba(255,255,255,0.15), transparent 70%);
    }
    .cta-orb {
      position: absolute; bottom: -32px; right: -32px;
      width: 192px; height: 192px;
      background: rgba(255,255,255,0.10); border-radius: 50%; filter: blur(32px);
    }
    .cta-content { position: relative; z-index: 1; color: #fff; }
    .cta-content h2 { font-size: clamp(1.5rem, 3.5vw, 2.5rem); font-weight: 800; margin-bottom: 14px; }
    .cta-content p { color: rgba(255,255,255,0.80); margin-bottom: 28px; max-width: 480px; margin-left: auto; margin-right: auto; font-size: clamp(14px, 2vw, 16px); }
    .cta-btns { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }
    .btn-cta-white {
      padding: 14px 28px; border-radius: 16px;
      background: #fff; color: var(--primary);
      font-weight: 800; font-size: 14px;
      text-decoration: none; transition: all 0.3s;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .btn-cta-white:hover { transform: scale(1.05); }
    .btn-cta-glass {
      padding: 14px 28px; border-radius: 16px;
      background: rgba(255,255,255,0.20); color: #fff;
      font-weight: 700; font-size: 14px;
      border: 1px solid rgba(255,255,255,0.30);
      text-decoration: none; transition: all 0.2s;
    }
    .btn-cta-glass:hover { background: rgba(255,255,255,0.30); }

    /* ─── VIEW-ALL links ─── */
    .mt-10 { margin-top: 40px; }
    .link-view-all {
      padding: 12px 28px; border-radius: 12px;
      font-weight: 700; font-size: 14px;
      background: rgba(255,255,255,0.10); backdrop-filter: blur(20px);
      border: 1px solid rgba(63,209,192,0.30); color: var(--primary);
      text-decoration: none; transition: all 0.2s; display: inline-block;
    }
    html.dark .link-view-all { background: rgba(255,255,255,0.04); }
    .link-view-all:hover { background: rgba(63,209,192,0.10); }
    .link-view-all-solid {
      padding: 12px 28px; border-radius: 12px;
      font-weight: 700; font-size: 14px;
      background: var(--primary); color: #fff;
      text-decoration: none; transition: all 0.3s; display: inline-block;
      box-shadow: 0 0 20px rgba(63,209,192,0.40);
    }
    .link-view-all-solid:hover { transform: scale(1.05); }

    /* ══════════════════════════════════════════
       RESPONSIVE BREAKPOINTS
    ══════════════════════════════════════════ */

    /* ── Tablet (≤ 1024px) ── */
    @media (max-width: 1024px) {
      .feature-grid { grid-template-columns: repeat(2, 1fr); }
      .vps-grid     { grid-template-columns: repeat(2, 1fr); }

      .hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
      }
      .hero p { margin-left: auto; margin-right: auto; }
      .hero-btns { justify-content: center; }
      .hero-stats { justify-content: center; }
      .hero-card  { display: none !important; }
    }

    /* ── Phablet / large phone (≤ 768px) ── */
    @media (max-width: 768px) {
      :root { --nav-h: 56px; }

      /* Navbar: hide desktop links & actions, show mobile controls */
      .nav-links   { display: none; }
      .nav-actions { display: none; }
      .mobile-right { display: flex; }
      .hamburger  { display: flex; }

      /* Plans: stack to 1 column */
      .plans-grid { grid-template-columns: 1fr; max-width: 400px; }

      /* Hero orbs scaled down */
      .hero-orb-1 { width: 260px; height: 260px; left: 10%; top: 60px; }
      .hero-orb-2 { width: 180px; height: 180px; right: 5%; }
      .hero-orb-3 { width: 130px; height: 130px; }

      .hero-badge { font-size: 12px; padding: 6px 12px; }

      section { padding: clamp(40px, 7vw, 60px) 0; }
    }

    /* ── Phone (≤ 640px) ── */
    @media (max-width: 640px) {
      .feature-grid { grid-template-columns: 1fr; }
      .vps-grid     { grid-template-columns: 1fr; }

      /* Container padding tighter on small screens */
      .container { padding: 0 1rem; }

      /* Hero adjustments */
      .hero-content { padding: 3rem 0 2.5rem; }
      .hero-btns { flex-direction: column; align-items: center; }
      .hero-btns a { width: 100%; max-width: 280px; text-align: center; }

      .hero-stats { gap: 14px; }

      /* CTA banner padding */
      .cta-banner { border-radius: 16px; }

      /* Popular badge won't overflow */
      .pricing-card.popular { margin-top: 16px; }

      /* Section header */
      .section-header { margin-bottom: 32px; }
    }

    /* ── Very small phones (≤ 380px) ── */
    @media (max-width: 380px) {
      .hero h1 { font-size: 1.75rem; }
      .btn-primary, .btn-secondary { padding: 12px 20px; }
    }
  </style>
</head>
<body class="mesh-bg-light">

<!-- ══════════ NAVBAR ══════════ -->
<nav id="navbar">
  <div class="nav-inner">
    <!-- Logo -->
    <a href="index.html" class="nav-logo">
      <div class="nav-logo-icon"><span>d</span></div>
      <span class="nav-logo-text">dTech</span>
    </a>

    <!-- Desktop nav links -->
    <div class="nav-links">
      <a href="domain.html"  class="nav-link">Domain</a>
      <a href="hosting.html" class="nav-link">Hosting</a>
      <a href="vps.html"     class="nav-link">VPS</a>
    </div>

    <!-- Desktop actions -->
    <div class="nav-actions">
      <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme" id="themeBtn">
        <svg id="icon-moon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        <svg id="icon-sun"  style="display:none" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      </button>
      <a href="https://localhost/my.site/user/login"    class="btn-login">Login</a>
      <a href="https://localhost/my.site/user/register" class="btn-register">Register</a>
    </div>

    <!-- Mobile: theme + hamburger -->
    <div class="mobile-right">
      <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <svg id="icon-moon-m" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        <svg id="icon-sun-m"  style="display:none" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      </button>
      <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
        <svg id="icon-menu"  width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg id="icon-close" style="display:none" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
  </div>

  <!-- Mobile dropdown menu -->
  <div class="mobile-menu glass-card" id="mobileMenu">
    <a href="domain.html"  class="nav-link">Domain</a>
    <a href="hosting.html" class="nav-link">Hosting</a>
    <a href="vps.html"     class="nav-link">VPS</a>
    <div class="mobile-menu-auth">
      <a href="https://localhost/my.site/user/login"    class="mobile-login">Login</a>
      <a href="https://localhost/my.site/user/register" class="mobile-register">Register</a>
    </div>
  </div>
</nav>

<!-- ══════════ HERO ══════════ -->
<section class="hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>
  <div class="hero-orb hero-orb-3"></div>

  <div class="container hero-content">
    <div class="hero-grid">
      <!-- Text -->
      <div>
        <div class="hero-badge">
          <span class="pulse"></span>
          Host Any App. Any Stack. Instantly.
        </div>
        <h1>
          Premium Cloud
          <span class="text-gradient" style="display:block">Hosting for</span>
          Bangladesh
        </h1>
        <p>Deploy Node.js, Python, PHP, .NET, Next.js, React &amp; more on high-performance infrastructure with one-click deployment and 24/7 support.</p>
        <div class="hero-btns">
          <a href="hosting.html" class="btn-primary">Get Started Free →</a>
          <a href="domain.html"  class="btn-secondary">Search Domain</a>
        </div>
        <div class="hero-stats">
          <div><div class="stat-num text-gradient">10K+</div><div class="stat-lbl">Happy Clients</div></div>
          <div><div class="stat-num text-gradient">99.9%</div><div class="stat-lbl">Uptime SLA</div></div>
          <div><div class="stat-num text-gradient">24/7</div><div class="stat-lbl">Support</div></div>
        </div>
      </div>

      <!-- Dashboard card (hidden on tablet/mobile via CSS) -->
      <div class="hero-card glass-card border-glow">
        <div class="hero-card-title">
          <div class="dot dot-red"></div>
          <div class="dot dot-yellow"></div>
          <div class="dot dot-green"></div>
          <span class="card-label">dtech-dashboard</span>
        </div>
        <div>
          <div class="service-row">
            <div class="service-info"><div class="status-dot s-green"></div><span class="service-name">Web Server</span></div>
            <span class="service-status">Running</span>
          </div>
          <div class="service-row">
            <div class="service-info"><div class="status-dot s-green"></div><span class="service-name">Database</span></div>
            <span class="service-status">Active</span>
          </div>
          <div class="service-row">
            <div class="service-info"><div class="status-dot s-green"></div><span class="service-name">SSL Certificate</span></div>
            <span class="service-status">Valid</span>
          </div>
          <div class="service-row">
            <div class="service-info"><div class="status-dot s-blue"></div><span class="service-name">CDN</span></div>
            <span class="service-status">Enabled</span>
          </div>
        </div>
        <div class="usage-box">
          <div class="usage-title">Monthly Usage</div>
          <div class="usage-bars">
            <div class="usage-bar" style="height:40%"></div>
            <div class="usage-bar" style="height:65%"></div>
            <div class="usage-bar" style="height:45%"></div>
            <div class="usage-bar" style="height:80%"></div>
            <div class="usage-bar" style="height:60%"></div>
            <div class="usage-bar" style="height:90%"></div>
            <div class="usage-bar" style="height:70%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════ FEATURES ══════════ -->
<section>
  <div class="container">
    <div class="section-header">
      <h2>Everything You Need to <span class="text-gradient">Scale Fast</span></h2>
      <p>World-class infrastructure with Bangladesh-local support.</p>
    </div>
    <div class="feature-grid">
      <div class="feature-card glass-card border-glow">
        <div class="feature-icon yellow">⚡</div>
        <h3>Instant Deployment</h3>
        <p>Go live in seconds with our one-click deployment system. Zero configuration headaches.</p>
      </div>
      <div class="feature-card glass-card border-glow">
        <div class="feature-icon blue">🛡️</div>
        <h3>Enterprise Security</h3>
        <p>DDoS protection, WAF, free SSL, and daily backups keep your data safe 24/7.</p>
      </div>
      <div class="feature-card glass-card border-glow">
        <div class="feature-icon green">🌍</div>
        <h3>Bangladesh CDN</h3>
        <p>Local edge nodes ensure blazing-fast load times for your Bangladeshi audience.</p>
      </div>
      <div class="feature-card glass-card border-glow">
        <div class="feature-icon purple">📊</div>
        <h3>Real-time Analytics</h3>
        <p>Monitor bandwidth, requests, and uptime from your intuitive control panel.</p>
      </div>
      <div class="feature-card glass-card border-glow">
        <div class="feature-icon orange">🔄</div>
        <h3>Auto Backups</h3>
        <p>Daily automated backups with one-click restoration. Never lose your data again.</p>
      </div>
      <div class="feature-card glass-card border-glow">
        <div class="feature-icon teal">💬</div>
        <h3>24/7 Local Support</h3>
        <p>Bangla-speaking support team available round the clock via WhatsApp and chat.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══════════ HOSTING PLANS ══════════ -->
<section class="plans-section">
  <div class="container">
    <div class="section-header">
      <h2>Hosting Plans <span class="text-gradient">Built for Speed</span></h2>
      <p>Transparent pricing with everything you need.</p>
    </div>
    <div class="plans-grid">
      <!-- Starter -->
      <div class="pricing-card glass-card border-glow">
        <div class="plan-name">Starter</div>
        <div class="plan-price">
          <span class="plan-price-num">৳700</span>
          <span class="plan-price-period">/mo</span>
        </div>
        <ul class="plan-features">
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>1 Website</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>5 GB SSD</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>10 GB Bandwidth</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Free SSL</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>24/7 Support</span></li>
        </ul>
        <a href="hosting.html" class="btn-plan btn-plan-default">Get Started</a>
      </div>

      <!-- Business (popular) -->
      <div class="pricing-card popular">
        <div class="popular-badge">MOST POPULAR</div>
        <div class="plan-name">Business</div>
        <div class="plan-price">
          <span class="plan-price-num">৳1,200</span>
          <span class="plan-price-period">/mo</span>
        </div>
        <ul class="plan-features">
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>5 Websites</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>20 GB SSD</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Unlimited Bandwidth</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Free SSL</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Daily Backup</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Priority Support</span></li>
        </ul>
        <a href="hosting.html" class="btn-plan btn-plan-popular">Get Started</a>
      </div>

      <!-- Pro -->
      <div class="pricing-card glass-card border-glow">
        <div class="plan-name">Pro</div>
        <div class="plan-price">
          <span class="plan-price-num">৳2,000</span>
          <span class="plan-price-period">/mo</span>
        </div>
        <ul class="plan-features">
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Unlimited Sites</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>50 GB SSD</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Unlimited Bandwidth</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Free SSL</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Daily Backup</span></li>
          <li class="plan-feature"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Dedicated IP</span></li>
        </ul>
        <a href="hosting.html" class="btn-plan btn-plan-default">Get Started</a>
      </div>
    </div>
    <div class="text-center mt-10">
      <a href="hosting.html" class="link-view-all">View All Plans →</a>
    </div>
  </div>
</section>

<!-- ══════════ VPS ══════════ -->
<section>
  <div class="container">
    <div class="section-header">
      <h2>Blazing-Fast <span class="text-gradient">VPS Hosting</span></h2>
      <p>Full root access, guaranteed resources, and instant provisioning.</p>
    </div>
    <div class="vps-grid">
      <div class="vps-card glass-card border-glow">
        <div class="vps-name">VPS Nano</div>
        <div class="vps-price">৳1,200<span>/mo</span></div>
        <div class="vps-specs">
          <div class="vps-spec"><div class="vps-spec-dot"></div>1 vCPU</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>1 GB RAM</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>20 GB SSD</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>1 TB/mo</div>
        </div>
      </div>
      <div class="vps-card glass-card border-glow">
        <div class="vps-name">VPS Micro</div>
        <div class="vps-price">৳2,000<span>/mo</span></div>
        <div class="vps-specs">
          <div class="vps-spec"><div class="vps-spec-dot"></div>2 vCPU</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>2 GB RAM</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>40 GB SSD</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>2 TB/mo</div>
        </div>
      </div>
      <div class="vps-card glass-card border-glow">
        <div class="vps-name">VPS Pro</div>
        <div class="vps-price">৳3,500<span>/mo</span></div>
        <div class="vps-specs">
          <div class="vps-spec"><div class="vps-spec-dot"></div>4 vCPU</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>4 GB RAM</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>80 GB SSD</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>4 TB/mo</div>
        </div>
      </div>
      <div class="vps-card glass-card border-glow">
        <div class="vps-name">VPS Ultra</div>
        <div class="vps-price">৳6,000<span>/mo</span></div>
        <div class="vps-specs">
          <div class="vps-spec"><div class="vps-spec-dot"></div>8 vCPU</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>8 GB RAM</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>160 GB SSD</div>
          <div class="vps-spec"><div class="vps-spec-dot"></div>8 TB/mo</div>
        </div>
      </div>
    </div>
    <div class="text-center mt-10">
      <a href="vps.html" class="link-view-all-solid">Explore VPS Plans →</a>
    </div>
  </div>
</section>

<!-- ══════════ CTA BANNER ══════════ -->
<section>
  <div class="container">
    <div class="cta-banner">
      <div class="cta-bg"></div>
      <div class="cta-highlight"></div>
      <div class="cta-orb"></div>
      <div class="cta-content">
        <h2>Ready to Go Live?</h2>
        <p>Join thousands of Bangladeshi businesses running on dTech's lightning-fast infrastructure.</p>
        <div class="cta-btns">
          <a href="hosting.html" class="btn-cta-white">Start Free Today</a>
          <a href="domain.html"  class="btn-cta-glass">Search Domain</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════ SCRIPTS ══════════ -->
<script>
  /* ── Theme ── */
  function applyTheme(t) {
    document.documentElement.classList.toggle('dark', t === 'dark');
    ['icon-moon','icon-moon-m'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.style.display = t === 'dark' ? 'none' : 'block';
    });
    ['icon-sun','icon-sun-m'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.style.display = t === 'dark' ? 'block' : 'none';
    });
  }
  function toggleTheme() {
    const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
    localStorage.setItem('dtech-theme', next);
    applyTheme(next);
  }
  (function() {
    const stored    = localStorage.getItem('dtech-theme');
    const preferred = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    applyTheme(stored || preferred);
  })();

  /* ── Navbar scroll ── */
  window.addEventListener('scroll', function() {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
  }, { passive: true });

  /* ── Mobile menu ── */
  function toggleMenu() {
    const menu     = document.getElementById('mobileMenu');
    const iconMenu  = document.getElementById('icon-menu');
    const iconClose = document.getElementById('icon-close');
    const isOpen   = menu.classList.contains('open');
    menu.classList.toggle('open', !isOpen);
    iconMenu.style.display  = isOpen ? 'block' : 'none';
    iconClose.style.display = isOpen ? 'none'  : 'block';
  }

  /* ── Close mobile menu on link click ── */
  document.querySelectorAll('#mobileMenu .nav-link, #mobileMenu a').forEach(function(link) {
    link.addEventListener('click', function() {
      const menu     = document.getElementById('mobileMenu');
      const iconMenu  = document.getElementById('icon-menu');
      const iconClose = document.getElementById('icon-close');
      menu.classList.remove('open');
      iconMenu.style.display  = 'block';
      iconClose.style.display = 'none';
    });
  });

  /* ── Close mobile menu on outside click ── */
  document.addEventListener('click', function(e) {
    const nav  = document.getElementById('navbar');
    const menu = document.getElementById('mobileMenu');
    if (menu.classList.contains('open') && !nav.contains(e.target)) {
      menu.classList.remove('open');
      document.getElementById('icon-menu').style.display  = 'block';
      document.getElementById('icon-close').style.display = 'none';
    }
  });
</script>
</body>
</html>
