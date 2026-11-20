<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIGAPRODUCTION') | CV. Sigaproduction</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    @media (min-width: 1024px) {
        #sidebar.desktop-collapsed { transform: translateX(-100%); }
        #mainContent.sidebar-expanded { margin-left: 0 !important; }
    }
    /* custom background images */
    body {
        font-family: 'Inter', sans-serif;
    }
    /* Sidebar background */
    #sidebar {
        background-image: url('{{ asset('images/sigaproduction/post-04-guitar.webp') }}');
        background-size: cover;
        background-position: center;
    }
    /* Header background */
    header.bg-slate-900\/95 {
        background-image: url('{{ asset('images/sigaproduction/post-06-drumsticks.webp') }}');
        background-size: cover;
        background-position: center;
    }
    /* Main content background */
    main#mainContent {
        background-image: url('{{ asset('images/sigaproduction/post-07-shirt.webp') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-slate-950 font-sans text-slate-100">
<div class="min-h-screen flex">
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <aside id="sidebar" class="flex w-72 bg-slate-950 text-white flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="px-7 py-7 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center text-2xl">🎵</div>
                <div>
                    <h1 class="font-bold text-lg tracking-wide">SIGAPRODUCTION</h1>
                    <p class="text-xs text-slate-400">Company Management System</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-7">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3">Overview</p>
                <a href="{{ route('home') }}"
                   @if(request()->routeIs('home')) aria-current="page" @endif
                   @class(['sidebar-nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition', 'bg-blue-500 text-white font-medium' => request()->routeIs('home'), 'text-slate-400' => !request()->routeIs('home')])>
                    <span>▦</span> Dashboard
                </a>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3">Business Units</p>
                <a href="{{ route('business-units.index') }}"
                   @if(request()->routeIs('business-units.*')) aria-current="page" @endif
                   @class(['sidebar-nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition', 'bg-blue-500 text-white font-medium' => request()->routeIs('business-units.*'), 'text-slate-400' => !request()->routeIs('business-units.*')])>
                    <span>♫</span> Business Units
                </a>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3">Management</p>
                <a href="{{ route('customers.index') }}"
                   @if(request()->routeIs('customers.*')) aria-current="page" @endif
                   @class(['sidebar-nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition', 'bg-blue-500 text-white font-medium' => request()->routeIs('customers.*'), 'text-slate-400' => !request()->routeIs('customers.*')])>
                    <span>♙</span> Customers & Clients
                </a>
                <a href="{{ route('bookings.index') }}"
                   @if(request()->routeIs('bookings.*')) aria-current="page" @endif
                   @class(['sidebar-nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition', 'bg-blue-500 text-white font-medium' => request()->routeIs('bookings.*'), 'text-slate-400' => !request()->routeIs('bookings.*')])>
                    <span>▤</span> Bookings & Orders
                </a>
                <a href="{{ route('transactions.index') }}"
                   @if(request()->routeIs('transactions.index', 'transactions.create', 'transactions.show', 'transactions.edit')) aria-current="page" @endif
                   @class(['sidebar-nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition', 'bg-blue-500 text-white font-medium' => request()->routeIs('transactions.index', 'transactions.create', 'transactions.show', 'transactions.edit'), 'text-slate-400' => !request()->routeIs('transactions.index', 'transactions.create', 'transactions.show', 'transactions.edit')])>
                    <span>Rp</span> Finance & Transactions
                </a>
                <a href="{{ route('transactions.history') }}"
                   @if(request()->routeIs('transactions.history')) aria-current="page" @endif
                   @class(['sidebar-nav-link mt-2 flex items-center gap-3 px-4 py-3 rounded-xl transition', 'bg-blue-500 text-white font-medium' => request()->routeIs('transactions.history'), 'text-slate-400' => !request()->routeIs('transactions.history')])>
                    <span>◷</span> Riwayat Transaksi
                </a>
            </div>
        </nav>

        <div class="p-5 border-t border-slate-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-sm text-red-400 hover:bg-red-500/10 transition">
                    ↪ Logout
                </button>
            </form>
        </div>
    </aside>

    <main id="mainContent" class="flex-1 lg:ml-72 min-w-0 transition-all duration-300">
        <header class="bg-slate-900/95 border-b border-slate-800 sticky top-0 z-30 backdrop-blur">
            <div class="px-5 lg:px-9 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" id="sidebarToggle" aria-label="Tutup menu navigasi" aria-expanded="true" aria-controls="sidebar"
                            class="w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-xl border border-slate-700 text-slate-200 hover:bg-slate-800 transition">
                        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="min-w-0">
                        <p class="text-xs text-slate-500 truncate">CV. Sigaproduction / @yield('breadcrumb', 'Overview')</p>
                        <h2 class="text-xl font-bold text-white truncate">@yield('page-title', 'Dashboard')</h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:block">
                        <input type="search" placeholder="Search anything..." class="w-56 lg:w-64 rounded-xl border border-slate-700 bg-slate-950 text-slate-100 placeholder:text-slate-500 px-4 py-2.5 text-sm outline-none focus:border-blue-400">
                    </div>
                    <button type="button" aria-label="Notifications" class="w-10 h-10 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800">♧</button>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-sm font-semibold text-slate-100">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-5 lg:p-9 min-h-[calc(100vh-73px)]">
            @yield('content')
        </div>
    </main>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleButton = document.getElementById('sidebarToggle');
    const menuIcon = document.getElementById('menuIcon');
    const mainContent = document.getElementById('mainContent');

    if (!sidebar || !overlay || !toggleButton || !menuIcon || !mainContent) return;

    const desktopBreakpoint = 1024;
    let isDesktop = window.innerWidth >= desktopBreakpoint;

    function setMenuIcon(isOpen) {
        toggleButton.setAttribute('aria-expanded', String(isOpen));
        toggleButton.setAttribute(
            'aria-label',
            isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'
        );

        menuIcon.innerHTML = isOpen
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />';
    }

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full', 'desktop-collapsed');
        mainContent.classList.remove('sidebar-expanded');

        // Overlay hanya digunakan pada layar kecil.
        if (window.innerWidth < desktopBreakpoint) {
            overlay.classList.remove('hidden');
        } else {
            overlay.classList.add('hidden');
        }

        setMenuIcon(true);
    }

    function closeSidebar() {
        overlay.classList.add('hidden');

        if (window.innerWidth >= desktopBreakpoint) {
            sidebar.classList.add('desktop-collapsed');
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('sidebar-expanded');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('desktop-collapsed');
            mainContent.classList.remove('sidebar-expanded');
        }

        setMenuIcon(false);
    }

    if (isDesktop) {
        openSidebar();
    } else {
        closeSidebar();
    }

    // Tombol menu untuk membuka dan menutup sidebar.
    toggleButton.addEventListener('click', function (event) {
        event.stopPropagation();

        if (toggleButton.getAttribute('aria-expanded') === 'true') {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // Klik overlay menutup sidebar.
    overlay.addEventListener('click', closeSidebar);

    // Klik di luar sidebar menutup sidebar.
    document.addEventListener('click', function (event) {
        const isOpen = toggleButton.getAttribute('aria-expanded') === 'true';

        if (
            isOpen &&
            !sidebar.contains(event.target) &&
            !toggleButton.contains(event.target)
        ) {
            closeSidebar();
        }
    });

    // Tombol Escape juga menutup sidebar.
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    // Klik menu navigasi pada layar kecil menutup sidebar.
    sidebar.querySelectorAll('nav a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < desktopBreakpoint) {
                closeSidebar();
            }
        });
    });

    // Menyesuaikan sidebar ketika ukuran layar berubah.
    window.addEventListener('resize', function () {
        const nowDesktop = window.innerWidth >= desktopBreakpoint;

        if (nowDesktop !== isDesktop) {
            isDesktop = nowDesktop;

            if (isDesktop) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }
    });
});
</script>
@stack('scripts')
</body>
</html>
