<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Setting::where('key', 'company_name')->value('value') ?? config('app.name', 'GMAC Coffee') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .admin-ui {
                --admin-bg: #f4f4f5;
                --admin-panel: #ffffff;
                --admin-panel-strong: #ffffff;
                --admin-border: #e4e4e7;
                --admin-border-strong: #d4d4d8;
                --admin-text: #18181b;
                --admin-muted: #71717a;
                --admin-primary: #673de6;
                --admin-accent: #7c3aed;
                --admin-primary-soft: rgba(103, 61, 230, 0.08);
                --admin-danger: #dc2626;
                --admin-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 8px 24px rgba(0, 0, 0, 0.06);
                background: var(--admin-bg);
                color: var(--admin-text);
                font-family: 'Inter', system-ui, sans-serif;
            }

            .admin-brand-badge {
                display: flex;
                height: 2.5rem;
                width: 2.5rem;
                flex-shrink: 0;
                align-items: center;
                justify-content: center;
                border-radius: 0.75rem;
                background: linear-gradient(135deg, #7c3aed 0%, #673de6 100%);
                font-size: 0.8rem;
                font-weight: 800;
                color: #fff;
                letter-spacing: 0.02em;
                box-shadow: 0 4px 14px rgba(103, 61, 230, 0.35);
            }

            .admin-brand-badge--host {
                border-radius: 0.65rem;
            }

            .admin-brand-badge--rail {
                height: 2rem;
                width: 2rem;
                font-size: 0.7rem;
                border-radius: 0.5rem;
            }

            .admin-brand-badge--lg {
                height: 2.75rem;
                width: 2.75rem;
                border-radius: 0.85rem;
                font-size: 0.85rem;
            }

            .admin-nav-link {
                display: flex;
                width: 100%;
                align-items: center;
                padding: 0.625rem 0.75rem;
                font-size: 0.875rem;
                line-height: 1.25rem;
                border-radius: 0.75rem;
                border: 1px solid transparent;
                color: rgba(226, 232, 240, 0.88);
                font-weight: 500;
                text-decoration: none;
                transition: background 0.18s ease, color 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
            }

            .admin-nav-link:hover {
                background: rgba(255, 255, 255, 0.06);
                color: #fff;
            }

            .admin-nav-link--active {
                font-weight: 600;
                color: #fef3c7 !important;
                background: linear-gradient(135deg, rgba(212, 162, 74, 0.22) 0%, rgba(15, 118, 110, 0.2) 100%) !important;
                border-color: rgba(212, 162, 74, 0.38) !important;
                box-shadow: 0 0 0 1px rgba(212, 162, 74, 0.1), 0 14px 32px rgba(0, 0, 0, 0.22);
            }

            .admin-nav-link--mobile {
                color: #475569;
                border-radius: 0.75rem;
            }

            .admin-nav-link--mobile:hover {
                background: #f8fafc !important;
                color: #0f172a !important;
            }

            .admin-nav-link--mobile.admin-nav-link--active {
                color: #5b21b6 !important;
                background: rgba(103, 61, 230, 0.08) !important;
                border-color: rgba(103, 61, 230, 0.2) !important;
                box-shadow: none !important;
            }

            .admin-shell {
                display: flex;
                min-height: 100vh;
                align-items: stretch;
            }

            .admin-workspace {
                min-width: 0;
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .admin-nav-cluster {
                flex-shrink: 0;
                align-self: stretch;
                min-height: 100vh;
                position: sticky;
                top: 0;
            }

            .admin-sidenav {
                width: 272px;
                min-height: 100vh;
                background: #fafafa;
                border-right: 1px solid var(--admin-border);
                display: flex;
                flex-direction: column;
            }

            .admin-sidenav--single {
                width: min(288px, 92vw);
                background: #f1f5f9;
                border-right-color: #e2e8f0;
            }

            .admin-sidenav__head {
                padding: 1rem 1rem 0.85rem;
                border-bottom: 1px solid #e2e8f0;
                background: #fff;
                flex-shrink: 0;
            }

            .admin-sidenav__brand {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                text-decoration: none;
                color: inherit;
            }

            .admin-sidenav__brand:hover .admin-sidenav__site-name {
                color: #673de6;
            }

            .admin-sidenav__brand-text {
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            .admin-sidenav__search-block {
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #e2e8f0;
                background: #fff;
                flex-shrink: 0;
            }

            .admin-sidenav__search {
                display: flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.4rem 0.65rem;
                background: #fff;
                border: 1px solid var(--admin-border);
                border-radius: 10px;
                transition: border-color 0.15s, box-shadow 0.15s;
            }

            .admin-sidenav__search:focus-within {
                border-color: rgba(103, 61, 230, 0.35);
                box-shadow: 0 0 0 3px rgba(103, 61, 230, 0.1);
            }

            .admin-sidenav__search svg {
                width: 16px;
                height: 16px;
                color: #a1a1aa;
                flex-shrink: 0;
            }

            .admin-sidenav__search-input {
                flex: 1;
                min-width: 0;
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
                min-height: unset !important;
                padding: 0.2rem 0 !important;
                font-size: 0.8125rem !important;
            }

            .admin-sidenav__search-input:focus {
                outline: none !important;
            }

            .admin-sidenav__search-kbd {
                display: flex;
                align-items: center;
                gap: 2px;
                font-size: 0.6rem;
                color: #a1a1aa;
            }

            .admin-sidenav__search-kbd kbd {
                padding: 0.1rem 0.3rem;
                border-radius: 4px;
                border: 1px solid var(--admin-border);
                background: #f4f4f5;
                font-family: inherit;
            }

            .admin-sidenav__footer {
                margin-top: auto;
                flex-shrink: 0;
                padding: 0.75rem 0.85rem 1rem;
                border-top: 1px solid #e2e8f0;
                background: #fff;
                box-shadow: 0 -4px 12px rgba(15, 23, 42, 0.04);
            }

            .admin-sidenav__footer-link {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                width: 100%;
                padding: 0.5rem 0.65rem;
                margin: 2px 0;
                border-radius: 10px;
                font-size: 0.8125rem;
                font-weight: 500;
                color: #52525b;
                text-decoration: none;
                transition: background 0.12s ease, color 0.12s ease;
            }

            .admin-sidenav__footer-link:hover {
                background: #f4f4f5;
                color: #18181b;
            }

            .admin-sidenav__footer-link.is-active {
                background: rgba(103, 61, 230, 0.08);
                color: #673de6;
            }

            .admin-sidenav__footer-ico {
                width: 18px;
                height: 18px;
                flex-shrink: 0;
                opacity: 0.85;
            }

            .admin-sidenav__footer-form {
                margin: 0;
            }

            .admin-sidenav__footer-btn {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                width: 100%;
                padding: 0.5rem 0.65rem;
                margin: 2px 0;
                border: none;
                border-radius: 10px;
                font-size: 0.8125rem;
                font-weight: 500;
                color: #52525b;
                background: transparent;
                cursor: pointer;
                text-align: left;
                transition: background 0.12s ease, color 0.12s ease;
            }

            .admin-sidenav__footer-btn:hover {
                background: #fee2e2;
                color: #b91c1c;
            }

            .admin-sidenav__footer-user {
                margin: 0.5rem 0 0;
                padding: 0 0.65rem;
                font-size: 0.65rem;
                color: #a1a1aa;
                word-break: break-all;
                line-height: 1.35;
            }

            .admin-sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            .admin-sidenav__site-label {
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--admin-muted);
                margin: 0 0 0.35rem;
            }

            .admin-sidenav__site-name {
                font-size: 0.95rem;
                font-weight: 600;
                color: var(--admin-text);
                margin: 0;
                line-height: 1.3;
                word-break: break-word;
            }

            .admin-sidenav__scroll {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
                padding: 0.75rem 0.65rem 1rem;
                scrollbar-gutter: stable;
            }

            .admin-sidenav__group {
                margin-bottom: 0.65rem;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                background: #fff;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
                overflow: hidden;
            }

            .admin-sidenav__group:last-child {
                margin-bottom: 0;
            }

            .admin-sidenav__group-label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.625rem;
                font-weight: 700;
                letter-spacing: 0.11em;
                text-transform: uppercase;
                color: #64748b;
                padding: 0.5rem 0.75rem;
                margin: 0;
                background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
                border-bottom: 1px solid #e2e8f0;
            }

            .admin-sidenav__group-label::before {
                content: '';
                width: 3px;
                height: 0.7rem;
                border-radius: 2px;
                background: linear-gradient(180deg, #7c3aed 0%, #673de6 100%);
                flex-shrink: 0;
            }

            .admin-sidenav__group-body {
                padding: 0.35rem 0.4rem 0.45rem;
            }

            .admin-sidenav__group-body .admin-sidenav__link + .admin-sidenav__link {
                border-top: 1px solid #f1f5f9;
            }

            .admin-sidenav__link {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 0.65rem;
                margin: 0;
                border-radius: 8px;
                font-size: 0.8125rem;
                font-weight: 500;
                color: #334155;
                text-decoration: none;
                transition: background 0.12s ease, color 0.12s ease, box-shadow 0.12s ease;
            }

            .admin-sidenav__link:hover {
                background: #f8fafc;
                color: #0f172a;
            }

            .admin-sidenav__link.is-active {
                background: rgba(103, 61, 230, 0.09);
                color: #5b21b6;
                font-weight: 600;
                box-shadow: inset 3px 0 0 #673de6;
            }

            .admin-sidenav__dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: currentColor;
                opacity: 0.35;
            }

            .admin-sidenav__link.is-active .admin-sidenav__dot {
                background: #673de6;
                opacity: 1;
            }

            .admin-mobile-nav-section {
                margin-bottom: 0.75rem;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                background: #fff;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
                overflow: hidden;
            }

            .admin-mobile-nav-section:last-child {
                margin-bottom: 0;
            }

            .admin-mobile-nav-section__label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.625rem;
                font-weight: 700;
                letter-spacing: 0.11em;
                text-transform: uppercase;
                color: #64748b;
                padding: 0.45rem 0.75rem;
                margin: 0;
                background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
                border-bottom: 1px solid #e2e8f0;
            }

            .admin-mobile-nav-section__label::before {
                content: '';
                width: 3px;
                height: 0.7rem;
                border-radius: 2px;
                background: linear-gradient(180deg, #7c3aed 0%, #673de6 100%);
                flex-shrink: 0;
            }

            .admin-mobile-nav-section__links {
                padding: 0.35rem 0.4rem 0.45rem;
            }

            .admin-mobile-nav-section__links a + a {
                border-top: 1px solid #f1f5f9;
            }

            .admin-topbar {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 0.65rem 1.25rem;
                background: #fff;
                border-bottom: 1px solid var(--admin-border);
            }

            .admin-topbar__search {
                flex: 1;
                max-width: 520px;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.45rem 0.75rem;
                background: #f4f4f5;
                border: 1px solid transparent;
                border-radius: 12px;
                transition: border-color 0.15s, background 0.15s;
            }

            .admin-topbar__search:focus-within {
                background: #fff;
                border-color: rgba(103, 61, 230, 0.35);
                box-shadow: 0 0 0 3px rgba(103, 61, 230, 0.12);
            }

            .admin-topbar__search svg {
                width: 18px;
                height: 18px;
                color: #a1a1aa;
                flex-shrink: 0;
            }

            .admin-topbar__search input {
                flex: 1;
                min-width: 0;
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
                min-height: unset !important;
                padding: 0.25rem 0 !important;
                font-size: 0.875rem !important;
            }

            .admin-topbar__search input:focus {
                outline: none !important;
                box-shadow: none !important;
            }

            .admin-topbar__kbd {
                display: none;
                align-items: center;
                gap: 2px;
                font-size: 0.65rem;
                color: #a1a1aa;
            }

            @media (min-width: 768px) {
                .admin-topbar__kbd {
                    display: flex;
                }
            }

            .admin-topbar__kbd kbd {
                padding: 0.15rem 0.4rem;
                border-radius: 6px;
                border: 1px solid var(--admin-border);
                background: #fff;
                font-family: inherit;
            }

            .admin-topbar__right {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-left: auto;
            }

            .admin-topbar__ghost {
                display: none;
                align-items: center;
                padding: 0.45rem 0.85rem;
                border-radius: 10px;
                font-size: 0.8rem;
                font-weight: 600;
                color: #52525b;
                text-decoration: none;
                border: 1px solid var(--admin-border);
                background: #fff;
                transition: background 0.15s;
            }

            @media (min-width: 640px) {
                .admin-topbar__ghost {
                    display: inline-flex;
                }
            }

            .admin-topbar__ghost:hover {
                background: #f4f4f5;
            }

            .admin-topbar__profile {
                position: relative;
            }

            .admin-topbar__profile > summary {
                list-style: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 12px;
                border: 1px solid var(--admin-border);
                background: #fafafa;
                font-size: 0.8rem;
                font-weight: 700;
                color: #673de6;
            }

            .admin-topbar__profile > summary::-webkit-details-marker {
                display: none;
            }

            .admin-topbar__profile[open] > summary {
                box-shadow: 0 0 0 2px rgba(103, 61, 230, 0.25);
            }

            .admin-topbar__menu {
                position: absolute;
                right: 0;
                top: calc(100% + 8px);
                min-width: 200px;
                padding: 0.35rem;
                background: #fff;
                border: 1px solid var(--admin-border);
                border-radius: 12px;
                box-shadow: var(--admin-shadow);
                z-index: 50;
            }

            .admin-topbar__menu a,
            .admin-topbar__menu button {
                display: block;
                width: 100%;
                text-align: left;
                padding: 0.55rem 0.75rem;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                color: #3f3f46;
                text-decoration: none;
                border: none;
                background: none;
                cursor: pointer;
            }

            .admin-topbar__menu a:hover,
            .admin-topbar__menu button:hover {
                background: #f4f4f5;
            }

            .admin-topbar__email {
                padding: 0.35rem 0.75rem 0.5rem;
                font-size: 0.7rem;
                color: #71717a;
                border-bottom: 1px solid var(--admin-border);
                margin-bottom: 0.25rem;
                word-break: break-all;
            }

            .admin-icon-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 12px;
                border: 1px solid var(--admin-border);
                background: #fff;
                color: #52525b;
            }

            .admin-ui .bg-white {
                background: var(--admin-panel) !important;
            }

            .admin-ui .text-gray-900,
            .admin-ui .text-gray-800,
            .admin-ui .text-gray-700 {
                color: var(--admin-text) !important;
            }

            .admin-ui .text-gray-600,
            .admin-ui .text-gray-500 {
                color: var(--admin-muted) !important;
            }

            .admin-ui .border,
            .admin-ui .border-b,
            .admin-ui .border-t,
            .admin-ui .border-gray-100,
            .admin-ui .border-gray-200,
            .admin-ui .border-gray-300,
            .admin-ui .border-green-400 {
                border-color: var(--admin-border) !important;
            }

            .admin-ui .shadow,
            .admin-ui .shadow-sm,
            .admin-ui .shadow-md {
                box-shadow: var(--admin-shadow) !important;
            }

            .admin-ui .sm\:rounded-lg,
            .admin-ui .rounded-md,
            .admin-ui .rounded-lg {
                border-radius: 1rem !important;
            }

            .admin-ui input[type="text"],
            .admin-ui input[type="email"],
            .admin-ui input[type="number"],
            .admin-ui input[type="password"],
            .admin-ui input[type="url"],
            .admin-ui input[type="file"],
            .admin-ui select,
            .admin-ui textarea {
                width: 100%;
                border: 1px solid var(--admin-border) !important;
                background: rgba(255, 255, 255, 0.92) !important;
                color: var(--admin-text) !important;
                border-radius: 0.9rem !important;
                min-height: 2.85rem;
                box-shadow: none !important;
            }

            .admin-ui textarea {
                min-height: unset;
            }

            .admin-ui input:focus,
            .admin-ui select:focus,
            .admin-ui textarea:focus {
                border-color: rgba(103, 61, 230, 0.45) !important;
                box-shadow: 0 0 0 3px rgba(103, 61, 230, 0.12) !important;
                outline: none !important;
            }

            .admin-ui table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            .admin-ui thead tr {
                background: rgba(15, 23, 42, 0.03);
            }

            .admin-ui thead th {
                font-size: 0.75rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--admin-muted) !important;
                font-weight: 700;
            }

            .admin-ui tbody tr:hover {
                background: rgba(103, 61, 230, 0.04);
            }

            .admin-ui a.bg-blue-600,
            .admin-ui button.bg-blue-600 {
                background: linear-gradient(135deg, #7c3aed 0%, #673de6 55%, #5b21b6 100%) !important;
                border: 1px solid rgba(103, 61, 230, 0.45) !important;
                color: #fff !important;
                border-radius: 0.75rem !important;
                box-shadow: 0 8px 24px rgba(103, 61, 230, 0.28) !important;
                transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease !important;
            }

            .admin-ui a.bg-blue-600:hover,
            .admin-ui button.bg-blue-600:hover {
                filter: brightness(1.05);
                box-shadow: 0 12px 32px rgba(103, 61, 230, 0.35) !important;
            }

            .admin-ui .bg-green-100 {
                background: #ecfdf5 !important;
            }

            .admin-ui .text-green-700,
            .admin-ui .text-green-800 {
                color: #047857 !important;
            }

            .admin-ui .bg-red-100 {
                background: #fef2f2 !important;
            }

            .admin-ui .text-red-500,
            .admin-ui .text-red-800 {
                color: var(--admin-danger) !important;
            }

            .admin-shell-header {
                background: transparent;
            }

            .admin-sidebar__mobilebar {
                position: sticky;
                top: 0;
                z-index: 40;
                padding: 0.75rem 0.75rem 0;
                background: var(--admin-bg);
            }

            .admin-sidebar__mobilebar-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                border: 1px solid var(--admin-border);
                border-radius: 14px;
                background: #fff;
                padding: 0.75rem 1rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }

            .admin-page-header {
                padding: 1rem 1rem 0;
            }

            .admin-page-header__inner {
                background: #fff;
                border: 1px solid var(--admin-border);
                border-radius: 16px;
                padding: 1.25rem 1.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            }

            .admin-content {
                flex: 1;
                padding: 1rem 1rem 2rem;
            }

            .admin-content > * {
                max-width: 100%;
            }

            @media (min-width: 1024px) {
                .admin-sidebar__mobilebar {
                    display: none;
                }

                .admin-page-header {
                    padding: 1.25rem 1.5rem 0;
                }

                .admin-content {
                    padding: 1.25rem 1.5rem 2.5rem;
                }
            }

            /* ─── shadcn-inspired utilities (admin workspace) ─── */
            .admin-ui {
                --radius: 0.75rem;
                --border: 240 5.9% 90%;
                --muted: 240 4.8% 95.9%;
                --muted-foreground: 240 3.8% 46.1%;
                --card: 0 0% 100%;
                --foreground: 240 10% 3.9%;
                --ring: 240 5% 64.9%;
            }

            .shadcn-card {
                border-radius: calc(var(--radius) + 2px);
                border: 1px solid hsl(var(--border));
                background: hsl(var(--card));
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.04);
            }

            .text-muted-foreground {
                color: hsl(var(--muted-foreground)) !important;
            }

            .border-border {
                border-color: hsl(var(--border)) !important;
            }

            .bg-muted\/40 {
                background-color: hsl(var(--muted) / 0.45) !important;
            }

            .shadcn-table th {
                text-align: left;
                padding: 0.65rem 1rem;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: hsl(var(--muted-foreground));
                border-bottom: 1px solid hsl(var(--border));
                background: hsl(var(--muted) / 0.35);
            }

            .shadcn-table td {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                border-bottom: 1px solid hsl(var(--border));
                vertical-align: middle;
            }

            .shadcn-table tbody tr:hover {
                background: hsl(var(--muted) / 0.25);
            }

            .shadcn-badge {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 0.2rem 0.65rem;
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: capitalize;
            }

            .shadcn-badge--pending {
                background: hsl(48 96% 89%);
                color: hsl(32 81% 29%);
            }

            .shadcn-badge--processing {
                background: hsl(199 89% 92%);
                color: hsl(200 98% 28%);
            }

            .shadcn-badge--completed {
                background: hsl(152 76% 90%);
                color: hsl(163 94% 22%);
            }

            .shadcn-badge--cancelled {
                background: hsl(0 93% 94%);
                color: hsl(0 72% 35%);
            }

            .shadcn-link {
                font-size: 0.875rem;
                font-weight: 500;
                color: #673de6 !important;
                text-decoration: underline;
                text-underline-offset: 2px;
            }

            .shadcn-link:hover {
                color: #5b21b6 !important;
            }

            .shadcn-page-head {
                display: flex;
                flex-wrap: wrap;
                align-items: flex-start;
                justify-content: space-between;
                gap: 1rem;
            }

            .shadcn-kicker {
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: hsl(var(--muted-foreground));
                margin: 0 0 0.35rem;
            }

            .shadcn-title {
                font-size: 1.5rem;
                font-weight: 600;
                letter-spacing: -0.02em;
                color: hsl(var(--foreground));
                margin: 0;
            }

            .shadcn-desc {
                margin: 0.35rem 0 0;
                font-size: 0.875rem;
                color: hsl(var(--muted-foreground));
                max-width: 42rem;
                line-height: 1.5;
            }

            .shadcn-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: var(--radius);
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                background: linear-gradient(135deg, #7c3aed 0%, #673de6 100%);
                color: #fff !important;
                border: 1px solid rgba(103, 61, 230, 0.4);
                cursor: pointer;
                transition: filter 0.15s ease;
            }

            .shadcn-btn:hover {
                filter: brightness(1.05);
            }

            .shadcn-btn-secondary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: var(--radius);
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                border: 1px solid hsl(var(--border));
                background: hsl(var(--card));
                color: hsl(var(--foreground)) !important;
                text-decoration: none !important;
                transition: background 0.15s ease;
            }

            .shadcn-btn-secondary:hover {
                background: hsl(var(--muted));
            }

            .shadcn-select {
                border-radius: var(--radius);
                border: 1px solid hsl(var(--border));
                background: hsl(var(--card));
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                color: hsl(var(--foreground));
            }

            trix-toolbar {
                border-radius: var(--radius) var(--radius) 0 0 !important;
                border: 1px solid hsl(var(--border)) !important;
                border-bottom: none !important;
                background: hsl(var(--muted) / 0.4) !important;
            }

            trix-editor.trix-shadcn {
                min-height: 320px;
                border-radius: 0 0 var(--radius) var(--radius) !important;
                border: 1px solid hsl(var(--border)) !important;
                background: hsl(var(--card)) !important;
                padding: 1rem !important;
            }
        </style>
        @stack('styles')
    </head>
    <body class="admin-ui antialiased">
        <div class="admin-shell">
            @include('layouts.navigation')

            <div class="admin-workspace">
                <header class="admin-topbar flex lg:hidden">
                    <span class="min-w-0 flex-1 truncate text-sm font-medium text-zinc-600">Admin</span>
                    <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="admin-topbar__ghost shrink-0">View site</a>
                </header>

                @isset($header)
                    <header class="admin-page-header">
                        <div class="admin-page-header__inner">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="admin-content">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
