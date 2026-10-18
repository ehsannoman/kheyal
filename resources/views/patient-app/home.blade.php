<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    >

    <title>খেয়াল — {{ $token }}</title>

    <link rel="manifest" href="/patient/{{ $token }}/manifest.json">

    <meta name="theme-color" content="#0f1b3d">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        /* =========================================================
           KHEYAL PATIENT PWA
           Midnight Blue + Coral
           Elder-friendly mobile interface
           ========================================================= */

        :root {
            --navy: #0f1b3d;
            --navy-dark: #0a1430;
            --navy-soft: #172554;

            --coral: #ff5c5c;
            --coral-dark: #e94b4b;
            --coral-soft: #fff1ef;

            --white: #ffffff;
            --bg: #f6f8fb;
            --surface: #ffffff;

            --text: #172033;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --border: #e5e9f0;
            --border-soft: #edf0f4;

            --green: #299879;
            --green-soft: #eaf7f3;

            --orange: #d99024;
            --orange-soft: #fff6e8;

            --red: #df4d4d;
            --red-soft: #fff0f0;

            --blue: #3b82f6;
            --blue-soft: #eff6ff;

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 18px;

            --shadow-sm: 0 2px 8px rgba(15, 27, 61, 0.05);
            --shadow-md: 0 8px 22px rgba(15, 27, 61, 0.08);
        }


        /* =========================================================
           RESET
           ========================================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;

            background: var(--bg);
            color: var(--text);

            font-family: 'Hind Siliguri', sans-serif;

            font-size: 18px;
            line-height: 1.55;

            -webkit-font-smoothing: antialiased;

            padding-bottom: 28px;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a {
            color: inherit;
            text-decoration: none;
        }


        /* =========================================================
           APP
           ========================================================= */

        .patient-app {
            width: 100%;
            min-height: 100vh;
        }

        .page-container {
            width: min(100%, 520px);
            margin: 0 auto;
            padding: 0 16px 28px;
        }


        /* =========================================================
           TOP HEADER
           ========================================================= */

        .patient-header {
            background: var(--navy);
            color: var(--white);

            padding:
                max(18px, env(safe-area-inset-top))
                18px
                22px;
        }

        .header-inner {
            width: min(100%, 520px);
            margin: 0 auto;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
        }
        .brand-logo {
            width: 165px;
            height: auto;

            display: block;

            object-fit: contain;
        }


        .notification-button {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(255, 255, 255, 0.10);

            border-radius: 10px;

            color: #fff;

            font-size: 16px;
        }

        .notification-button:active {
            background: rgba(255, 255, 255, 0.14);
        }

        .brand-mark {
            overflow: hidden;
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            display: none;
            align-items: center;
            justify-content: center;
            background: var(--coral);
            border: 2px solid var(--navy);
            border-radius: 999px;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            line-height: 1;
        }

        .notification-wrap {
            position: relative;
        }


        /* =========================================================
           PATIENT GREETING
           ========================================================= */

        .patient-greeting {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 14px;
        }

        .greeting-small {
            color: rgba(255, 255, 255, 0.68);

            font-size: 15px;
            margin-bottom: 2px;
        }

        .patient-name {
            margin: 0;

            color: #fff;

            font-family: 'Noto Serif Bengali', serif;

            font-size: 28px;
            font-weight: 700;

            line-height: 1.25;
        }

        .today-date {
            margin-top: 4px;

            color: rgba(255, 255, 255, 0.65);

            font-size: 14px;
        }

        .patient-avatar {
            width: 56px;
            height: 56px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff;

            border-radius: 50%;

            color: var(--navy);

            font-size: 22px;
        }


        /* =========================================================
           CONTENT
           ========================================================= */

        .content {
            padding-top: 18px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin: 0 2px 10px;
        }

        .section-title {
            margin: 0;

            color: var(--navy);

            font-family: 'Noto Serif Bengali', serif;

            font-size: 20px;
            font-weight: 700;
        }

        .section-link {
            color: var(--coral-dark);

            font-size: 14px;
            font-weight: 600;
        }


        /* =========================================================
           TODAY'S MEDICINE HERO
           ========================================================= */

        .medicine-hero {
            position: relative;

            overflow: hidden;

            background: var(--navy);

            border-radius: var(--radius-lg);

            padding: 20px;

            color: #fff;

            box-shadow: var(--shadow-md);
        }

        .medicine-hero::after {
            content: "";

            position: absolute;

            width: 110px;
            height: 110px;

            right: -32px;
            top: -32px;

            border-radius: 50%;

            border: 18px solid rgba(255, 255, 255, 0.045);
        }

        .medicine-hero-top {
            position: relative;
            z-index: 1;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 14px;
        }

        .medicine-hero-label {
            color: rgba(255, 255, 255, 0.70);

            font-size: 14px;
        }

        .medicine-hero-count {
            margin-top: 2px;

            font-family: 'Noto Serif Bengali', serif;

            font-size: 24px;
            font-weight: 700;
        }

        .medicine-hero-icon {
            width: 52px;
            height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.10);

            border: 1px solid rgba(255, 255, 255, 0.12);

            border-radius: 14px;

            color: var(--coral);

            font-size: 22px;
        }

        .medicine-hero-button {
            position: relative;
            z-index: 1;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            margin-top: 17px;

            min-height: 42px;

            padding: 0 17px;

            background: var(--coral);

            border-radius: 9px;

            color: #fff;

            font-size: 15px;
            font-weight: 700;
        }

        .medicine-hero-button:active {
            background: var(--coral-dark);
        }


        /* =========================================================
           QUICK ACTIONS
           ========================================================= */

        .quick-grid {
            display: grid;

            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 12px;
        }

        .quick-card {
            min-height: 112px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            padding: 15px;

            background: var(--surface);

            border: 1px solid var(--border);

            border-radius: var(--radius-md);

            box-shadow: var(--shadow-sm);
        }

        .quick-card:active {
            transform: translateY(1px);
        }

        .quick-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            font-size: 17px;

            margin-bottom: 9px;
        }

        .quick-icon.green {
            background: var(--green-soft);
            color: var(--green);
        }

        .quick-icon.orange {
            background: var(--orange-soft);
            color: var(--orange);
        }

        .quick-icon.coral {
            background: var(--coral-soft);
            color: var(--coral);
        }

        .quick-icon.blue {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .quick-title {
            color: var(--navy);

            font-size: 16px;
            font-weight: 700;
        }

        .quick-description {
            margin-top: 1px;

            color: var(--text-secondary);

            font-size: 12px;
        }


        /* =========================================================
           SOS
           ========================================================= */

        .sos-card {
            display: flex;
            align-items: center;

            gap: 14px;

            width: 100%;

            padding: 15px;

            background: var(--surface);

            border: 1px solid #f2d2d2;

            border-radius: var(--radius-md);

            box-shadow: var(--shadow-sm);

            text-align: left;
        }

        .sos-icon {
            width: 46px;
            height: 46px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--red-soft);

            border-radius: 12px;

            color: var(--red);

            font-size: 19px;
        }

        .sos-content {
            flex: 1;
        }

        .sos-title {
            color: var(--red);

            font-size: 16px;
            font-weight: 700;
        }

        .sos-description {
            margin-top: 1px;

            color: var(--text-secondary);

            font-size: 12px;
        }

        .sos-arrow {
            color: var(--text-muted);
        }


        /* =========================================================
           CARD
           ========================================================= */

        .card {
            background: var(--surface);

            border: 1px solid var(--border);

            border-radius: var(--radius-md);

            box-shadow: var(--shadow-sm);

            overflow: hidden;
        }

        .card-body {
            padding: 16px;
        }


        /* =========================================================
           MEDICINE LIST
           ========================================================= */

        .med-item {
            padding: 15px 0;

            border-bottom: 1px solid var(--border-soft);
        }

        .med-item:first-child {
            padding-top: 4px;
        }

        .med-item:last-child {
            padding-bottom: 2px;
            border-bottom: none;
        }

        .med-main {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .med-icon {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--coral-soft);

            border-radius: 11px;

            color: var(--coral);

            font-size: 17px;
        }

        .med-info {
            flex: 1;
            min-width: 0;
        }

        .med-name {
            color: var(--navy);

            font-size: 17px;
            font-weight: 700;
        }

        .med-time {
            margin-top: 2px;

            color: var(--text-secondary);

            font-size: 13px;
        }

        .med-status {
            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            gap: 5px;

            padding: 5px 8px;

            border-radius: 7px;

            font-size: 11px;
            font-weight: 700;
        }

        .med-status.taken {
            background: var(--green-soft);
            color: var(--green);
        }

        .med-status.missed {
            background: var(--red-soft);
            color: var(--red);
        }

        .med-status.pending {
            background: var(--orange-soft);
            color: var(--orange);
        }

        .med-actions {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 8px;

            margin-top: 11px;
        }

        .med-action {
            min-height: 42px;

            border-radius: 9px;

            border: 1px solid;

            font-size: 14px;
            font-weight: 700;
        }

        .btn-taken {
            background: var(--green-soft);

            border-color: #cce9df;

            color: var(--green);
        }

        .btn-missed {
            background: #fff;

            border-color: #e8caca;

            color: var(--red);
        }

        .med-action:disabled {
            opacity: 0.55;
        }


        /* =========================================================
           CHECK-IN
           ========================================================= */

        .checkin-buttons {
            display: grid;

            grid-template-columns: 1fr;

            gap: 9px;
        }

        .checkin-button {
            min-height: 50px;

            display: flex;
            align-items: center;

            gap: 11px;

            padding: 0 13px;

            background: #fff;

            border: 1px solid var(--border);

            border-radius: 10px;

            color: var(--navy);

            text-align: left;

            font-size: 15px;
            font-weight: 600;
        }

        .checkin-icon {
            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            font-size: 13px;
        }

        .checkin-button.fine .checkin-icon {
            background: var(--green-soft);
            color: var(--green);
        }

        .checkin-button.not-well .checkin-icon {
            background: var(--orange-soft);
            color: var(--orange);
        }

        .checkin-button.need-help .checkin-icon {
            background: var(--red-soft);
            color: var(--red);
        }

        .checkin-done {
            padding: 5px 0;

            text-align: center;
        }

        .checkin-done-icon {
            width: 44px;
            height: 44px;

            margin: 0 auto 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--green-soft);

            border-radius: 50%;

            color: var(--green);
        }

        .checkin-done-title {
            color: var(--navy);

            font-size: 16px;
            font-weight: 700;
        }

        .checkin-done-text {
            margin-top: 2px;

            color: var(--text-secondary);

            font-size: 13px;
        }


        /* =========================================================
           APPOINTMENT / DOCTOR REMINDER
           ========================================================= */

        .appointment-item {
            padding: 14px 0;

            border-bottom: 1px solid var(--border-soft);
        }

        .appointment-item:first-child {
            padding-top: 3px;
        }

        .appointment-item:last-child {
            padding-bottom: 2px;
            border-bottom: none;
        }

        .appointment-top {
            display: flex;
            align-items: flex-start;

            gap: 11px;
        }

        .doctor-icon {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--blue-soft);

            border-radius: 11px;

            color: var(--blue);

            font-size: 17px;
        }

        .appointment-info {
            flex: 1;
            min-width: 0;
        }

        .appointment-doctor {
            color: var(--navy);

            font-size: 16px;
            font-weight: 700;
        }

        .appointment-time {
            margin-top: 2px;

            color: var(--text-secondary);

            font-size: 13px;
        }

        .appointment-location {
            margin-top: 3px;

            color: var(--text-muted);

            font-size: 12px;
        }

        .appointment-badge {
            margin-top: 9px;

            display: inline-flex;
            align-items: center;
            gap: 5px;

            padding: 4px 8px;

            background: var(--blue-soft);

            border-radius: 6px;

            color: var(--blue);

            font-size: 11px;
            font-weight: 700;
        }


        /* =========================================================
           CAREGIVER CONTACT
           ========================================================= */

        .contact-card {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 15px;
        }

        .contact-icon {
            width: 44px;
            height: 44px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--navy);

            border-radius: 11px;

            color: #fff;

            font-size: 17px;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-label {
            color: var(--text-muted);

            font-size: 12px;
        }

        .contact-name {
            margin-top: 1px;

            color: var(--navy);

            font-size: 16px;
            font-weight: 700;
        }

        .contact-number {
            color: var(--text-secondary);

            font-size: 13px;
        }

        .call-button {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--green);

            border-radius: 10px;

            color: #fff;

            font-size: 15px;
        }


        .medicine-hero-main {
            min-width: 0;
        }

        .medicine-hero-sub {
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.68);
            font-size: 14px;
        }

        .medicine-hero-actions {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 8px;
            margin-top: 14px;
        }

        .medicine-hero-actions:empty {
            display: none;
        }

        .medicine-hero-action {
            flex: 1;
            min-height: 44px;
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 9px;
            font-size: 14px;
            font-weight: 700;
        }

        .medicine-hero-action.taken {
            background: var(--coral);
            color: #fff;
            border-color: var(--coral);
        }

        .medicine-hero-action.missed {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .medicine-hero-button.secondary {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
        }

        .medicine-hero.overdue {
            background: #3a1830;
        }

        .medicine-hero.done {
            background: var(--navy);
        }

        .medicine-hero-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 7px;
            padding: 4px 8px;
            border-radius: 7px;
            background: rgba(255,255,255,0.09);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
        }

        .appointment-ack {
            width: 100%;
            min-height: 44px;
            margin-top: 11px;
            border: 0;
            border-radius: 9px;
            background: var(--green);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
        }

        .appointment-ack:disabled {
            opacity: 0.55;
        }

        .appointment-stopped {
            margin-top: 10px;
            color: var(--green);
            font-size: 13px;
            font-weight: 700;
        }

        .contact-card {
            min-height: 78px;
            cursor: pointer;
        }

        .contact-card:active {
            transform: translateY(1px);
        }

        .notification-panel {
            position: fixed;
            inset: 0;
            z-index: 1200;
            display: none;
            background: rgba(15,27,61,0.42);
            padding: max(12px, env(safe-area-inset-top)) 12px 12px;
        }

        .notification-panel.open {
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .notification-sheet {
            width: min(100%, 520px);
            max-height: min(82vh, 680px);
            margin-top: 48px;
            overflow: hidden;
            background: var(--surface);
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(15,27,61,0.25);
        }

        .notification-sheet-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }

        .notification-sheet-title {
            margin: 0;
            color: var(--navy);
            font-family: 'Noto Serif Bengali', serif;
            font-size: 20px;
            font-weight: 700;
        }

        .notification-close {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 10px;
            background: var(--bg);
            color: var(--navy);
        }

        .notification-list {
            max-height: calc(min(82vh, 680px) - 74px);
            overflow-y: auto;
            padding: 8px 14px 14px;
        }

        .notification-item {
            display: flex;
            gap: 11px;
            padding: 13px 4px;
            border-bottom: 1px solid var(--border-soft);
        }

        .notification-item:last-child {
            border-bottom: 0;
        }

        .notification-item-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: var(--coral-soft);
            color: var(--coral);
        }

        .notification-item-content {
            min-width: 0;
            flex: 1;
        }

        .notification-item-title {
            color: var(--navy);
            font-size: 14px;
            font-weight: 700;
        }

        .notification-item-body {
            margin-top: 2px;
            color: var(--text-secondary);
            font-size: 13px;
            line-height: 1.45;
        }

        .notification-item-time {
            margin-top: 3px;
            color: var(--text-muted);
            font-size: 11px;
        }

        .notification-empty {
            padding: 42px 16px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .notification-clear {
            margin-top: 10px;
            padding: 8px 0;
            background: transparent;
            border: 0;
            color: var(--coral-dark);
            font-size: 12px;
            font-weight: 700;
        }

        /* =========================================================
           EMPTY / LOADING
           ========================================================= */

        .empty-state {
            padding: 22px 10px;

            text-align: center;
        }

        .empty-icon {
            width: 42px;
            height: 42px;

            margin: 0 auto 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--bg);

            border-radius: 10px;

            color: var(--text-muted);

            font-size: 17px;
        }

        .empty-text {
            color: var(--text-secondary);

            font-size: 14px;
        }


        /* =========================================================
           TOAST
           ========================================================= */

        .toast {
            position: fixed;

            left: 16px;
            right: 16px;

            bottom: 20px;

            width: auto;
            max-width: 480px;

            margin: 0 auto;

            display: none;

            padding: 13px 16px;

            background: var(--navy);

            border-radius: 10px;

            color: #fff;

            font-size: 14px;
            font-weight: 600;

            text-align: center;

            box-shadow: 0 10px 30px rgba(15, 27, 61, 0.18);

            z-index: 1000;
        }


        /* =========================================================
           BOTTOM NAVIGATION
           ========================================================= */

        .bottom-nav {
            position: fixed;

            left: 0;
            right: 0;
            bottom: 0;

            z-index: 900;

            background: rgba(255, 255, 255, 0.97);

            border-top: 1px solid var(--border);

            padding:
                7px
                max(10px, env(safe-area-inset-right))
                max(7px, env(safe-area-inset-bottom))
                max(10px, env(safe-area-inset-left));

            display: grid;

            grid-template-columns: repeat(3, 1fr);
        }

        .bottom-nav-item {
            min-height: 50px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            gap: 3px;

            color: var(--text-muted);

            font-size: 11px;
            font-weight: 600;
        }

        .bottom-nav-item i {
            font-size: 17px;
        }

        .bottom-nav-item.active {
            color: var(--navy);
        }

        .bottom-nav-item.sos {
            color: var(--red);
        }


        /* =========================================================
           DESKTOP / TABLET
           ========================================================= */

        @media (min-width: 700px) {

            body {
                padding-bottom: 30px;
            }

            .patient-header {
                padding-top: 26px;
                padding-bottom: 26px;
            }

            .page-container {
                padding-left: 0;
                padding-right: 0;
            }

            .bottom-nav {
                display: none;
            }

            .patient-app {
                padding-bottom: 1px;
            }
        }


        /* =========================================================
           SMALL PHONES
           ========================================================= */

        @media (max-width: 360px) {

            body {
                font-size: 17px;
            }

            .patient-name {
                font-size: 25px;
            }

            .quick-grid {
                gap: 8px;
            }

            .quick-card {
                min-height: 105px;
                padding: 12px;
            }

            .quick-title {
                font-size: 15px;
            }

            .medicine-hero {
                padding: 17px;
            }
        }
    </style>
