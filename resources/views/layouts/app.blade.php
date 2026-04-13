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
                --admin-bg: #f8fafc;
                --admin-panel: rgba(255, 255, 255, 0.94);
                --admin-panel-strong: #ffffff;
                --admin-border: #e2e8f0;
                --admin-border-strong: #cbd5e1;
                --admin-text: #0f172a;
                --admin-muted: #64748b;
                --admin-primary: #0f766e;
                --admin-primary-soft: rgba(15, 118, 110, 0.08);
                --admin-danger: #dc2626;
                --admin-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
                background:
                    radial-gradient(circle at top left, rgba(15, 118, 110, 0.08), transparent 28%),
                    radial-gradient(circle at top right, rgba(245, 158, 11, 0.08), transparent 24%),
                    linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
                color: var(--admin-text);
                font-family: 'Inter', system-ui, sans-serif;
            }

            .admin-shell {
                display: flex;
                min-height: 100vh;
            }

            .admin-workspace {
                min-width: 0;
                flex: 1;
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
                border-color: rgba(15, 118, 110, 0.45) !important;
                box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12) !important;
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
                background: rgba(15, 118, 110, 0.03);
            }

            .admin-ui a.bg-blue-600,
            .admin-ui button.bg-blue-600 {
                background: var(--admin-primary) !important;
                border: 1px solid var(--admin-primary) !important;
                color: #fff !important;
                border-radius: 0.9rem !important;
                box-shadow: none !important;
            }

            .admin-ui a.bg-blue-600:hover,
            .admin-ui button.bg-blue-600:hover {
                background: #115e59 !important;
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

            .admin-sidebar {
                position: sticky;
                top: 0;
                display: none;
                width: 290px;
                min-height: 100vh;
                flex-shrink: 0;
                padding: 1rem;
            }

            .admin-sidebar__panel {
                display: flex;
                height: calc(100vh - 2rem);
                flex-direction: column;
                border: 1px solid var(--admin-border);
                border-radius: 1.5rem;
                background: rgba(255, 255, 255, 0.88);
                box-shadow: var(--admin-shadow);
                backdrop-filter: blur(18px);
            }

            .admin-sidebar__mobilebar {
                position: sticky;
                top: 0;
                z-index: 40;
                padding: 1rem 1rem 0;
            }

            .admin-sidebar__mobilebar-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                border: 1px solid var(--admin-border);
                border-radius: 1.25rem;
                background: rgba(255, 255, 255, 0.9);
                padding: 0.9rem 1rem;
                box-shadow: var(--admin-shadow);
                backdrop-filter: blur(18px);
            }

            .admin-page-header {
                padding: 1.25rem 1rem 0;
            }

            .admin-page-header__inner {
                background: rgba(255, 255, 255, 0.78);
                border: 1px solid var(--admin-border);
                border-radius: 1.25rem;
                padding: 1rem 1.25rem;
                box-shadow: var(--admin-shadow);
            }

            .admin-content {
                padding-bottom: 2rem;
            }

            .admin-content > * {
                max-width: 100%;
            }

            @media (min-width: 1024px) {
                .admin-sidebar {
                    display: block;
                }

                .admin-sidebar__mobilebar {
                    display: none;
                }

                .admin-workspace {
                    padding-right: 1rem;
                }

                .admin-page-header,
                .admin-content {
                    padding-left: 0;
                    padding-right: 1rem;
                }
            }
        </style>
    </head>
    <body class="admin-ui antialiased">
        <div class="admin-shell">
            @include('layouts.navigation')

            <div class="admin-workspace">
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
    </body>
</html>
