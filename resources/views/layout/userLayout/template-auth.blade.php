<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @yield('titre')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    @include('includes.userLink.cssLink')

    <style>
    :root {
        --blue:   #0136ba;
        --rouge:  #C8102E;
        --bg:     #F5F4F0;
        --white:  #FFFFFF;
        --muted:  #6B7280;
        --border: #E5E3DC;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        margin: 0;
    }

    /* ── NAVBAR ──────────────────────────────────────── */
    #main-menu {
        background: var(--white);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 3rem;
        height: 68px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 16px rgba(11,45,94,0.06);
    }

    /* Logo */
    #logo a { display: flex; align-items: center; }
    #logo img { height: 38px; width: auto; }

    /* Nav list */
    #main-menu-navigation {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #main-menu-navigation li a {
        display: inline-flex;
        align-items: center;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--muted);
        text-decoration: none;
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        transition: color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    #main-menu-navigation li a:hover {
        color: var(--blue);
        background: rgba(1,54,186,0.06);
    }
    #main-menu-navigation li.active a,
    #main-menu-navigation li a.active {
        color: var(--blue);
        font-weight: 600;
    }

    /* CTA buttons in nav */
    .nav-btn-outline {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--blue) !important;
        border: 1.5px solid var(--blue);
        border-radius: 50px;
        padding: 0.4rem 1.1rem !important;
        transition: background 0.2s, color 0.2s !important;
    }
    .nav-btn-outline:hover {
        background: var(--blue) !important;
        color: var(--white) !important;
    }

    .nav-btn-filled {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--white) !important;
        background: var(--blue);
        border-radius: 50px;
        padding: 0.4rem 1.1rem !important;
        box-shadow: 0 4px 14px rgba(1,54,186,0.2);
        transition: background 0.2s, box-shadow 0.2s !important;
    }
    .nav-btn-filled:hover {
        background: #0140d4 !important;
        box-shadow: 0 6px 18px rgba(1,54,186,0.3) !important;
    }

    /* Déconnexion link */
    .nav-logout a {
        color: var(--rouge) !important;
    }
    .nav-logout a:hover {
        color: var(--rouge) !important;
        background: rgba(200,16,46,0.07) !important;
    }

    /* Separator dot between nav groups */
    .nav-sep {
        width: 4px; height: 4px;
        background: var(--border);
        border-radius: 50%;
        margin: 0 0.5rem;
        flex-shrink: 0;
    }

    /* ── HAMBURGER ───────────────────────────────────── */
    #nav-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 36px; height: 36px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        background: transparent;
        cursor: pointer;
        gap: 5px;
        padding: 0;
    }
    #nav-toggle span {
        display: block;
        width: 18px; height: 2px;
        background: var(--blue);
        border-radius: 2px;
        transition: transform 0.25s, opacity 0.25s;
    }
    #nav-toggle[aria-expanded="true"] span:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }
    #nav-toggle[aria-expanded="true"] span:nth-child(2) {
        opacity: 0;
    }
    #nav-toggle[aria-expanded="true"] span:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
    }

    /* ── RESPONSIVE NAV ──────────────────────────────── */
    @media (max-width: 1024px) {
        #main-menu {
            padding: 0 1.25rem;
            flex-wrap: wrap;
            height: auto;
            min-height: 60px;
        }

        #logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.75rem 0;
        }

        #nav-toggle { display: flex; }

        #main-menu-navigation {
            display: none;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            padding: 0.5rem 0 1rem;
            gap: 0.1rem;
            border-top: 1px solid var(--border);
        }
        #main-menu-navigation.open { display: flex; }

        #main-menu-navigation li { width: 100%; }
        #main-menu-navigation li a {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border-radius: 10px;
        }

        .nav-sep { display: none; }

        .nav-btn-outline,
        .nav-btn-filled {
            border-radius: 10px !important;
            width: 100%;
            justify-content: center;
        }
    }

    /* ── MAIN ────────────────────────────────────────── */
    main {
        min-height: calc(100vh - 68px);
    }
    main.page-auth {
        background: var(--bg);
    }
    main.page-default {
        padding: 3rem 0;
    }

    /* ── FOOTER ──────────────────────────────────────── */
    footer {
        background: var(--blue);
        border-top: 3px solid var(--rouge);
        padding: 2rem 3rem;
        text-align: center;
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
        font-family: 'DM Sans', sans-serif;
    }
    </style>
</head>

<body>
    <header>
        <nav id="main-menu">
            <div id="logo">
                <a href="{{ Route('welcome') }}">
                    <img src="{{ asset('assets/img/Logoconsultant%201.png') }}" alt="Le Consultant">
                </a>

                {{-- Hamburger (mobile) --}}
                <button id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <ul id="main-menu-navigation">

                <li class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                    <a href="{{ Route('welcome') }}">Accueil</a>
                </li>

                <li class="{{ request()->routeIs('offre*') ? 'active' : '' }}">
                    <a href="{{ Route('offre') }}">Appels d'offres</a>
                </li>

                @auth
                    <div class="nav-sep"></div>

                    <li class="{{ request()->routeIs('register.morale') ? 'active' : '' }}">
                        <a href="{{ route('register.morale') }}">Mon compte</a>
                    </li>

                    <li class="nav-logout">
                        <a href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnecter
                        </a>
                    </li>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>

                @else
                    <div class="nav-sep"></div>

                    <li>
                        <a href="{{ Route('login') }}" class="nav-btn-outline">Se connecter</a>
                    </li>
                    <li>
                        <a href="{{ Route('register.morale') }}" class="nav-btn-filled">S'inscrire</a>
                    </li>
                @endauth

            </ul>
        </nav>

        @yield('banner')
    </header>

    <main class="{{ request()->routeIs('register.*') ? 'page-auth' : 'page-default' }}">
        @yield('contenu')
    </main>

    <footer>
        &copy; {{ date('Y') }} Le Consultant — Tous droits réservés.
    </footer>

    @include('includes.userLink.jsLink')

    @yield('code')

    @include('components.loader')

    <script>
    // Hamburger toggle
    const toggle = document.getElementById('nav-toggle');
    const menu   = document.getElementById('main-menu-navigation');
    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            const open = menu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
        });
    }
    </script>
</body>

</html>