</head>


<body>

<div class="patient-app">

    <!-- =====================================================
         HEADER
         ===================================================== -->

    <header class="patient-header">

        <div class="header-inner">

            <div class="header-top">

                <div class="brand">
                    <div class="brand">

                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="খেয়াল"
                            class="brand-logo"
                        >

                    </div>

                </div>

                <div class="notification-wrap">
                    <button
                        type="button"
                        class="notification-button"
                        id="notificationButton"
                        aria-label="নোটিফিকেশন"
                    >
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <span class="notification-badge" id="notificationBadge">0</span>
                </div>

            </div>


            <div class="patient-greeting">

                <div>

                    <div class="greeting-small">
                        আসসালামু আলাইকুম
                    </div>

                    <h1
                        class="patient-name"
                        id="patientName"
                    >
                        ...
                    </h1>

                    <div
                        class="today-date"
                        id="todayDate"
                    >
                        ...
                    </div>

                </div>


                <div class="patient-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

            </div>

        </div>

    </header>


    <!-- =====================================================
         MAIN
         ===================================================== -->

    <main class="page-container">

        <div class="content">


            <!-- =================================================
                 TODAY'S MEDICINE
                 ================================================= -->

            <section class="section">

                <div class="section-heading">

                    <h2 class="section-title">
                        আজকের যত্ন
                    </h2>

                </div>


                <div class="medicine-hero" id="medicineHero">

                    <div class="medicine-hero-top">
                        <div class="medicine-hero-main" id="medicineHeroContent">
                            <div class="medicine-hero-label">আজকের ওষুধ</div>
                            <div class="medicine-hero-count" id="medicineHeroCount">লোড হচ্ছে...</div>
                            <div class="medicine-hero-sub" id="medicineHeroSub">সময় যাচাই করা হচ্ছে...</div>
                        </div>

                        <div class="medicine-hero-icon" id="medicineHeroIcon">
                            <i class="fa-solid fa-pills"></i>
                        </div>
                    </div>

                    <div class="medicine-hero-actions" id="medicineHeroActions"></div>

                    <a
                        href="#medicines"
                        class="medicine-hero-button secondary"
                    >
                        আজকের সব ওষুধ
                        <i class="fa-solid fa-arrow-down"></i>
                    </a>

                </div>

            </section>


            <!-- =================================================
                 QUICK ACTIONS
                 ================================================= -->

            <section class="section">

                <div class="section-heading">

                    <h2 class="section-title">
                        দ্রুত কাজ
                    </h2>

                </div>


                <div class="quick-grid">

                    <a
                        href="#medicines"
                        class="quick-card"
                    >

                        <div class="quick-icon green">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div class="quick-title">
                            ওষুধ নিয়েছি
                        </div>

                        <div class="quick-description">
                            আজকের ওষুধ দেখুন
                        </div>

                    </a>


                    <a
                        href="#appointments"
                        class="quick-card"
                    >

                        <div class="quick-icon blue">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <div class="quick-title">
                            ডাক্তার রিমাইন্ডার
                        </div>

                        <div class="quick-description">
                            অ্যাপয়েন্টমেন্ট দেখুন
                        </div>

                    </a>


                    <a
                        href="#checkin"
                        class="quick-card"
                    >

                        <div class="quick-icon orange">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>

                        <div class="quick-title">
                            আজ কেমন আছি
                        </div>

                        <div class="quick-description">
                            দৈনিক চেক-ইন দিন
                        </div>

                    </a>


                    <button
                        type="button"
                        class="quick-card"
                        id="quickSosButton"
                        style="border: 1px solid var(--border); text-align: left;"
                    >

                        <div class="quick-icon coral">
                            <i class="fa-solid fa-life-ring"></i>
                        </div>

                        <div class="quick-title">
                            সাহায্য চাই
                        </div>

                        <div class="quick-description">
                            জরুরি SOS পাঠান
                        </div>

                    </button>

                </div>

            </section>


            <!-- =================================================
                 SOS
                 ================================================= -->

            <section class="section">

                <button
                    type="button"
                    class="sos-card"
                    id="sosButton"
                >

                    <div class="sos-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <div class="sos-content">

                        <div class="sos-title">
                            জরুরি সাহায্য দরকার?
                        </div>

                        <div class="sos-description">
                            চাপলে আপনার caregiver-কে SOS জানানো হবে
                        </div>

                    </div>

                    <div class="sos-arrow">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>

                </button>

            </section>


            <!-- =================================================
                 MEDICINES
                 ================================================= -->

            <section
                class="section"
                id="medicines"
            >

                <div class="section-heading">

                    <h2 class="section-title">
                        আজকের ওষুধ
                    </h2>

                    <span
                        class="section-link"
                        id="medicineSummary"
                    >
                        ...
                    </span>

                </div>


                <div class="card">

                    <div
                        class="card-body"
                        id="medsCard"
                    >

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            </div>

                            <div class="empty-text">
                                ওষুধের তথ্য লোড হচ্ছে...
                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 DAILY CHECK-IN
                 ================================================= -->

            <section
                class="section"
                id="checkin"
            >

                <div class="section-heading">

                    <h2 class="section-title">
                        আজ কেমন আছেন?
                    </h2>

                </div>


                <div class="card">

                    <div
                        class="card-body"
                        id="checkinCard"
                    >

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            </div>

                            <div class="empty-text">
                                তথ্য লোড হচ্ছে...
                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 APPOINTMENTS / DOCTOR REMINDER
                 ================================================= -->

            <section
                class="section"
                id="appointments"
            >

                <div class="section-heading">

                    <h2 class="section-title">
                        ডাক্তার রিমাইন্ডার
                    </h2>

                    <span class="section-link">
                        আসন্ন
                    </span>

                </div>


                <div class="card">

                    <div
                        class="card-body"
                        id="appointmentCard"
                    >

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            </div>

                            <div class="empty-text">
                                অ্যাপয়েন্টমেন্ট লোড হচ্ছে...
                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 CAREGIVER
                 ================================================= -->

            <section
                class="section"
                id="contact"
            >

                <div class="section-heading">

                    <h2 class="section-title">
                        দ্রুত যোগাযোগ
                    </h2>

                </div>


                <div
                    class="card"
                    id="quickDialContainer"
                >

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>

                        <div class="empty-text">
                            যোগাযোগের তথ্য লোড হচ্ছে...
                        </div>

                    </div>

                </div>

            </section>


        </div>

    </main>


    <!-- =====================================================
         NOTIFICATION PANEL
         ===================================================== -->

    <div class="notification-panel" id="notificationPanel" aria-hidden="true">
        <div class="notification-sheet">
            <div class="notification-sheet-header">
                <h2 class="notification-sheet-title">নোটিফিকেশন</h2>
                <button type="button" class="notification-close" id="notificationClose" aria-label="বন্ধ করুন">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="notification-list" id="notificationList">
                <div class="notification-empty">এখনো কোনো নোটিফিকেশন নেই</div>
            </div>
        </div>
    </div>


    <!-- =====================================================
         BOTTOM NAV
         ===================================================== -->

    <nav class="bottom-nav">

        <a
            href="#top"
            class="bottom-nav-item active"
        >
            <i class="fa-solid fa-house"></i>
            <span>হোম</span>
        </a>


        <a
            href="#medicines"
            class="bottom-nav-item"
        >
            <i class="fa-solid fa-pills"></i>
            <span>ওষুধ</span>
        </a>


        <a
            href="#appointments"
            class="bottom-nav-item"
        >
            <i class="fa-solid fa-calendar-days"></i>
            <span>রিমাইন্ডার</span>
        </a>

    </nav>


    <!-- =====================================================
         TOAST
         ===================================================== -->

    <div
        class="toast"
        id="toast"
    ></div>

