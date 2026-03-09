<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HotelGo — README</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --gold: #c9a84c;
      --gold-light: #e8c96a;
      --gold-dim: rgba(201,168,76,0.15);
      --bg: #0b0c0e;
      --bg2: #111214;
      --bg3: #18191d;
      --surface: #1e1f24;
      --border: rgba(201,168,76,0.2);
      --text: #e8e6e1;
      --muted: #7a7872;
      --accent: #d4af6a;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      line-height: 1.75;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── Grain overlay ── */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
      opacity: 0.4;
    }

    /* ── Layout ── */
    .wrap {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 2rem 6rem;
      position: relative;
      z-index: 1;
    }

    /* ── Hero ── */
    .hero {
      padding: 5rem 0 3rem;
      text-align: center;
      position: relative;
    }

    .hero-glow {
      position: absolute;
      top: 0; left: 50%;
      transform: translateX(-50%);
      width: 600px; height: 300px;
      background: radial-gradient(ellipse at center, rgba(201,168,76,0.12) 0%, transparent 70%);
      pointer-events: none;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      color: var(--gold);
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      padding: 5px 14px;
      border-radius: 20px;
      margin-bottom: 1.5rem;
      animation: fadeUp 0.6s ease both;
    }

    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(3.5rem, 8vw, 6rem);
      font-weight: 900;
      line-height: 1;
      letter-spacing: -0.02em;
      background: linear-gradient(135deg, #fff 30%, var(--gold-light) 70%, var(--gold) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: fadeUp 0.6s 0.1s ease both;
    }

    .hero-dot {
      -webkit-text-fill-color: var(--gold);
      color: var(--gold);
    }

    .hero-tagline {
      margin-top: 1.25rem;
      color: var(--muted);
      font-size: 1rem;
      max-width: 520px;
      margin-left: auto;
      margin-right: auto;
      animation: fadeUp 0.6s 0.2s ease both;
    }

    .hero-divider {
      width: 60px; height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      margin: 2rem auto;
      animation: fadeUp 0.6s 0.3s ease both;
    }

    /* ── Team pills ── */
    .team-row {
      display: flex;
      justify-content: center;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 0.5rem;
      animation: fadeUp 0.6s 0.4s ease both;
    }

    .team-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--surface);
      border: 1px solid var(--border);
      padding: 7px 16px;
      border-radius: 40px;
      font-size: 13px;
      font-weight: 500;
      color: var(--text);
    }

    .team-pill .avatar {
      width: 24px; height: 24px;
      background: linear-gradient(135deg, var(--gold), #8a6020);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 10px;
      font-weight: 700;
      color: #000;
      flex-shrink: 0;
    }

    /* ── Section ── */
    section {
      margin-top: 4rem;
      animation: fadeUp 0.5s ease both;
    }

    .section-label {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 1.25rem;
    }

    .section-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.9rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1.25rem;
      line-height: 1.2;
    }

    h3 {
      font-size: 0.85rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--gold);
      margin: 1.5rem 0 0.6rem;
    }

    p { color: #b0aea8; margin-bottom: 0.75rem; }

    /* ── Cards grid ── */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 16px;
    }

    .card {
      background: var(--surface);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 12px;
      padding: 1.5rem;
      position: relative;
      overflow: hidden;
      transition: border-color 0.25s, transform 0.25s;
    }

    .card:hover {
      border-color: var(--border);
      transform: translateY(-2px);
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      opacity: 0;
      transition: opacity 0.25s;
    }

    .card:hover::before { opacity: 1; }

    .card-icon {
      font-size: 1.6rem;
      margin-bottom: 0.75rem;
      display: block;
    }

    .card h3 {
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0;
      text-transform: none;
      color: #fff;
      margin: 0 0 0.5rem;
    }

    .card p {
      font-size: 13px;
      color: var(--muted);
      margin: 0;
    }

    /* ── Role cards ── */
    .roles {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 12px;
    }

    .role-card {
      background: var(--bg3);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 10px;
      padding: 1.25rem;
      transition: border-color 0.2s;
    }

    .role-card:hover { border-color: var(--border); }

    .role-tag {
      display: inline-block;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 3px 9px;
      border-radius: 4px;
      margin-bottom: 0.75rem;
    }

    .tag-system { background: rgba(201,168,76,0.15); color: var(--gold); }
    .tag-hotel  { background: rgba(100,180,255,0.12); color: #7ec8f5; }
    .tag-user   { background: rgba(120,220,150,0.12); color: #7de0a0; }
    .tag-guest  { background: rgba(200,150,255,0.12); color: #d0a0f5; }

    .role-card h4 {
      font-size: 0.9rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 0.5rem;
    }

    .role-card ul {
      list-style: none;
      padding: 0;
    }

    .role-card ul li {
      font-size: 12px;
      color: var(--muted);
      padding: 2px 0;
      padding-left: 14px;
      position: relative;
    }

    .role-card ul li::before {
      content: '—';
      position: absolute;
      left: 0;
      color: var(--border);
      font-size: 10px;
    }

    /* ── Tech stack ── */
    .stack {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .stack-item {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--bg3);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 8px;
      padding: 8px 14px;
      font-size: 13px;
      font-weight: 500;
      color: var(--text);
      transition: border-color 0.2s;
    }

    .stack-item:hover { border-color: var(--border); }

    .stack-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    /* ── Database table ── */
    .db-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 10px;
    }

    .db-table {
      background: var(--bg3);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 8px;
      padding: 1rem 1.25rem;
      transition: border-color 0.2s;
    }

    .db-table:hover { border-color: var(--border); }

    .db-table-name {
      font-family: 'DM Mono', monospace;
      font-size: 12px;
      font-weight: 500;
      color: var(--gold);
      margin-bottom: 0.5rem;
    }

    .db-table ul {
      list-style: none;
      padding: 0;
    }

    .db-table ul li {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      padding: 1px 0;
    }

    .db-table ul li span.key {
      color: #7ec8f5;
    }

    /* ── Routes ── */
    .routes-group { margin-bottom: 1.5rem; }

    .routes-group-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 0.6rem;
    }

    .route-row {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px 14px;
      background: var(--bg3);
      border: 1px solid transparent;
      border-radius: 6px;
      margin-bottom: 5px;
      transition: border-color 0.2s;
    }

    .route-row:hover { border-color: var(--border); }

    .method {
      font-family: 'DM Mono', monospace;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 4px;
      min-width: 52px;
      text-align: center;
    }

    .m-get    { background: rgba(120,220,150,0.15); color: #7de0a0; }
    .m-post   { background: rgba(100,180,255,0.15); color: #7ec8f5; }
    .m-patch  { background: rgba(255,190,100,0.15); color: #ffc46a; }
    .m-put    { background: rgba(255,160,80,0.15);  color: #ffa060; }
    .m-delete { background: rgba(255,100,100,0.15); color: #ff7070; }

    .route-path {
      font-family: 'DM Mono', monospace;
      font-size: 12px;
      color: #c8c5be;
      flex: 1;
    }

    .route-desc {
      font-size: 12px;
      color: var(--muted);
      text-align: right;
    }

    /* ── Middleware ── */
    .mw-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .mw-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      padding: 12px 16px;
      background: var(--bg3);
      border: 1px solid rgba(255,255,255,0.04);
      border-radius: 8px;
      transition: border-color 0.2s;
    }

    .mw-item:hover { border-color: var(--border); }

    .mw-name {
      font-family: 'DM Mono', monospace;
      font-size: 12px;
      color: var(--gold);
      min-width: 210px;
      flex-shrink: 0;
    }

    .mw-desc {
      font-size: 13px;
      color: var(--muted);
    }

    /* ── Timeline ── */
    .timeline {
      position: relative;
      padding-left: 2rem;
    }

    .timeline::before {
      content: '';
      position: absolute;
      left: 7px; top: 8px; bottom: 8px;
      width: 2px;
      background: linear-gradient(to bottom, var(--gold), transparent);
    }

    .tl-item {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .tl-dot {
      position: absolute;
      left: -2rem;
      top: 6px;
      width: 14px; height: 14px;
      border-radius: 50%;
      background: var(--gold-dim);
      border: 2px solid var(--gold);
    }

    .tl-week {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 3px;
    }

    .tl-title {
      font-weight: 600;
      color: #fff;
      font-size: 14px;
      margin-bottom: 4px;
    }

    .tl-desc {
      font-size: 13px;
      color: var(--muted);
    }

    /* ── Code block ── */
    .code-block {
      background: var(--bg3);
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 10px;
      overflow: hidden;
    }

    .code-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
      background: rgba(255,255,255,0.02);
    }

    .code-title {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--muted);
    }

    .code-dots { display: flex; gap: 6px; }
    .code-dots span {
      width: 10px; height: 10px; border-radius: 50%;
    }
    .code-dots .r { background: #ff5f57; }
    .code-dots .y { background: #febc2e; }
    .code-dots .g { background: #28c840; }

    pre {
      font-family: 'DM Mono', monospace;
      font-size: 12.5px;
      line-height: 1.7;
      padding: 1.25rem 1.5rem;
      overflow-x: auto;
      color: #c8c5be;
    }

    pre .cmd  { color: var(--gold); }
    pre .comment { color: var(--muted); }
    pre .str  { color: #7de0a0; }

    /* ── Footer ── */
    footer {
      margin-top: 5rem;
      padding-top: 2rem;
      border-top: 1px solid var(--border);
      text-align: center;
    }

    footer p {
      font-size: 12px;
      color: var(--muted);
    }

    footer .footer-logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      background: linear-gradient(135deg, #fff, var(--gold));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.5rem;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    section { opacity: 0; animation: fadeUp 0.5s ease forwards; }
    section:nth-child(1)  { animation-delay: 0.5s; }
    section:nth-child(2)  { animation-delay: 0.65s; }
    section:nth-child(3)  { animation-delay: 0.8s; }
    section:nth-child(4)  { animation-delay: 0.95s; }
    section:nth-child(5)  { animation-delay: 1.1s; }
    section:nth-child(6)  { animation-delay: 1.25s; }
    section:nth-child(7)  { animation-delay: 1.4s; }
    section:nth-child(8)  { animation-delay: 1.55s; }
    section:nth-child(9)  { animation-delay: 1.7s; }
    section:nth-child(10) { animation-delay: 1.85s; }
  </style>
</head>
<body>
<div class="wrap">

  <!-- HERO -->
  <div class="hero">
    <div class="hero-glow"></div>
    <div class="badge">🏨 Laravel · MySQL · Tailwind CSS</div>
    <h1>HotelGo<span class="hero-dot">.</span></h1>
    <p class="hero-tagline">A comprehensive hotel management &amp; booking platform — from room discovery to checkout.</p>
    <div class="hero-divider"></div>
    <div class="team-row">
      <div class="team-pill">
        <div class="avatar">FJ</div>
        Fatima JANNOUN
      </div>
      <div class="team-pill">
        <div class="avatar">HC</div>
        Hadi CHEBBO
      </div>
    </div>
  </div>

  <!-- OVERVIEW -->
  <section>
    <div class="section-label">Overview</div>
    <h2>What is HotelGo?</h2>
    <p>HotelGo is a full-stack hotel management and booking system built with the Laravel framework. It supports the complete booking lifecycle — from browsing available hotels to processing payments — while providing role-specific dashboards, a loyalty program, and automated email notifications.</p>
    <p>The platform serves four distinct user types: unauthenticated guests, registered customers, hotel administrators, and system administrators — each with their own permission scope enforced through custom middleware.</p>
  </section>

  <!-- FEATURES -->
  <section>
    <div class="section-label">Features</div>
    <h2>Core Capabilities</h2>
    <div class="cards">
      <div class="card">
        <span class="card-icon">🔐</span>
        <h3>Authentication &amp; RBAC</h3>
        <p>Laravel Breeze scaffolding with email verification and four role levels enforced by custom middleware.</p>
      </div>
      <div class="card">
        <span class="card-icon">📅</span>
        <h3>Reservation System</h3>
        <p>Online and walk-in bookings with real-time availability calendar, date conflict checks, and status tracking.</p>
      </div>
      <div class="card">
        <span class="card-icon">💳</span>
        <h3>Payment Handling</h3>
        <p>Deposit and full payment flows, tracked per reservation with support for multiple payment methods.</p>
      </div>
      <div class="card">
        <span class="card-icon">🎁</span>
        <h3>Loyalty &amp; Promo Codes</h3>
        <p>Points earned on every booking, redeemable for discounts. Hotel admins manage promo codes with validity windows.</p>
      </div>
      <div class="card">
        <span class="card-icon">🔍</span>
        <h3>Search &amp; Filtering</h3>
        <p>Dynamic query builder search by name, location, price range, and room type with paginated results.</p>
      </div>
      <div class="card">
        <span class="card-icon">⭐</span>
        <h3>Reviews &amp; Ratings</h3>
        <p>Only verified guests may review. Average ratings recalculate in real-time and power top-hotel rankings.</p>
      </div>
      <div class="card">
        <span class="card-icon">📊</span>
        <h3>Dashboards &amp; Analytics</h3>
        <p>Chart.js-powered metrics: revenue, bookings, room stats, and ratings for both admin types.</p>
      </div>
      <div class="card">
        <span class="card-icon">✉️</span>
        <h3>Email Notifications</h3>
        <p>SMTP transactional emails for cancellations, account changes, and day-before reservation reminders via scheduler.</p>
      </div>
    </div>
  </section>

  <!-- ROLES -->
  <section>
    <div class="section-label">Access Control</div>
    <h2>User Roles</h2>
    <div class="roles">
      <div class="role-card">
        <span class="role-tag tag-system">System Admin</span>
        <h4>Full Control</h4>
        <ul>
          <li>Create &amp; manage all hotels</li>
          <li>Block / unblock users</li>
          <li>Global analytics dashboard</li>
          <li>Manage all user roles</li>
        </ul>
      </div>
      <div class="role-card">
        <span class="role-tag tag-hotel">Hotel Admin</span>
        <h4>Hotel Scope</h4>
        <ul>
          <li>Manage rooms &amp; room types</li>
          <li>Handle online &amp; walk-in bookings</li>
          <li>Create promo codes</li>
          <li>Hotel-specific dashboard</li>
        </ul>
      </div>
      <div class="role-card">
        <span class="role-tag tag-user">Customer</span>
        <h4>Registered User</h4>
        <ul>
          <li>Make &amp; cancel reservations</li>
          <li>Apply promo codes</li>
          <li>Earn loyalty points</li>
          <li>Submit hotel reviews</li>
        </ul>
      </div>
      <div class="role-card">
        <span class="role-tag tag-guest">Guest</span>
        <h4>Unauthenticated</h4>
        <ul>
          <li>Browse &amp; search hotels</li>
          <li>View ratings &amp; details</li>
          <li>See top-rated hotels</li>
          <li>Register to unlock more</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- TECH STACK -->
  <section>
    <div class="section-label">Technology</div>
    <h2>Tech Stack</h2>
    <div class="stack">
      <div class="stack-item"><span class="stack-dot" style="background:#f05340"></span>Laravel (PHP)</div>
      <div class="stack-item"><span class="stack-dot" style="background:#00adef"></span>MySQL</div>
      <div class="stack-item"><span class="stack-dot" style="background:#38bdf8"></span>Tailwind CSS</div>
      <div class="stack-item"><span class="stack-dot" style="background:#e34c26"></span>Blade Templates</div>
      <div class="stack-item"><span class="stack-dot" style="background:#f7df1e"></span>JavaScript</div>
      <div class="stack-item"><span class="stack-dot" style="background:#ff6384"></span>Chart.js</div>
      <div class="stack-item"><span class="stack-dot" style="background:#a78bfa"></span>Laravel Breeze</div>
      <div class="stack-item"><span class="stack-dot" style="background:#34d399"></span>Mailtrap (Dev)</div>
      <div class="stack-item"><span class="stack-dot" style="background:#fb923c"></span>Laravel Scheduler</div>
    </div>
  </section>

  <!-- DATABASE -->
  <section>
    <div class="section-label">Database</div>
    <h2>Schema Overview</h2>
    <div class="db-grid">
      <div class="db-table">
        <div class="db-table-name">users</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li>name, email, phone</li>
          <li>role (0/1/2)</li>
          <li>loyalty_points</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">hotels</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> user_id</li>
          <li>name, description</li>
          <li>location, email, image</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">room_types</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> hotel_id</li>
          <li>type (unique/hotel)</li>
          <li>capacity, price_per_night</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">rooms</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> hotel_id, room_type_id</li>
          <li>room_number (unique/hotel)</li>
          <li>floor, status</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">reservations</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> user, room, hotel</li>
          <li><span class="key">FK</span> guest?, promo_code?</li>
          <li>check_in, check_out, total</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">payments</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> reservation_id</li>
          <li>amount, method, status</li>
          <li>transaction_date</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">reviews</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> user_id, hotel_id</li>
          <li>comment, rating</li>
        </ul>
      </div>
      <div class="db-table">
        <div class="db-table-name">promo_codes</div>
        <ul>
          <li><span class="key">PK</span> id</li>
          <li><span class="key">FK</span> hotel_id</li>
          <li>code, discount_%</li>
          <li>start_date, end_date</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ROUTES -->
  <section>
    <div class="section-label">API / Routes</div>
    <h2>Web Routes</h2>

    <div class="routes-group">
      <div class="routes-group-title">Public</div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/</span><span class="route-desc">Homepage &amp; top hotels</span></div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/search</span><span class="route-desc">Search hotels</span></div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/hotels/index</span><span class="route-desc">List all hotels</span></div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/hotels/{hotel}/show</span><span class="route-desc">Hotel detail page</span></div>
    </div>

    <div class="routes-group">
      <div class="routes-group-title">Authenticated Users</div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/profile</span><span class="route-desc">Edit profile</span></div>
      <div class="route-row"><span class="method m-patch">PATCH</span><span class="route-path">/profile</span><span class="route-desc">Update profile</span></div>
      <div class="route-row"><span class="method m-delete">DELETE</span><span class="route-path">/profile</span><span class="route-desc">Delete account</span></div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/reservations</span><span class="route-desc">My reservations &amp; points</span></div>
      <div class="route-row"><span class="method m-patch">PATCH</span><span class="route-path">/reservations/{reservation}</span><span class="route-desc">Cancel reservation</span></div>
    </div>

    <div class="routes-group">
      <div class="routes-group-title">Hotel Admin · /hotel-admin/</div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/hotel-admin/dashboard</span><span class="route-desc">Hotel dashboard</span></div>
      <div class="route-row"><span class="method m-post">POST</span><span class="route-path">/hotel-admin/rooms/create</span><span class="route-desc">Create room</span></div>
      <div class="route-row"><span class="method m-put">PUT</span><span class="route-path">/hotel-admin/rooms/{room}/edit</span><span class="route-desc">Update room</span></div>
      <div class="route-row"><span class="method m-post">POST</span><span class="route-path">/hotel-admin/reservations/create</span><span class="route-desc">Walk-in reservation</span></div>
      <div class="route-row"><span class="method m-patch">PATCH</span><span class="route-path">/hotel-admin/promocodes/{code}/activate</span><span class="route-desc">Toggle promo code</span></div>
    </div>

    <div class="routes-group">
      <div class="routes-group-title">System Admin · /admin/</div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/admin/users</span><span class="route-desc">List all users</span></div>
      <div class="route-row"><span class="method m-post">POST</span><span class="route-path">/admin/users/{user}/block</span><span class="route-desc">Block user</span></div>
      <div class="route-row"><span class="method m-post">POST</span><span class="route-path">/admin/hotels/create</span><span class="route-desc">Create hotel</span></div>
      <div class="route-row"><span class="method m-delete">DELETE</span><span class="route-path">/admin/hotels/{hotel}/delete</span><span class="route-desc">Delete hotel</span></div>
      <div class="route-row"><span class="method m-get">GET</span><span class="route-path">/admin/analytics</span><span class="route-desc">System analytics</span></div>
    </div>
  </section>

  <!-- MIDDLEWARE -->
  <section>
    <div class="section-label">Security</div>
    <h2>Middleware Strategy</h2>
    <div class="mw-list">
      <div class="mw-item">
        <span class="mw-name">auth</span>
        <span class="mw-desc">Verifies user session. Redirects unauthenticated requests to the login page.</span>
      </div>
      <div class="mw-item">
        <span class="mw-name">verified</span>
        <span class="mw-desc">Ensures email is confirmed before accessing sensitive features like dashboards and reservations.</span>
      </div>
      <div class="mw-item">
        <span class="mw-name">CheckIfBlocked</span>
        <span class="mw-desc">Prevents blocked users from accessing any part of the application regardless of role.</span>
      </div>
      <div class="mw-item">
        <span class="mw-name">SystemAdminMiddleware</span>
        <span class="mw-desc">Restricts access to system admin routes. Checks role = 1 in the database.</span>
      </div>
      <div class="mw-item">
        <span class="mw-name">HotelAdminMiddleware</span>
        <span class="mw-desc">Restricts access to hotel admin routes. Checks role = 2 in the database.</span>
      </div>
    </div>
    <p style="margin-top:1rem; font-size:13px;">Layers run in order: <strong style="color:#fff">auth → verified → block check → role authorization</strong></p>
  </section>

  <!-- TIMELINE -->
  <section>
    <div class="section-label">Development</div>
    <h2>Project Timeline</h2>
    <div class="timeline">
      <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-week">Week 1</div>
        <div class="tl-title">Setup &amp; Database Design</div>
        <div class="tl-desc">Laravel project setup, schema design, and all migrations including constraints, foreign keys, and unique indexes.</div>
      </div>
      <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-week">Week 2</div>
        <div class="tl-title">Backend Logic</div>
        <div class="tl-desc">Models, controllers, business logic for reservations, payments, loyalty points, and reviews.</div>
      </div>
      <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-week">Week 3</div>
        <div class="tl-title">Frontend &amp; Integration</div>
        <div class="tl-desc">Blade layouts, Tailwind CSS, reusable components (modals, cards, popups), reservation calendar, and Chart.js dashboards.</div>
      </div>
      <div class="tl-item">
        <div class="tl-dot"></div>
        <div class="tl-week">Week 4</div>
        <div class="tl-title">Testing &amp; Deployment</div>
        <div class="tl-desc">Unit, feature, and end-to-end testing. Bug fixes, query optimization, and production preparation.</div>
      </div>
    </div>
  </section>

  <!-- GETTING STARTED -->
  <section>
    <div class="section-label">Setup</div>
    <h2>Getting Started</h2>
    <div class="code-block">
      <div class="code-header">
        <div class="code-dots"><span class="r"></span><span class="y"></span><span class="g"></span></div>
        <span class="code-title">bash</span>
      </div>
      <pre><span class="comment"># Clone the repository</span>
<span class="cmd">git clone</span> https://github.com/your-username/hotelgo.git
<span class="cmd">cd</span> hotelgo

<span class="comment"># Install dependencies</span>
<span class="cmd">composer install</span>
<span class="cmd">npm install && npm run build</span>

<span class="comment"># Configure environment</span>
<span class="cmd">cp</span> .env.example .env
<span class="cmd">php artisan key:generate</span>

<span class="comment"># Run migrations</span>
<span class="cmd">php artisan migrate</span>

<span class="comment"># Start the development server</span>
<span class="cmd">php artisan serve</span></pre>
    </div>
    <p style="margin-top:1rem; font-size:13px;">📧 Add your <strong style="color:#fff">Mailtrap</strong> credentials to <code style="font-family:'DM Mono',monospace; color:var(--gold); font-size:12px;">.env</code> to test email notifications locally.</p>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-logo">HotelGo.</div>
    <p>Academic project · All rights reserved by Fatima JANNOUN &amp; Hadi CHEBBO</p>
  </footer>

</div>
</body>
</html>
