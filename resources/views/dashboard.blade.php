<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ড্যাশবোর্ড - খেয়াল</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700;800&family=Noto+Serif+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =========================================================
           GLOBAL
        ========================================================= */
        :root {
            --navy-950: #071222;
            --navy-900: #0b1830;
            --navy-800: #10233f;
            --navy-700: #183458;

            --coral: #ff7168;
            --coral-dark: #ef5f59;
            --coral-soft: #fff0ee;

            --ink: #18263b;
            --muted: #738198;

            --surface: rgba(255, 255, 255, 0.88);
            --surface-strong: #ffffff;

            --line: rgba(212, 221, 232, 0.85);

            --success: #3f9b88;
            --success-soft: #e8f6f2;

            --warning: #e9972c;
            --warning-soft: #fff4e5;

            --danger: #ef5f59;
            --danger-soft: #fff0f0;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif !important;
            color: var(--ink);
            background:
                radial-gradient(circle at 86% 8%, rgba(255, 113, 104, 0.12), transparent 24%),
                radial-gradient(circle at 42% 100%, rgba(68, 96, 137, 0.08), transparent 30%),
                linear-gradient(180deg, #f7f9fc 0%, #edf2f8 100%);
        }

        button,
        input,
        select,
        textarea {
            font-family: 'Noto Sans Bengali', sans-serif !important;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        h1, h2, h3, h4, h5, h6, p {
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        .icon {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* =========================================================
           APP WRAPPER
        ========================================================= */
        .app-layout {
            width: 100%;
            height: 100dvh;
            display: flex;
            overflow: hidden;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */
        .app-sidebar {
            width: 268px;
            height: 100dvh;
            flex: 0 0 268px;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 100;
            overflow: hidden;
            background:
                radial-gradient(circle at 100% 0%, rgba(255, 113, 104, 0.18), transparent 28%),
                radial-gradient(circle at 0% 100%, rgba(67, 94, 140, 0.15), transparent 30%),
                linear-gradient(180deg, #101e38 0%, #071325 100%);
            box-shadow: 12px 0 40px rgba(7, 19, 37, 0.18);
        }

        .app-sidebar::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.10), rgba(255, 255, 255, 0.02));
            pointer-events: none;
        }

        /* =========================================================
           BRAND
        ========================================================= */
        .brand-area {
            height: 72px;
            flex: 0 0 72px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .sidebar-logo {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .banano-logo {
            max-width: 220px;
            max-height: 70px;
            width: auto;
            height: auto;
            display: block;
            object-fit: contain;
            object-position: left center;
        }

        /* =========================================================
           SIDEBAR NAV
        ========================================================= */
        .sidebar-nav {
            flex: 1;
            min-height: 0;
            padding: 16px 12px;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-section {
            margin-top: 6px;
        }

        .sidebar-section:first-child {
            margin-top: 0;
        }

        .nav-section-header {
            width: 100%;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.45);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-align: left;
        }

        .nav-section-header:hover {
            background: rgba(255, 255, 255, 0.045);
            color: rgba(255, 255, 255, 0.65);
        }

        .nav-section-title {
            text-transform: uppercase;
        }

        .nav-section-arrow {
            width: 14px;
            height: 14px;
            transition: transform 0.25s ease;
        }

        .sidebar-section.collapsed .nav-section-arrow {
            transform: rotate(-90deg);
        }

        .nav-section-content {
            display: grid;
            grid-template-rows: 1fr;
            opacity: 1;
            transition: grid-template-rows 0.25s ease, opacity 0.2s ease;
        }

        .nav-section-content-inner {
            min-height: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .sidebar-section.collapsed .nav-section-content {
            grid-template-rows: 0fr;
            opacity: 0;
        }

        /* =========================================================
           SIDEBAR ITEM
        ========================================================= */
        .sidebar-item {
            min-height: 42px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px;
            position: relative;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.65);
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease, background 0.2s ease, transform 0.2s ease;
        }

        .sidebar-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.065);
            transform: translateX(2px);
        }

        .sidebar-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            stroke-width: 2;
        }

        .sidebar-item.active {
            color: #ffffff;
            font-weight: 700;
            background: linear-gradient(90deg, rgba(255, 111, 104, 0.24), rgba(255, 255, 255, 0.06));
            border: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
        }

        .sidebar-item.active::before {
            content: "";
            position: absolute;
            left: -1px;
            width: 4px;
            height: 22px;
            border-radius: 0 8px 8px 0;
            background: var(--coral);
            box-shadow: 0 0 16px rgba(255, 111, 103, 0.55);
        }

        .sidebar-item.active svg {
            color: #ff887f;
        }

        /* =========================================================
           MAIN SHELL
        ========================================================= */
        .dashboard-shell {
            height: 100dvh;
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* =========================================================
           TOPBAR
        ========================================================= */
        .topbar {
            height: 72px;
            flex: 0 0 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            background: rgba(248, 250, 253, 0.78);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(211, 220, 232, 0.70);
            position: relative;
            z-index: 50;
        }

        .topbar::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 113, 104, 0.15), transparent);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title {
            color: #1d2b40;
            font-size: 20px;
            font-weight: 800;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-action {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border: 1px solid rgba(219, 226, 235, 0.9);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.85);
            color: #3c4b61;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
            transition: 0.2s ease;
        }

        .top-action:hover {
            color: var(--coral);
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 9px 20px rgba(15, 23, 42, 0.08);
        }

        .notification-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--coral-dark);
            color: #ffffff;
            border: 2px solid #f8fafc;
            font-size: 9px;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(239, 95, 89, 0.28);
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 6px;
            cursor: pointer;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
            background: linear-gradient(145deg, #456083, #1d2f49);
            box-shadow: 0 6px 14px rgba(30, 47, 73, 0.15);
        }

        .profile-name {
            color: #263247;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.2;
        }

        .profile-role {
            margin-top: 2px;
            color: #8793a4;
            font-size: 11px;
            line-height: 1;
        }

        .profile-arrow {
            width: 16px;
            height: 16px;
            color: #738095;
        }

        /* =========================================================
           MOBILE MENU
        ========================================================= */
        .mobile-menu-button {
            display: none;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid #dde5ee;
            border-radius: 11px;
            background: #ffffff;
            color: #2f3d55;
            cursor: pointer;
        }

        /* =========================================================
           MAIN SCROLL AREA
        ========================================================= */
        .dashboard-content {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 26px 32px 24px;
            scrollbar-width: thin;
            scrollbar-color: rgba(100, 116, 139, 0.28) transparent;
        }

        .dashboard-content::-webkit-scrollbar {
            width: 6px;
        }

        .dashboard-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .dashboard-content::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.25);
            border-radius: 999px;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1480px;
            margin: 0 auto;
        }

        /* =========================================================
           WELCOME
        ========================================================= */
        .welcome-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 2px 0;
        }

        .welcome-title {
            color: #1d2b40;
            font-size: clamp(24px, 2vw, 30px);
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.25;
        }

        .welcome-subtitle {
            margin-top: 4px;
            color: #77859a;
            font-size: 13px;
        }

        .date-card {
            height: 42px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 248, 247, 0.90));
            border: 1px solid rgba(232, 218, 216, 0.85);
            color: #526176;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.03);
        }

        .date-card svg {
            width: 18px;
            height: 18px;
            color: var(--coral);
        }

        /* =========================================================
           STATS
        ========================================================= */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card {
            min-height: 110px;
            padding: 16px;
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(249, 251, 254, 0.88));
            border: 1px solid rgba(220, 227, 236, 0.9);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 110px;
            height: 110px;
            right: -55px;
            bottom: -65px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 113, 104, 0.08), transparent 70%);
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.07);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            color: #7b8799;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-value {
            margin-top: 6px;
            color: #1e2b41;
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
        }

        .stat-meta {
            margin-top: 6px;
            color: #8793a3;
            font-size: 11px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.65);
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
        }

        .icon-patient {
            background: linear-gradient(145deg, #edf1fa, #e5eaf5);
            color: #4e618b;
        }

        .icon-medicine {
            background: linear-gradient(145deg, #fff3f1, #ffe8e5);
            color: #f0645d;
        }

        .icon-success {
            background: linear-gradient(145deg, #edf9f6, #dff2ed);
            color: #3f9b88;
        }

        .icon-warning {
            background: linear-gradient(145deg, #fff8ec, #ffefd7);
            color: #e9972c;
        }

        .icon-sos {
            background: linear-gradient(145deg, #fff2f2, #ffe4e4);
            color: #ef5b5b;
            font-size: 11px;
            font-weight: 800;
        }

        .success-text {
            color: var(--success);
        }

        .danger-text {
            color: var(--danger);
        }

        /* =========================================================
           SECTION HEADER
        ========================================================= */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .section-title {
            color: #1f2e45;
            font-size: 18px;
            font-weight: 800;
        }

        .section-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #5d6a7d;
            font-size: 12px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .section-link:hover {
            color: var(--coral);
            transform: translateX(2px);
        }

        /* =========================================================
           PATIENT CARD
        ========================================================= */
        .patients-card {
            overflow: hidden;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(220, 227, 236, 0.9);
            box-shadow: 0 6px 22px rgba(15, 23, 42, 0.04);
        }

        .patient-row {
            min-height: 80px;
            display: grid;
            grid-template-columns: minmax(210px, 1.55fr) minmax(100px, 0.8fr) minmax(90px, 0.75fr) minmax(110px, 0.85fr) minmax(80px, 0.6fr) 35px;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            transition: background 0.2s ease;
        }

        .patient-row:hover {
            background: linear-gradient(90deg, rgba(255, 249, 248, 0.9), rgba(249, 251, 254, 0.9));
        }

        .patient-row + .patient-row {
            border-top: 1px solid #edf1f5;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-avatar {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 14px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(145deg, #607da4, #2d496d);
            box-shadow: 0 5px 14px rgba(47, 73, 109, 0.15);
        }

        .patient-avatar.female {
            background: linear-gradient(145deg, #dca38e, #a66c5d);
            box-shadow: 0 5px 14px rgba(166, 108, 93, 0.15);
        }

        .patient-name {
            color: #263247;
            font-size: 15px;
            font-weight: 800;
        }

        .patient-relation {
            margin-top: 2px;
            color: #8a95a5;
            font-size: 12px;
        }

        .patient-label {
            margin-bottom: 4px;
            color: #909aaa;
            font-size: 10px;
            font-weight: 600;
        }

        .status-good,
        .status-medium {
            display: inline-flex;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-good {
            background: #e8f5f1;
            color: #409681;
        }

        .status-medium {
            background: #fff3e5;
            color: #dc8825;
        }

        .medicine-count {
            color: #28354b;
            font-size: 17px;
            font-weight: 800;
            line-height: 1;
        }

        .patient-subtext {
            margin-top: 3px;
            color: #8b96a5;
            font-size: 10px;
        }

        .checkin-good,
        .checkin-medium {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        .checkin-good {
            color: #3f9b88;
        }

        .checkin-medium {
            color: #df8c28;
        }

        .checkin-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 800;
        }

        .checkin-icon.good {
            background: #e8f5f1;
        }

        .checkin-icon.medium {
            background: #fff3e5;
        }

        .sos-empty {
            color: #98a2b1;
            font-size: 16px;
        }

        .patient-arrow {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 10px;
            color: #64748b;
            background: transparent;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .patient-arrow:hover {
            color: var(--coral);
            background: #fff1ef;
            transform: translateX(2px);
        }

        /* =========================================================
           MIDDLE GRID
        ========================================================= */
        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
            gap: 18px;
            margin-top: 20px;
        }

        .dashboard-panel {
            padding: 20px;
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 253, 0.88));
            border: 1px solid rgba(220, 227, 236, 0.9);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        }

        .dashboard-panel::before {
            content: "";
            position: absolute;
            top: 0;
            left: 20px;
            width: 48px;
            height: 3px;
            border-radius: 0 0 10px 10px;
            background: linear-gradient(90deg, var(--coral), #ffaaa4);
        }

        .panel-title {
            color: #27344b;
            font-size: 16px;
            font-weight: 800;
        }

        .panel-subtitle {
            margin-top: 2px;
            color: #8b96a5;
            font-size: 11px;
        }

        /* =========================================================
           MEDICINE SUMMARY
        ========================================================= */
        .summary-content {
            min-height: 140px;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-top: 10px;
        }

        .donut {
            width: 120px;
            height: 120px;
            position: relative;
            flex-shrink: 0;
        }

        .donut svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
            filter: drop-shadow(0 4px 8px rgba(63, 155, 136, 0.10));
        }

        .donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .donut-value {
            color: #27344b;
            font-size: 22px;
            font-weight: 800;
        }

        .donut-label {
            margin-top: 1px;
            color: #8b96a5;
            font-size: 10px;
        }

        .summary-legend {
            flex: 1;
        }

        .legend-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 0;
            border-bottom: 1px solid #edf1f5;
            color: #5d697b;
            font-size: 12px;
        }

        .legend-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
        }

        .legend-row strong {
            color: #344056;
        }

        .total-dose {
            margin-top: 8px;
            text-align: right;
            color: #8a95a6;
            font-size: 11px;
        }

        .total-dose strong {
            color: #344056;
        }

        /* =========================================================
           ALERTS
        ========================================================= */
        .alerts-list {
            margin-top: 12px;
            overflow: hidden;
            border: 1px solid #e4e9ef;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.55);
        }

        .alert-row {
            min-height: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            transition: background 0.2s ease;
        }

        .alert-row:hover {
            background: rgba(248, 250, 253, 0.8);
        }

        .alert-row + .alert-row {
            border-top: 1px solid #edf1f5;
        }

        .alert-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 8px;
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08);
        }

        .alert-info {
            flex: 1;
            min-width: 0;
        }

        .alert-title {
            color: #364258;
            font-size: 12px;
            font-weight: 800;
        }

        .alert-description {
            margin-top: 1px;
            color: #8a95a6;
            font-size: 11px;
        }

        .alert-time {
            color: #909aaa;
            font-size: 10px;
            white-space: nowrap;
        }

        .view-alerts {
            width: 100%;
            height: 36px;
            margin-top: 12px;
            border: 1px solid #e0e6ed;
            border-radius: 10px;
            background: rgba(250, 251, 253, 0.9);
            color: #526176;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .view-alerts:hover {
            color: var(--coral);
            background: #fff6f5;
            border-color: #ffd8d4;
        }

        /* =========================================================
           QUICK ACTIONS
        ========================================================= */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 20px;
        }

        .quick-action {
            min-height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px;
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.94), rgba(249, 251, 254, 0.86));
            border: 1px solid rgba(220, 227, 236, 0.9);
            color: #58657a;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.03);
            transition: 0.22s ease;
        }

        .quick-action:hover {
            transform: translateY(-3px);
            border-color: #ffd8d4;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.07);
        }

        .quick-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: transform 0.2s ease;
        }

        .quick-action:hover .quick-icon {
            transform: scale(1.05);
        }

        .quick-icon svg {
            width: 20px;
            height: 20px;
        }

        .quick-icon.scan {
            background: linear-gradient(145deg, #fff3f1, #ffe8e5);
            color: #ef625c;
        }

        .quick-icon.history {
            background: linear-gradient(145deg, #eef2fb, #e3e9f5);
            color: #53678f;
        }

        .quick-icon.appointment {
            background: linear-gradient(145deg, #edf9f5, #dff2eb);
            color: #419985;
        }

        .quick-icon.vital {
            background: linear-gradient(145deg, #fff8ec, #ffeed4);
            color: #e59029;
        }

        .quick-title {
            color: #344056;
            font-size: 12px;
            font-weight: 800;
        }

        .quick-text {
            color: #909aaa;
            font-size: 10px;
            text-align: center;
        }

        /* =========================================================
           HEALTH HISTORY
        ========================================================= */
        .history-panel {
            margin-top: 20px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 253, 0.88));
            border: 1px solid rgba(220, 227, 236, 0.9);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        }

        .history-list {
            margin-top: 14px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .history-item {
            position: relative;
            min-height: 118px;
            padding: 16px;
            overflow: hidden;
            border-radius: 14px;
            background: linear-gradient(145deg, #fbfcfe, #f7f9fc);
            border: 1px solid #e7edf3;
            transition: 0.2s ease;
        }

        .history-item:hover {
            transform: translateY(-3px);
            background: #ffffff;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.05);
        }

        .history-item::after {
            content: "";
            position: absolute;
            width: 70px;
            height: 70px;
            right: -30px;
            bottom: -35px;
            border-radius: 50%;
            background: rgba(255, 113, 104, 0.035);
        }

        .history-type {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .type-treatment {
            color: #3f9b88;
            background: #e8f5f1;
        }

        .type-visit {
            color: #52678e;
            background: #eef1f8;
        }

        .type-admission {
            color: #d77928;
            background: #fff3e5;
        }

        .history-title {
            margin-top: 10px;
            color: #344056;
            font-size: 13px;
            font-weight: 800;
        }

        .history-meta {
            margin-top: 4px;
            color: #8a95a6;
            font-size: 11px;
            line-height: 1.6;
        }

        /* =========================================================
           FOOTER
        ========================================================= */
        .app-footer {
            max-width: 1480px;
            margin: 22px auto 0;
            padding: 16px 2px 12px;
            border-top: 1px solid #dce4ec;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #8d98a8;
            font-size: 11px;
        }

        .footer-brand {
            color: var(--coral);
            font-weight: 800;
        }

        /* =========================================================
           SIDEBAR OVERLAY
        ========================================================= */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 90;
            background: rgba(7, 18, 34, 0.48);
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 1250px) {
            .app-sidebar {
                width: 250px;
                flex-basis: 250px;
            }

            .dashboard-content {
                padding-left: 24px;
                padding-right: 24px;
            }

            .patient-row {
                grid-template-columns: minmax(180px, 1.45fr) minmax(85px, 0.7fr) minmax(75px, 0.65fr) minmax(95px, 0.8fr) minmax(60px, 0.45fr) 32px;
                gap: 10px;
            }
        }

        @media (max-width: 1080px) {
            .stats-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .quick-actions {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .history-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 850px) {
            html, body {
                overflow: hidden;
            }

            .app-layout {
                height: 100dvh;
            }

            .app-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100dvh;
                transform: translateX(-100%);
                transition: transform 0.28s ease;
            }

            .app-sidebar.show {
                transform: translateX(0);
            }

            .dashboard-shell {
                height: 100dvh;
            }

            .mobile-menu-button {
                display: flex;
            }

            .topbar {
                padding: 0 18px;
            }

            .dashboard-content {
                padding: 20px 18px 20px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .patient-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .topbar {
                height: 64px;
                flex-basis: 64px;
            }

            .brand-area {
                height: 64px;
                flex-basis: 64px;
            }

            .topbar-right {
                gap: 8px;
            }

            .profile-details,
            .profile-arrow {
                display: none;
            }

            .welcome-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .date-card {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .stat-card {
                min-height: 100px;
                padding: 14px;
            }

            .stat-value {
                font-size: 24px;
            }

            .patient-row {
                grid-template-columns: 1fr;
            }

            .summary-content {
                gap: 16px;
            }

            .donut {
                width: 110px;
                height: 110px;
            }

            .quick-actions {
                grid-template-columns: 1fr 1fr;
            }

            .app-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }
    </style>
</head>

<body>

<div class="app-layout">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="app-sidebar">

        <!-- BRAND -->
        <div class="brand-area">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Banano" class="banano-logo">
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="sidebar-nav">
            <div class="sidebar-menu">

                <!-- PRIMARY -->
                <div class="sidebar-section">
                    <div class="nav-section-content">
                        <div class="nav-section-content-inner">
                            <a href="#" class="sidebar-item active">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <rect x="3" y="3" width="7" height="7" rx="2" />
                                    <rect x="14" y="3" width="7" height="7" rx="2" />
                                    <rect x="3" y="14" width="7" height="7" rx="2" />
                                    <rect x="14" y="14" width="7" height="7" rx="2" />
                                </svg>
                                <span>ড্যাশবোর্ড</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <circle cx="12" cy="7" r="4" />
                                    <path d="M5.5 21v-1a6.5 6.5 0 0 1 13 0v1" />
                                </svg>
                                <span>আমার রোগী</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TREATMENT -->
                <div class="sidebar-section" data-section>
                    <button class="nav-section-header" type="button">
                        <span class="nav-section-title">চিকিৎসা</span>
                        <svg viewBox="0 0 24 24" class="nav-section-arrow icon">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </button>

                    <div class="nav-section-content">
                        <div class="nav-section-content-inner">
                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                    <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                    <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                    <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                    <path d="M7 12h10" />
                                    <path d="M12 7v10" />
                                </svg>
                                <span>প্রেসক্রিপশন স্ক্যান</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <path d="M14 2v6h6" />
                                    <path d="M8 13h8" />
                                    <path d="M8 17h6" />
                                </svg>
                                <span>প্রেসক্রিপশনসমূহ</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M12 8v4l3 2" />
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M8 3.5V2" />
                                    <path d="M16 3.5V2" />
                                </svg>
                                <span>স্বাস্থ্য ইতিহাস</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <rect x="3" y="4" width="18" height="17" rx="3" />
                                    <path d="M8 2v4" />
                                    <path d="M16 2v4" />
                                    <path d="M3 10h18" />
                                    <path d="M8 15h3" />
                                </svg>
                                <span>ওষুধের সময়সূচী</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M9 11l2 2 4-4" />
                                    <circle cx="12" cy="12" r="9" />
                                </svg>
                                <span>ওষুধ গ্রহণ ট্র্যাকিং</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                    <path d="M10 21h4" />
                                </svg>
                                <span>রিমাইন্ডার</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <rect x="3" y="4" width="18" height="17" rx="3" />
                                    <path d="M8 2v4" />
                                    <path d="M16 2v4" />
                                    <path d="M3 10h18" />
                                    <path d="M8 15h3" />
                                    <path d="M13 15h3" />
                                </svg>
                                <span>অ্যাপয়েন্টমেন্ট</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- MONITORING -->
                <div class="sidebar-section collapsed" data-section>
                    <button class="nav-section-header" type="button">
                        <span class="nav-section-title">পর্যবেক্ষণ</span>
                        <svg viewBox="0 0 24 24" class="nav-section-arrow icon">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </button>

                    <div class="nav-section-content">
                        <div class="nav-section-content-inner">
                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                                <span>চেক-ইন মনিটরিং</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M3 12h4l2-5 4 10 2-5h6" />
                                </svg>
                                <span>ভাইটালস ও স্বাস্থ্য</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path d="M12 8v4" />
                                    <path d="M12 16h.01" />
                                </svg>
                                <span>SOS সতর্কতা</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- OTHERS -->
                <div class="sidebar-section collapsed" data-section>
                    <button class="nav-section-header" type="button">
                        <span class="nav-section-title">অন্যান্য</span>
                        <svg viewBox="0 0 24 24" class="nav-section-arrow icon">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </button>

                    <div class="nav-section-content">
                        <div class="nav-section-content-inner">
                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M4 19V5" />
                                    <path d="M4 19h16" />
                                    <path d="M8 15v-4" />
                                    <path d="M12 15V8" />
                                    <path d="M16 15v-7" />
                                </svg>
                                <span>রিপোর্ট ও পরিসংখ্যান</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <path d="M14 2v6h6" />
                                    <path d="M8 13h8" />
                                    <path d="M8 17h5" />
                                </svg>
                                <span>নোট ও নথি</span>
                            </a>

                            <a href="#" class="sidebar-item">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2 2-.06-.06A1.7 1.7 0 0 0 16 19.4a1.7 1.7 0 0 0-1 1.55V21h-3v-.08A1.7 1.7 0 0 0 11 19.4a1.7 1.7 0 0 0-1.88.34l-.06.06-2-2 .06-.06A1.7 1.7 0 0 0 7.6 16a1.7 1.7 0 0 0-1.55-1H6v-3h.08A1.7 1.7 0 0 0 7.6 11a1.7 1.7 0 0 0-.34-1.88l-.06-.06 2-2 .06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.55V3h3v.08A1.7 1.7 0 0 0 14 4.6a1.7 1.7 0 0 0 1.88-.34l.06-.06 2 2-.06.06A1.7 1.7 0 0 0 16.4 8a1.7 1.7 0 0 0 1.55 1H18v3h-.08A1.7 1.7 0 0 0 16.4 13a1.7 1.7 0 0 0 .34 1.88" />
                                </svg>
                                <span>সেটিংস</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
    </aside>

    <!-- MOBILE OVERLAY -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <!-- MAIN -->
    <div class="dashboard-shell">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button id="mobileMenu" class="mobile-menu-button">
                    <svg viewBox="0 0 24 24" class="icon">
                        <path d="M4 6h16" />
                        <path d="M4 12h16" />
                        <path d="M4 18h16" />
                    </svg>
                </button>

                <h1 class="page-title">ড্যাশবোর্ড</h1>
            </div>

            <div class="topbar-right">
                <button class="top-action">
                    <svg viewBox="0 0 24 24" class="icon">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                        <path d="M10 21h4" />
                    </svg>
                    <span class="notification-badge">5</span>
                </button>

                <div class="profile-area">
                    <div class="profile-avatar">সা</div>

                    <div class="profile-details">
                        <div class="profile-name">সায়েম আহমেদ</div>
                        <div class="profile-role">কেয়ারগিভার</div>
                    </div>

                    <svg viewBox="0 0 24 24" class="profile-arrow icon">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </div>
            </div>
        </header>

        <!-- SCROLLABLE CONTENT -->
        <main class="dashboard-content">
            <div class="dashboard-container">

                <!-- WELCOME -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">স্বাগতম সায়েম আহমেদ 👋</h2>
                        <p class="welcome-subtitle">আজ আপনার প্রিয়জনদের যত্নের সারাংশ</p>
                    </div>

                    <div class="date-card">
                        <svg viewBox="0 0 24 24" class="icon">
                            <rect x="3" y="4" width="18" height="17" rx="3" />
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <path d="M3 10h18" />
                        </svg>
                        <span>১৫ মে ২০২৬, বুধবার</span>
                    </div>
                </section>

                <!-- STATS -->
                <section class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">মোট রোগী</div>
                                <div class="stat-value">২</div>
                                <div class="stat-meta">সক্রিয়</div>
                            </div>
                            <div class="stat-icon icon-patient">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M2 21v-1a6 6 0 0 1 12 0v1" />
                                    <path d="M16 11a4 4 0 1 0 0-8" />
                                    <path d="M22 21v-1a6 6 0 0 0-4-5.65" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">আজকের ওষুধ</div>
                                <div class="stat-value">৮</div>
                                <div class="stat-meta">মোট ডোজ</div>
                            </div>
                            <div class="stat-icon icon-medicine">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M10.5 3.5a5 5 0 0 1 7 7l-7 7a5 5 0 0 1-7-7z" />
                                    <path d="M7 7l10 10" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">সময়ে নেওয়া</div>
                                <div class="stat-value">৬</div>
                                <div class="stat-meta success-text">৭৫%</div>
                            </div>
                            <div class="stat-icon icon-success">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M5 12l4 4L19 6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">মিসড ডোজ</div>
                                <div class="stat-value">২</div>
                                <div class="stat-meta danger-text">২৫%</div>
                            </div>
                            <div class="stat-icon icon-warning">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">SOS সতর্কতা</div>
                                <div class="stat-value">১</div>
                                <div class="stat-meta">আজ</div>
                            </div>
                            <div class="stat-icon icon-sos">SOS</div>
                        </div>
                    </div>
                </section>

                <!-- PATIENTS -->
                <section>
                    <div class="section-header">
                        <h3 class="section-title">আমার রোগীদের অবস্থা</h3>
                        <a href="#" class="section-link">সব দেখুন →</a>
                    </div>

                    <div class="patients-card">

                        <!-- PATIENT 1 -->
                        <div class="patient-row">
                            <div class="patient-info">
                                <div class="patient-avatar">আ</div>
                                <div>
                                    <div class="patient-name">আব্দুল করিম</div>
                                    <div class="patient-relation">বাবা • ৭২ বছর</div>
                                </div>
                            </div>

                            <div>
                                <div class="patient-label">আজকের অবস্থা</div>
                                <span class="status-good">ভালো</span>
                            </div>

                            <div>
                                <div class="patient-label">ওষুধ</div>
                                <div class="medicine-count">৪/৫</div>
                                <div class="patient-subtext">ডোজ সম্পন্ন</div>
                            </div>

                            <div>
                                <div class="patient-label">চেক-ইন</div>
                                <div class="checkin-good">
                                    <span class="checkin-icon good">✓</span>
                                    সকাল ৯:০০
                                </div>
                            </div>

                            <div>
                                <div class="patient-label">শেষ SOS</div>
                                <div class="sos-empty">–</div>
                            </div>

                            <button class="patient-arrow">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </button>
                        </div>

                        <!-- PATIENT 2 -->
                        <div class="patient-row">
                            <div class="patient-info">
                                <div class="patient-avatar female">র</div>
                                <div>
                                    <div class="patient-name">রোকেয়া বেগম</div>
                                    <div class="patient-relation">মা • ৬৭ বছর</div>
                                </div>
                            </div>

                            <div>
                                <div class="patient-label">আজকের অবস্থা</div>
                                <span class="status-medium">মাঝারি</span>
                            </div>

                            <div>
                                <div class="patient-label">ওষুধ</div>
                                <div class="medicine-count">২/৩</div>
                                <div class="patient-subtext">ডোজ সম্পন্ন</div>
                            </div>

                            <div>
                                <div class="patient-label">চেক-ইন</div>
                                <div class="checkin-medium">
                                    <span class="checkin-icon medium">!</span>
                                    গতকাল
                                </div>
                            </div>

                            <div>
                                <div class="patient-label">শেষ SOS</div>
                                <div class="sos-empty">–</div>
                            </div>

                            <button class="patient-arrow">
                                <svg viewBox="0 0 24 24" class="icon">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </section>

                <!-- MIDDLE GRID -->
                <section class="dashboard-grid">

                    <!-- MEDICINE SUMMARY -->
                    <div class="dashboard-panel">
                        <h3 class="panel-title">ওষুধ গ্রহণের সারাংশ</h3>
                        <p class="panel-subtitle">এই মাস</p>

                        <div class="summary-content">
                            <div class="donut">
                                <svg viewBox="0 0 120 120">
                                    <circle cx="60" cy="60" r="47" fill="none" stroke="#edf1f5" stroke-width="10" />
                                    <circle cx="60" cy="60" r="47" fill="none" stroke="#48a18d" stroke-width="10" stroke-linecap="round" stroke-dasharray="295" stroke-dashoffset="38" />
                                </svg>
                                <div class="donut-center">
                                    <div class="donut-value">৮৭%</div>
                                    <div class="donut-label">সম্পন্ন</div>
                                </div>
                            </div>

                            <div class="summary-legend">
                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background:#48a18d"></span>
                                        সময়ে নেওয়া
                                    </div>
                                    <strong>৭৮%</strong>
                                </div>

                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background:#e9972c"></span>
                                        দেরিতে নেওয়া
                                    </div>
                                    <strong>৯%</strong>
                                </div>

                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background:#ef625c"></span>
                                        মিসড
                                    </div>
                                    <strong>১৩%</strong>
                                </div>

                                <div class="total-dose">
                                    মোট ডোজ: <strong>১২০</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ALERTS -->
                    <div class="dashboard-panel">
                        <h3 class="panel-title">সাম্প্রতিক সতর্কতা</h3>
                        <p class="panel-subtitle">সর্বশেষ আপডেট</p>

                        <div class="alerts-list">
                            <div class="alert-row">
                                <div class="alert-icon" style="background:#ef625c">SOS</div>
                                <div class="alert-info">
                                    <div class="alert-title">SOS সতর্কতা</div>
                                    <div class="alert-description">আব্দুল করিম</div>
                                </div>
                                <div class="alert-time">আজ, ১০:১৫</div>
                            </div>

                            <div class="alert-row">
                                <div class="alert-icon" style="background:#e9972c">✓</div>
                                <div class="alert-info">
                                    <div class="alert-title">চেক-ইন মিসড</div>
                                    <div class="alert-description">রোকেয়া বেগম</div>
                                </div>
                                <div class="alert-time">গতকাল</div>
                            </div>

                            <div class="alert-row">
                                <div class="alert-icon" style="background:#d85b74">Rx</div>
                                <div class="alert-info">
                                    <div class="alert-title">ওষুধ মিসড</div>
                                    <div class="alert-description">আব্দুল করিম – দুপুরের ডোজ</div>
                                </div>
                                <div class="alert-time">আজ, ১:০০</div>
                            </div>
                        </div>

                        <button class="view-alerts">সব সতর্কতা দেখুন</button>
                    </div>

                </section>

                <!-- QUICK ACTIONS -->
                <section class="quick-actions">
                    <div class="quick-action">
                        <div class="quick-icon scan">
                            <svg viewBox="0 0 24 24" class="icon">
                                <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                <path d="M7 12h10" />
                                <path d="M12 7v10" />
                            </svg>
                        </div>
                        <div class="quick-title">প্রেসক্রিপশন স্ক্যান</div>
                        <div class="quick-text">ওষুধ স্বয়ংক্রিয়ভাবে পড়ুন</div>
                    </div>

                    <div class="quick-action">
                        <div class="quick-icon history">
                            <svg viewBox="0 0 24 24" class="icon">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 2" />
                            </svg>
                        </div>
                        <div class="quick-title">স্বাস্থ্য ইতিহাস</div>
                        <div class="quick-text">আগের চিকিৎসা ও ডাক্তার</div>
                    </div>

                    <div class="quick-action">
                        <div class="quick-icon appointment">
                            <svg viewBox="0 0 24 24" class="icon">
                                <rect x="3" y="4" width="18" height="17" rx="3" />
                                <path d="M8 2v4" />
                                <path d="M16 2v4" />
                                <path d="M3 10h18" />
                            </svg>
                        </div>
                        <div class="quick-title">অ্যাপয়েন্টমেন্ট</div>
                        <div class="quick-text">ডাক্তারের সময় নির্ধারণ</div>
                    </div>

                    <div class="quick-action">
                        <div class="quick-icon vital">
                            <svg viewBox="0 0 24 24" class="icon">
                                <path d="M3 12h4l2-5 4 10 2-5h6" />
                            </svg>
                        </div>
                        <div class="quick-title">ভাইটালস রেকর্ড</div>
                        <div class="quick-text">চাপ, সুগার ও অন্যান্য তথ্য</div>
                    </div>
                </section>

                <!-- HEALTH HISTORY PANEL -->
                <section class="history-panel">
                    <div class="section-header">
                        <div>
                            <h3 class="section-title">সাম্প্রতিক চিকিৎসা ইতিহাস</h3>
                            <p class="panel-subtitle">বিভিন্ন ডাক্তার ও হাসপাতালের পূর্ববর্তী রেকর্ড</p>
                        </div>
                        <a href="#" class="section-link">সম্পূর্ণ ইতিহাস →</a>
                    </div>

                    <div class="history-list">
                        <div class="history-item">
                            <span class="history-type type-visit">চিকিৎসক পরিদর্শন</span>
                            <div class="history-title">ডা. মোহাম্মদ রাহিম</div>
                            <div class="history-meta">
                                ১২ মে ২০২৬<br>
                                পপুলার মেডিকেল কলেজ হাসপাতাল<br>
                                উচ্চ রক্তচাপের চিকিৎসা
                            </div>
                        </div>

                        <div class="history-item">
                            <span class="history-type type-treatment">চিকিৎসা</span>
                            <div class="history-title">ডায়াবেটিস ফলো-আপ</div>
                            <div class="history-meta">
                                ০৫ মে ২০২৬<br>
                                ডা. শারমিন আক্তার<br>
                                নতুন ওষুধ ও ডোজ পরিবর্তন
                            </div>
                        </div>

                        <div class="history-item">
                            <span class="history-type type-admission">হাসপাতালে ভর্তি</span>
                            <div class="history-title">বক্ষব্যথা ও পর্যবেক্ষণ</div>
                            <div class="history-meta">
                                ১৮ মার্চ ২০২৬<br>
                                ঢাকা মেডিকেল কলেজ হাসপাতাল<br>
                                ভর্তি: ২ দিন
                            </div>
                        </div>
                    </div>
                </section>

                <!-- FOOTER -->
                <footer class="app-footer">
                    <div>খেয়াল v1.0.0</div>
                    <div>
                        © 2026
                        <span class="footer-brand">Kheyal</span>
                        • দূরে থেকেও খেয়াল
                    </div>
                </footer>

            </div>
        </main>

    </div>

</div>

<!-- JAVASCRIPT -->
<script>
    const mobileMenu = document.getElementById('mobileMenu');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('show');
        sidebarOverlay.classList.add('show');
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
    }

    mobileMenu?.addEventListener('click', () => {
        if (sidebar.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    sidebarOverlay?.addEventListener('click', closeSidebar);

    document.querySelectorAll('.nav-section-header').forEach((header) => {
        header.addEventListener('click', () => {
            const section = header.closest('.sidebar-section');
            section.classList.toggle('collapsed');
        });
    });

    document.querySelectorAll('.sidebar-item').forEach((item) => {
        item.addEventListener('click', () => {
            if (window.innerWidth <= 850) {
                closeSidebar();
            }
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 850) {
            closeSidebar();
        }
    });
</script>

</body>
</html>