</div>


<script>

    /* =========================================================
       CONFIG
       ========================================================= */

    const TOKEN = @json($token);

    const API_BASE = '/api/patient/' + TOKEN;


    /* =========================================================
       LOCAL NOTIFICATION CENTER
       ========================================================= */

    const NOTIFICATION_KEY = 'kheyal_patient_notifications_' + TOKEN;

    function getLocalNotifications() {
        try {
            const value = JSON.parse(localStorage.getItem(NOTIFICATION_KEY) || '[]');
            return Array.isArray(value) ? value : [];
        } catch (error) {
            return [];
        }
    }


    function saveLocalNotification(notification) {
        try {
            const list = getLocalNotifications();
            list.unshift({
                id: Date.now() + Math.random(),
                type: notification.type || 'general',
                title: notification.title || 'খেয়াল',
                body: notification.body || '',
                created_at: new Date().toISOString()
            });

            localStorage.setItem(
                NOTIFICATION_KEY,
                JSON.stringify(list.slice(0, 50))
            );

            updateNotificationBadge();
        } catch (error) {
            console.warn('Notification history could not be saved.', error);
        }
    }


    function notificationIcon(type) {
        if (type === 'medicine') return 'fa-pills';
        if (type === 'appointment') return 'fa-user-doctor';
        if (type === 'sos') return 'fa-triangle-exclamation';
        if (type === 'checkin') return 'fa-heart-pulse';
        return 'fa-bell';
    }


    function renderNotificationCenter() {
        const listEl = document.getElementById('notificationList');
        if (!listEl) return;

        const list = getLocalNotifications();

        if (!list.length) {
            listEl.innerHTML = `
                <div class="notification-empty">
                    <i class="fa-regular fa-bell-slash" style="font-size:28px; margin-bottom:10px;"></i>
                    <div>এখনো কোনো নোটিফিকেশন নেই</div>
                </div>`;
            return;
        }

        listEl.innerHTML = list.map(item => {
            const when = formatDateTime(item.created_at);
            return `
                <div class="notification-item">
                    <div class="notification-item-icon">
                        <i class="fa-solid ${notificationIcon(item.type)}"></i>
                    </div>
                    <div class="notification-item-content">
                        <div class="notification-item-title">${esc(item.title)}</div>
                        <div class="notification-item-body">${esc(item.body)}</div>
                        <div class="notification-item-time">${esc(when)}</div>
                    </div>
                </div>`;
        }).join('') + `
            <div style="text-align:center;">
                <button type="button" class="notification-clear" id="clearNotifications">সব নোটিফিকেশন মুছে দিন</button>
            </div>`;

        document.getElementById('clearNotifications')?.addEventListener('click', () => {
            localStorage.removeItem(NOTIFICATION_KEY);
            renderNotificationCenter();
            updateNotificationBadge();
        });
    }


    function updateNotificationBadge() {
        const badge = document.getElementById('notificationBadge');
        if (!badge) return;
        const count = getLocalNotifications().length;
        badge.textContent = count > 99 ? '99+' : String(count);
        badge.style.display = count ? 'flex' : 'none';
    }


    function setupNotificationCenter() {
        const button = document.getElementById('notificationButton');
        const panel = document.getElementById('notificationPanel');
        const close = document.getElementById('notificationClose');

        if (!button || !panel || !close) return;

        button.addEventListener('click', () => {
            renderNotificationCenter();
            panel.classList.add('open');
            panel.setAttribute('aria-hidden', 'false');
        });

        close.addEventListener('click', () => {
            panel.classList.remove('open');
            panel.setAttribute('aria-hidden', 'true');
        });

        panel.addEventListener('click', event => {
            if (event.target === panel) {
                panel.classList.remove('open');
                panel.setAttribute('aria-hidden', 'true');
            }
        });

        updateNotificationBadge();
    }


    /* =========================================================
       API
       ========================================================= */

    async function api(path, options = {}) {

        try {

            const res = await fetch(API_BASE + path, {
                ...options,

                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',

                    ...(options.headers || {}),
                },
            });

            return res;

        } catch (error) {

            console.error('API error:', error);

            return null;
        }
    }


    /* =========================================================
       HELPERS
       ========================================================= */

    function esc(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;
    }


    function showToast(message) {

        const toast = document.getElementById('toast');

        toast.textContent = message;

        toast.style.display = 'block';

        clearTimeout(window.toastTimer);

        window.toastTimer = setTimeout(() => {

            toast.style.display = 'none';

        }, 3000);
    }


    function formatTime(time) {

        if (!time) return '';

        const parts = String(time).split(':');
        const hour = Number(parts[0]);
        const minute = String(parts[1] ?? '00').padStart(2, '0');

        if (!Number.isFinite(hour)) return '';

        let displayHour = hour % 12;
        if (displayHour === 0) displayHour = 12;

        let period = 'সকাল';
        if (hour >= 12 && hour < 16) period = 'দুপুর';
        else if (hour >= 16 && hour < 19) period = 'বিকেল';
        else if (hour >= 19 || hour < 5) period = 'রাত';

        return `${period} ${displayHour}:${minute}`;
    }


    function formatDateTime(value) {

        if (!value) return '';

        const raw = String(value);
        const date = raw.includes('T')
            ? new Date(raw)
            : new Date(raw.replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return raw;
        }

        return date.toLocaleString('bn-BD', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }


    function getDoseDateTime(dose) {

        if (!dose || !dose.scheduled_time) return null;

        const dateRaw = String(dose.scheduled_date || '');
        const dateMatch = dateRaw.match(/^(\d{4}-\d{2}-\d{2})/);
        const datePart = dateMatch ? dateMatch[1] : null;

        if (!datePart) return null;

        const timeParts = String(dose.scheduled_time).split(':');
        const hour = Number(timeParts[0]);
        const minute = Number(timeParts[1] || 0);
        const second = Number(timeParts[2] || 0);

        if (![hour, minute, second].every(Number.isFinite)) return null;

        const [year, month, day] = datePart.split('-').map(Number);
        const date = new Date(year, month - 1, day, hour, minute, second);

        return Number.isNaN(date.getTime()) ? null : date;
    }


    function getCountdownText(target) {

        if (!(target instanceof Date) || Number.isNaN(target.getTime())) {
            return '';
        }

        const diff = target.getTime() - Date.now();

        if (diff <= 0) return 'সময় পার হয়ে গেছে';

        const totalMinutes = Math.ceil(diff / 60000);

        if (totalMinutes < 60) {
            return `${totalMinutes} মিনিট পর`;
        }

        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;

        return minutes
            ? `${hours} ঘণ্টা ${minutes} মিনিট পর`
            : `${hours} ঘণ্টা পর`;
    }


    function getTodayDate() {

        return new Date().toLocaleDateString(
            'bn-BD',
            {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            }
        );
    }


    /* =========================================================
       PROFILE
       ========================================================= */

    async function loadProfile() {

        const res = await api('/me');

        if (!res || !res.ok) {

            document.getElementById('patientName').textContent =
                'লিংকটি সঠিক নয়';

            return null;
        }

        const patient = await res.json();


        document.getElementById('patientName').textContent =
            patient.name || 'রোগী';


        /*
         * Caregiver contact
         */

        const container =
            document.getElementById('quickDialContainer');


        if (patient.caregiver_phone) {

            const phone = String(patient.caregiver_phone).trim();
            const telPhone = phone.replace(/[^0-9+]/g, '');

            container.innerHTML = `
                <a
                    href="tel:${esc(telPhone)}"
                    class="contact-card"
                    aria-label="Caregiver-কে কল করুন"
                >
                    <div class="contact-icon">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <div class="contact-info">
                        <div class="contact-label">আপনার caregiver</div>
                        <div class="contact-name">পরিবারের সাথে যোগাযোগ</div>
                        <div class="contact-number">${esc(phone)}</div>
                    </div>

                    <div class="call-button">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </a>
            `;

        } else {

            container.innerHTML = `
                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fa-solid fa-phone-slash"></i>
                    </div>

                    <div class="empty-text">
                        caregiver-এর যোগাযোগ নম্বর নেই
                    </div>

                </div>
            `;
        }


        return patient;
    }


    /* =========================================================
       MEDICINES
       ========================================================= */

    const statusLabels = {

        taken: 'নেওয়া হয়েছে',

        missed: 'মিস হয়েছে',

        skipped: 'বাদ দেওয়া হয়েছে',

        pending: 'অপেক্ষমাণ'
    };


    function buildMedItem(dose) {

        const wrap = document.createElement('div');
        wrap.className = 'med-item';

        const medication = dose.medication || {};
        const medName = medication.name || 'ওষুধ';
        const dosage = medication.dosage || '';
        const scheduled = getDoseDateTime(dose);
        const now = new Date();

        let displayStatus = dose.status || 'pending';
        let statusLabel = statusLabels[displayStatus] || displayStatus;
        let statusIcon = 'fa-clock';

        if (dose.status === 'pending' && scheduled && scheduled.getTime() < now.getTime()) {
            displayStatus = 'missed';
            statusLabel = 'সময় পার হয়েছে';
            statusIcon = 'fa-circle-exclamation';
        } else if (dose.status === 'taken') {
            statusIcon = 'fa-circle-check';
        } else if (dose.status === 'missed') {
            statusIcon = 'fa-circle-xmark';
        }

        const time = dose.scheduled_time ? formatTime(dose.scheduled_time) : '';

        wrap.innerHTML = `
            <div class="med-main">
                <div class="med-icon">
                    <i class="fa-solid fa-pills"></i>
                </div>

                <div class="med-info">
                    <div class="med-name">${esc(medName)}</div>
                    <div class="med-time">
                        ${esc(time)}
                        ${dosage ? ` • ${esc(dosage)}` : ''}
                    </div>
                </div>

                <div class="med-status ${displayStatus}">
                    <i class="fa-solid ${statusIcon}"></i>
                    ${esc(statusLabel)}
                </div>
            </div>
        `;

        // Only backend-pending doses can be changed.
        if (dose.status === 'pending') {
            const actions = document.createElement('div');
            actions.className = 'med-actions';
            actions.innerHTML = `
                <button type="button" class="med-action btn-taken">
                    <i class="fa-solid fa-check"></i>
                    নিয়েছি
                </button>
                <button type="button" class="med-action btn-missed">
                    <i class="fa-solid fa-xmark"></i>
                    নেইনি
                </button>
            `;

            const takenButton = actions.querySelector('.btn-taken');
            const missedButton = actions.querySelector('.btn-missed');

            takenButton.addEventListener('click', () =>
                markDose(dose.id, 'taken', takenButton, missedButton)
            );

            missedButton.addEventListener('click', () =>
                markDose(dose.id, 'missed', takenButton, missedButton)
            );

            wrap.appendChild(actions);
        }

        return wrap;
    }


    async function markDose(
        doseId,
        status,
        primaryButton,
        secondaryButton
    ) {

        primaryButton.disabled = true;
        secondaryButton.disabled = true;


        const res = await api(
            `/dose-logs/${doseId}/mark`,
            {
                method: 'PUT',

                body: JSON.stringify({
                    status: status
                })
            }
        );


        if (res && res.ok) {

            showToast(
                status === 'taken'
                    ? 'ওষুধ নেওয়া হয়েছে — ধন্যবাদ'
                    : 'ওষুধের তথ্য রেকর্ড করা হয়েছে'
            );

            await loadMeds();

        } else {

            primaryButton.disabled = false;
            secondaryButton.disabled = false;

            showToast(
                'তথ্য সংরক্ষণ করা যায়নি'
            );
        }
    }


    function renderMedicineHero(doses) {

        const hero = document.getElementById('medicineHero');
        const count = document.getElementById('medicineHeroCount');
        const sub = document.getElementById('medicineHeroSub');
        const icon = document.getElementById('medicineHeroIcon');
        const actions = document.getElementById('medicineHeroActions');

        hero.classList.remove('overdue', 'done');
        actions.innerHTML = '';

        const pending = doses
            .filter(d => d.status === 'pending')
            .map(d => ({ dose: d, time: getDoseDateTime(d) }))
            .filter(x => x.time);

        const now = Date.now();
        const overdue = pending
            .filter(x => x.time.getTime() <= now)
            .sort((a, b) => a.time - b.time);

        const upcoming = pending
            .filter(x => x.time.getTime() > now)
            .sort((a, b) => a.time - b.time);

        const target = overdue.length ? overdue[overdue.length - 1] : upcoming[0];

        if (!target) {
            hero.classList.add('done');
            count.textContent = 'আজকের ওষুধের কাজ শেষ';
            sub.textContent = 'আর কোনো বাকি ওষুধ নেই';
            icon.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
            return;
        }

        const dose = target.dose;
        const medication = dose.medication || {};
        const name = medication.name || 'ওষুধ';
        const dosage = medication.dosage || '';
        const time = formatTime(dose.scheduled_time);

        if (target.time.getTime() <= now) {
            hero.classList.add('overdue');
            count.textContent = name;
            sub.innerHTML = `${esc(time)}${dosage ? ` • ${esc(dosage)}` : ''}<br><span class="medicine-hero-status"><i class="fa-solid fa-triangle-exclamation"></i> সময় পার হয়ে গেছে</span>`;
            icon.innerHTML = '<i class="fa-solid fa-clock"></i>';
        } else {
            count.textContent = name;
            sub.innerHTML = `${esc(time)}${dosage ? ` • ${esc(dosage)}` : ''}<br>${esc(getCountdownText(target.time))}`;
            icon.innerHTML = '<i class="fa-solid fa-clock"></i>';
        }

        const takenButton = document.createElement('button');
        takenButton.type = 'button';
        takenButton.className = 'medicine-hero-action taken';
        takenButton.innerHTML = '<i class="fa-solid fa-check"></i> নিয়েছি';

        const missedButton = document.createElement('button');
        missedButton.type = 'button';
        missedButton.className = 'medicine-hero-action missed';
        missedButton.innerHTML = '<i class="fa-solid fa-xmark"></i> নেইনি';

        takenButton.addEventListener('click', () =>
            markHeroDose(dose.id, 'taken', takenButton, missedButton)
        );
        missedButton.addEventListener('click', () =>
            markHeroDose(dose.id, 'missed', missedButton, takenButton)
        );

        actions.appendChild(takenButton);
        actions.appendChild(missedButton);
    }


    async function markHeroDose(doseId, status, primaryButton, secondaryButton) {
        primaryButton.disabled = true;
        secondaryButton.disabled = true;

        const res = await api(`/dose-logs/${doseId}/mark`, {
            method: 'PUT',
            body: JSON.stringify({ status })
        });

        if (res && res.ok) {
            saveLocalNotification({
                type: 'medicine',
                title: status === 'taken' ? 'ওষুধ নেওয়া হয়েছে' : 'ওষুধের ডোজ মিস হয়েছে',
                body: 'আজকের ওষুধের তথ্য আপডেট হয়েছে।'
            });
            showToast(status === 'taken' ? 'ওষুধ নেওয়া হয়েছে' : 'ওষুধ মিস হয়েছে হিসেবে রেকর্ড করা হয়েছে');
            await loadMeds();
        } else {
            primaryButton.disabled = false;
            secondaryButton.disabled = false;
            showToast('ওষুধের তথ্য সংরক্ষণ করা যায়নি');
        }
    }


    function pendingCountNeedsHeroOverride(doses) {
        return doses.some(dose => {
            if (dose.status !== 'pending') return false;
            const time = getDoseDateTime(dose);
            return time && time.getTime() <= Date.now();
        });
    }


    async function loadMeds() {

        const card = document.getElementById('medsCard');
        const heroCount = document.getElementById('medicineHeroCount');
        const summary = document.getElementById('medicineSummary');

        const res = await api('/dose-logs/today');

        if (!res || !res.ok) {
            card.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="empty-text">আজকের ওষুধ লোড করা যায়নি</div>
                </div>`;
            heroCount.textContent = 'তথ্য পাওয়া যায়নি';
            summary.textContent = '';
            return;
        }

        const doses = await res.json();
        const total = doses.length;
        const taken = doses.filter(d => d.status === 'taken').length;
        const missed = doses.filter(d => d.status === 'missed').length;
        const pending = doses.filter(d => d.status === 'pending').length;

        const effectivePending = doses.filter(d => {
            if (d.status !== 'pending') return false;
            const t = getDoseDateTime(d);
            return !t || t.getTime() > Date.now();
        }).length;

        renderMedicineHero(doses);

        summary.textContent = total
            ? `${taken}/${total} নেওয়া হয়েছে${missed ? ` • ${missed} মিস` : ''}`
            : '';

        if (total === 0) {
            card.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-pills"></i></div>
                    <div class="empty-text">আজ কোনো ওষুধের সময়সূচী নেই</div>
                </div>`;
            return;
        }

        // Do not show a past pending dose as a future dose.
        // It remains actionable so the patient can mark it taken/missed.
        const sorted = [...doses].sort((a, b) => {
            const ta = getDoseDateTime(a)?.getTime() ?? Number.MAX_SAFE_INTEGER;
            const tb = getDoseDateTime(b)?.getTime() ?? Number.MAX_SAFE_INTEGER;
            return ta - tb;
        });

        if (!pendingCountNeedsHeroOverride(doses)) {
            heroCount.textContent = effectivePending
                ? `${effectivePending} টি ডোজ বাকি`
                : (missed || taken ? 'আজকের ডোজগুলো দেখা হয়েছে' : 'আজ কোনো ওষুধ নেই');
        }

        card.innerHTML = '';
        sorted.forEach(dose => card.appendChild(buildMedItem(dose)));
    }


    /* =========================================================
       CHECK-IN
       ========================================================= */

    const checkinLabels = {

        fine: 'ভালো আছি',

        not_well: 'একটু অসুস্থ',

        need_help: 'সাহায্য দরকার'
    };


    const checkinIcons = {

        fine: 'fa-circle-check',

        not_well: 'fa-heart-pulse',

        need_help: 'fa-life-ring'
    };


    async function loadCheckin() {

        const card =
            document.getElementById('checkinCard');


        const res =
            await api('/checkins/latest');


        const checkin =
            res && res.ok
                ? await res.json()
                : null;


        let checkinToday = false;


        if (checkin && checkin.checked_in_at) {

            const checkedDate =
                new Date(
                    String(
                        checkin.checked_in_at
                    ).replace(' ', 'T')
                );


            const now =
                new Date();


            checkinToday =
                checkedDate.toDateString()
                === now.toDateString();
        }


        if (checkinToday) {

            const label =
                checkinLabels[
                    checkin.status
                ] || checkin.status;


            const icon =
                checkinIcons[
                    checkin.status
                ] || 'fa-circle-check';


            card.innerHTML = `

                <div class="checkin-done">

                    <div class="checkin-done-icon">

                        <i class="fa-solid ${icon}"></i>

                    </div>

                    <div class="checkin-done-title">
                        ${esc(label)}
                    </div>

                    <div class="checkin-done-text">
                        আজকের চেক-ইন দেওয়া হয়েছে
                    </div>

                </div>
            `;

            return;
        }


        card.innerHTML = `

            <div class="checkin-buttons">

                <button
                    type="button"
                    class="checkin-button fine"
                    data-status="fine"
                >

                    <span class="checkin-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>

                    <span>
                        ভালো আছি
                    </span>

                </button>


                <button
                    type="button"
                    class="checkin-button not-well"
                    data-status="not_well"
                >

                    <span class="checkin-icon">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </span>

                    <span>
                        একটু অসুস্থ
                    </span>

                </button>


                <button
                    type="button"
                    class="checkin-button need-help"
                    data-status="need_help"
                >

                    <span class="checkin-icon">
                        <i class="fa-solid fa-life-ring"></i>
                    </span>

                    <span>
                        সাহায্য দরকার
                    </span>

                </button>

            </div>
        `;


        card
            .querySelectorAll('.checkin-button')
            .forEach(button => {

                button.addEventListener(
                    'click',
                    () => submitCheckin(
                        button.dataset.status,
                        button
                    )
                );

            });
    }


    async function submitCheckin(
        status,
        clickedButton
    ) {

        const buttons =
            document.querySelectorAll(
                '.checkin-button'
            );


        buttons.forEach(
            button => button.disabled = true
        );


        const res =
            await api('/checkins', {
                method: 'POST',

                body: JSON.stringify({
                    status: status
                })
            });


        if (res && res.ok) {

            const labels = {
                fine: 'ভালো আছি',
                not_well: 'একটু অসুস্থ',
                need_help: 'সাহায্য দরকার'
            };

            saveLocalNotification({
                type: 'checkin',
                title: 'দৈনিক চেক-ইন',
                body: `আজকের অবস্থা: ${labels[status] || status}`
            });

            showToast(
                'আজকের চেক-ইন জানানো হয়েছে'
            );

            await loadCheckin();

        } else {

            buttons.forEach(
                button => button.disabled = false
            );

            showToast(
                'চেক-ইন সংরক্ষণ করা যায়নি'
            );
        }
    }


    /* =========================================================
       APPOINTMENTS
       ========================================================= */

    async function acknowledgeAppointment(appointmentId, button) {

        button.disabled = true;

        const res = await api(`/appointments/${appointmentId}/acknowledge`, {
            method: 'POST'
        });

        if (res && res.ok) {
            saveLocalNotification({
                type: 'appointment',
                title: 'অ্যাপয়েন্টমেন্ট নিশ্চিত',
                body: 'এই অ্যাপয়েন্টমেন্টের পরবর্তী reminder বন্ধ করা হয়েছে।'
            });
            showToast('অ্যাপয়েন্টমেন্ট নিশ্চিত করা হয়েছে');
            await loadAppointments();
        } else {
            button.disabled = false;
            showToast('অ্যাপয়েন্টমেন্ট আপডেট করা যায়নি');
        }
    }


    async function loadAppointments() {

        const card = document.getElementById('appointmentCard');
        const res = await api('/appointments/upcoming');

        if (!res || !res.ok) {
            card.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="empty-text">অ্যাপয়েন্টমেন্ট লোড করা যায়নি</div>
                </div>`;
            return;
        }

        const appointments = await res.json();

        if (!appointments.length) {
            card.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="empty-text">কোনো আসন্ন ডাক্তার অ্যাপয়েন্টমেন্ট নেই</div>
                </div>`;
            return;
        }

        card.innerHTML = '';

        appointments.forEach(appointment => {
            const item = document.createElement('div');
            item.className = 'appointment-item';

            const when = formatDateTime(appointment.appointment_date);
            const doctor = appointment.doctor_name || 'ডাক্তারের অ্যাপয়েন্টমেন্ট';
            const location = appointment.location || '';

            item.innerHTML = `
                <div class="appointment-top">
                    <div class="doctor-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <div class="appointment-info">
                        <div class="appointment-doctor">${esc(doctor)}</div>
                        <div class="appointment-time"><i class="fa-regular fa-clock"></i> ${esc(when)}</div>
                        ${location ? `
                            <div class="appointment-location">
                                <i class="fa-solid fa-location-dot"></i> ${esc(location)}
                            </div>` : ''}
                        <div class="appointment-badge">
                            <i class="fa-solid fa-bell"></i> ডাক্তার রিমাইন্ডার
                        </div>
                    </div>
                </div>

                <button type="button" class="appointment-ack">
                    <i class="fa-solid fa-check"></i> পৌঁছেছি — আর reminder দরকার নেই
                </button>
            `;

            const ackButton = item.querySelector('.appointment-ack');
            ackButton.addEventListener('click', () =>
                acknowledgeAppointment(appointment.id, ackButton)
            );

            card.appendChild(item);
        });
    }


    /* =========================================================
       SOS
       ========================================================= */

    async function triggerSOS() {

        const confirmed =
            confirm(
                'আপনি কি নিশ্চিত যে সাহায্যের জন্য SOS পাঠাতে চান?'
            );


        if (!confirmed) {
            return;
        }


        const buttons =
            document.querySelectorAll(
                '#sosButton, #quickSosButton'
            );


        buttons.forEach(
            button => button.disabled = true
        );


        const res =
            await api('/sos', {
                method: 'POST'
            });


        if (res && res.ok) {

            saveLocalNotification({
                type: 'sos',
                title: 'SOS পাঠানো হয়েছে',
                body: 'আপনার caregiver-কে জরুরি alert জানানো হয়েছে।'
            });

            showToast(
                'SOS পাঠানো হয়েছে — caregiver-কে জানানো হয়েছে'
            );

        } else {

            showToast(
                'SOS পাঠানো যায়নি। আবার চেষ্টা করুন।'
            );
        }


        setTimeout(() => {

            buttons.forEach(
                button => button.disabled = false
            );

        }, 1500);
    }


    document
        .getElementById('sosButton')
        .addEventListener(
            'click',
            triggerSOS
        );


    document
        .getElementById('quickSosButton')
        .addEventListener(
            'click',
            triggerSOS
        );


    /* =========================================================
       BOTTOM NAV
       ========================================================= */

    document
        .querySelectorAll('.bottom-nav-item')
        .forEach(item => {

            item.addEventListener(
                'click',
                () => {

                    document
                        .querySelectorAll(
                            '.bottom-nav-item'
                        )
                        .forEach(
                            nav =>
                                nav.classList.remove(
                                    'active'
                                )
                        );


                    if (!item.classList.contains('sos')) {

                        item.classList.add('active');
                    }
                }
            );

        });



    /* =========================================================
    SERVICE WORKER + PUSH NOTIFICATIONS
    ========================================================= */

    async function setupPushNotifications() {

        if (
            !('serviceWorker' in navigator) ||
            !('PushManager' in window) ||
            !('Notification' in window)
        ) {
            console.log('Push notifications are not supported.');
            return;
        }

        try {

            /*
            * Wait until the service worker is registered and ready.
            */
            const registration =
                await navigator.serviceWorker.ready;


            /*
            * Get VAPID public key from Laravel.
            */
            const vapidResponse =
                await fetch(API_BASE + '/push/vapid-public-key');

            if (!vapidResponse.ok) {
                throw new Error('Could not get VAPID public key.');
            }

            const vapidData =
                await vapidResponse.json();

            const vapidPublicKey =
                vapidData.public_key;


            /*
            * Check current notification permission.
            */
            let permission = Notification.permission;

            if (permission === 'default') {

                permission =
                    await Notification.requestPermission();

            }

            if (permission !== 'granted') {

                console.log(
                    'Notification permission was not granted.'
                );

                return;
            }


            /*
            * Check whether this device already has
            * a push subscription.
            */
            let subscription =
                await registration.pushManager.getSubscription();


            /*
            * If there is no subscription, create one.
            */
            if (!subscription) {

                const applicationServerKey =
                    urlBase64ToUint8Array(vapidPublicKey);

                subscription =
                    await registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey:
                            applicationServerKey
                    });
            }


            /*
            * Convert PushSubscription into plain JSON.
            */
            const subscriptionJson =
                subscription.toJSON();


            /*
            * Send subscription to Laravel.
            */
            const response =
                await fetch(API_BASE + '/push/subscribe', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },

                    body: JSON.stringify({
                        endpoint: subscriptionJson.endpoint,

                        keys: {
                            p256dh:
                                subscriptionJson.keys.p256dh,

                            auth:
                                subscriptionJson.keys.auth
                        }
                    })

                });


            if (!response.ok) {

                const errorText =
                    await response.text();

                throw new Error(
                    'Push subscription failed: ' +
                    errorText
                );
            }


            console.log(
                'Patient push subscription saved successfully.'
            );

        } catch (error) {

            console.error(
                'Push notification setup failed:',
                error
            );

        }
    }


    /*
    * Convert VAPID Base64 URL key into Uint8Array.
    */
    function urlBase64ToUint8Array(base64String) {

        const padding =
            '='.repeat(
                (4 - base64String.length % 4) % 4
            );

        const base64 =
            (base64String + padding)
                .replace(/-/g, '+')
                .replace(/_/g, '/');

        const rawData =
            window.atob(base64);

        const outputArray =
            new Uint8Array(rawData.length);

        for (
            let i = 0;
            i < rawData.length;
            ++i
        ) {
            outputArray[i] =
                rawData.charCodeAt(i);
        }

        return outputArray;
    }


    if ('serviceWorker' in navigator) {

        navigator.serviceWorker
            .register('/sw.js')
            .then(() => {

                /*
                * Service worker is ready.
                * Then configure push.
                */
                setupPushNotifications();

            })
            .catch((error) => {

                console.error(
                    'Service worker registration failed:',
                    error
                );

            });

    }


    /* =========================================================
       INIT
       ========================================================= */

    document
        .getElementById('todayDate')
        .textContent =
        getTodayDate();

    setupNotificationCenter();

    setInterval(() => {
        loadMeds();
        loadAppointments();
    }, 30000);


    (async function init() {

        const patient =
            await loadProfile();


        if (!patient) {
            return;
        }


        await Promise.all([
            loadMeds(),
            loadCheckin(),
            loadAppointments()
        ]);

    })();

</script>

</body>
</html>