<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <!-- Logo / Nom du site -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Mon Site
        </a>

        <!-- Bouton responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens de navigation -->
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

            <!-- Dropdown utilisateur + langue -->
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Bouton mode sombre -->
                <li class="nav-item me-2">
                    <button class="btn btn-link nav-link text-white p-1" onclick="toggleTheme()" title="Changer de thème">
                        <i class="bi bi-moon-fill fs-5" id="theme-icon"></i>
                    </button>
                </li>

                <!-- Sélecteur de langue -->
                <li class="nav-item dropdown me-3">
                    @php
                        $currentLocale = session('locale', app()->getLocale());
                    @endphp
                    <a class="nav-link dropdown-toggle text-white" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown">
                        {{ strtoupper($currentLocale) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('change.lang', 'fr') }}">FR</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('change.lang', 'en') }}">EN</a>
                        </li>
                    </ul>
                </li>

                <!-- Dropdown utilisateur -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
