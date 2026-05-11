<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Applique le thème avant le rendu pour éviter le flash -->
    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Vite / Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Correctif : Tailwind génère .collapse{visibility:collapse} qui masque la navbar Bootstrap -->
    <style>
        .collapse { visibility: visible; }
    </style>
</head>
<body class="font-sans antialiased">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Les assos</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('association') ? 'active' : '' }}" href="{{ route('association') }}">
                            {{ __('messages.association_list') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            {{ __('messages.contact') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('api.explorer') ? 'active' : '' }}" href="{{ route('api.explorer') }}">
                            API
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Bouton mode sombre -->
                    <li class="nav-item me-2">
                        <button class="btn btn-link nav-link text-white p-1" onclick="toggleTheme()" title="Changer de thème">
                            <i class="bi bi-moon-fill fs-5" id="theme-icon"></i>
                        </button>
                    </li>

                    <!-- Sélecteur de langue -->
                    <li class="nav-item dropdown me-3">
                        @php $currentLocale = session('locale', app()->getLocale()); @endphp
                        <a class="nav-link dropdown-toggle text-white" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown">
                            {{ strtoupper($currentLocale) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                            <li><a class="dropdown-item" href="{{ route('change.lang', 'fr') }}">FR</a></li>
                            <li><a class="dropdown-item" href="{{ route('change.lang', 'en') }}">EN</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown utilisateur -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Gestion du mode sombre -->
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-bs-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (!icon) return;
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const theme = localStorage.getItem('theme') || 'light';
            updateThemeIcon(theme);
        });
    </script>

    @yield('scripts')
</body>
</html>
