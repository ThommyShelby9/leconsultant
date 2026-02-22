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
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); margin: 0; }

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
        z-index: 200;
        box-shadow: 0 2px 16px rgba(11,45,94,0.06);
    }

    #logo a { display: flex; align-items: center; }
    #logo img { height: 38px; width: auto; }

    #main-menu-navigation {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        list-style: none;
        margin: 0; padding: 0;
    }
    #main-menu-navigation li a {
        display: inline-flex;
        align-items: center;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--muted);
        text-decoration: none;
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        transition: color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    #main-menu-navigation li a:hover { color: var(--blue); background: rgba(1,54,186,0.06); }
    #main-menu-navigation li.active a { color: var(--blue); font-weight: 600; }

    .nav-btn-outline {
        font-size: 0.875rem !important; font-weight: 600 !important;
        color: var(--blue) !important;
        border: 1.5px solid var(--blue);
        border-radius: 50px !important;
        padding: 0.4rem 1.1rem !important;
        transition: background 0.2s, color 0.2s !important;
    }
    .nav-btn-outline:hover { background: var(--blue) !important; color: var(--white) !important; }

    .nav-btn-filled {
        font-size: 0.875rem !important; font-weight: 600 !important;
        color: var(--white) !important;
        background: var(--blue);
        border-radius: 50px !important;
        padding: 0.4rem 1.1rem !important;
        box-shadow: 0 4px 14px rgba(1,54,186,0.2);
    }
    .nav-btn-filled:hover { background: #0140d4 !important; }

    .nav-logout a { color: var(--rouge) !important; }
    .nav-logout a:hover { background: rgba(200,16,46,0.07) !important; }

    .nav-sep {
        width: 4px; height: 4px;
        background: var(--border);
        border-radius: 50%;
        margin: 0 0.5rem;
    }

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
        gap: 5px; padding: 0;
    }
    #nav-toggle span {
        display: block;
        width: 18px; height: 2px;
        background: var(--blue);
        border-radius: 2px;
        transition: transform 0.25s, opacity 0.25s;
    }
    #nav-toggle[aria-expanded="true"] span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    #nav-toggle[aria-expanded="true"] span:nth-child(2) { opacity: 0; }
    #nav-toggle[aria-expanded="true"] span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* ── PROFILE BANNER ──────────────────────────────── */
    .profile-banner {
        background: var(--blue);
        padding: 2.5rem 0 5.5rem;
        position: relative;
        overflow: hidden;
        border-bottom: 3px solid var(--rouge);
    }
    .profile-banner::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse at 85% 50%, rgba(200,16,46,0.15) 0%, transparent 55%);
        pointer-events: none;
    }

    .profile-banner-inner {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 1.5rem;
        position: relative; z-index: 1;
    }

    /* Edit link top-right */
    .profile-edit-link {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.25rem;
    }
    .profile-edit-link a {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        color: rgba(255,255,255,0.65);
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.3rem 0.85rem;
        border-radius: 50px;
        transition: color 0.2s, border-color 0.2s, background 0.2s;
    }
    .profile-edit-link a:hover {
        color: #fff;
        border-color: rgba(255,255,255,0.45);
        background: rgba(255,255,255,0.07);
    }

    /* Avatar + info row */
    .profile-identity {
        display: flex;
        align-items: flex-start;
        gap: 2rem;
    }

    .profile-avatar-wrap {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    .profile-avatar-wrap img {
        width: 96px; height: 96px;
        border-radius: 20px;
        object-fit: cover;
        border: 2.5px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.1);
    }
    .avatar-action {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.72rem;
        font-weight: 600;
        text-decoration: none;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        transition: background 0.2s;
    }
    .avatar-action.modify {
        color: rgba(255,255,255,0.75);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .avatar-action.modify:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .avatar-action.delete {
        color: rgba(200,16,46,0.85);
        border: 1px solid rgba(200,16,46,0.3);
    }
    .avatar-action.delete:hover { background: rgba(200,16,46,0.1); }

    .profile-info { flex: 1; padding-top: 0.25rem; }
    .profile-fullname {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(1.6rem, 4vw, 2.4rem);
        color: #fff;
        margin: 0 0 0.25rem;
        line-height: 1.15;
    }
    .profile-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.15);
        margin: 0.75rem 0;
    }
    .profile-surmoi {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.75);
        line-height: 1.6;
        margin: 0;
    }
    .profile-surmoi-edit {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        margin-bottom: 0.5rem;
        transition: color 0.2s;
    }
    .profile-surmoi-edit:hover { color: rgba(255,255,255,0.85); }

    /* ── TABS ────────────────────────────────────────── */
    .tabs-wrapper {
        max-width: 860px;
        margin: -2.75rem auto 0;
        padding: 0 1.5rem;
        position: relative;
        z-index: 10;
    }

    .tabs-bar {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        display: flex;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(11,45,94,0.08);
    }

    .tab-item {
        flex: 1;
        text-align: center;
    }
    .tab-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.9rem 0.5rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--muted);
        text-decoration: none;
        border-bottom: 2.5px solid transparent;
        transition: color 0.2s, border-color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    .tab-link img { width: 16px; height: 16px; opacity: 0.5; transition: opacity 0.2s; }
    .tab-link:hover { color: var(--blue); background: rgba(1,54,186,0.04); }
    .tab-link:hover img { opacity: 0.8; }
    .tab-link.active {
        color: var(--blue);
        border-bottom-color: var(--blue);
        background: rgba(1,54,186,0.04);
    }
    .tab-link.active img { opacity: 1; }

    /* Dividers between tabs */
    .tab-item + .tab-item { border-left: 1px solid var(--border); }

    /* ── MAIN CONTENT ────────────────────────────────── */
    main {
        background: var(--bg);
        padding: 2rem 0 4rem;
    }

    .main-inner {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* ── FOOTER ──────────────────────────────────────── */
    footer {
        background: var(--blue);
        border-top: 3px solid var(--rouge);
        padding: 2rem 3rem;
        text-align: center;
        font-size: 0.8rem;
        color: rgba(255,255,255,0.45);
    }

    /* ── RESPONSIVE ──────────────────────────────────── */
    @media (max-width: 1024px) {
        #main-menu { padding: 0 1.25rem; flex-wrap: wrap; height: auto; min-height: 60px; }
        #logo { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0.75rem 0; }
        #nav-toggle { display: flex; }
        #main-menu-navigation {
            display: none; flex-direction: column; align-items: flex-start;
            width: 100%; padding: 0.5rem 0 1rem;
            border-top: 1px solid var(--border);
        }
        #main-menu-navigation.open { display: flex; }
        #main-menu-navigation li { width: 100%; }
        #main-menu-navigation li a { width: 100%; padding: 0.6rem 0.75rem; border-radius: 10px; }
        .nav-sep { display: none; }
    }

    @media (max-width: 700px) {
        .profile-identity { flex-direction: column; align-items: center; text-align: center; }
        .profile-avatar-wrap { align-items: center; }
        .profile-surmoi-edit { justify-content: center; width: 100%; }
        .profile-edit-link { justify-content: center; }
        .tabs-wrapper { padding: 0 0.75rem; margin-top: -2rem; }
        .tab-link { font-size: 0.72rem; padding: 0.75rem 0.25rem; gap: 0.3rem; }
        .tab-link span { display: none; }   /* hide label, keep icon on very small */
    }
    @media (max-width: 480px) {
        .tab-link span { display: inline; font-size: 0.68rem; }
    }
    </style>
</head>

<body>

    {{-- ── NAVBAR ── --}}
    <header>
        <nav id="main-menu">
            <div id="logo">
                <a href="{{ Route('welcome') }}">
                    <img src="{{ asset('assets/img/Logoconsultant%201.png') }}" alt="Le Consultant">
                </a>
                <button id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
                    <span></span><span></span><span></span>
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
                    <li class="{{ request()->routeIs('moncompte*') || request()->routeIs('mesSetting') || request()->routeIs('mesAbonnements') || request()->routeIs('mesformations') ? 'active' : '' }}">
                        <a href="{{ route('moncompte') }}">Mon compte</a>
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
                    <li><a href="{{ Route('login') }}" class="nav-btn-outline">Se connecter</a></li>
                    <li><a href="{{ Route('register.morale') }}" class="nav-btn-filled">S'inscrire</a></li>
                @endauth
            </ul>
        </nav>

        @yield('banner')

        {{-- ── PROFILE BANNER ── --}}
        <section class="profile-banner">
            <div class="profile-banner-inner">

                {{-- Edit link --}}
                <div class="profile-edit-link">
                    <a href="{{ route('moncompte.edit') }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Modifier le profil
                    </a>
                </div>

                {{-- Identity --}}
                <div class="profile-identity">
                    {{-- Avatar --}}
                    <div class="profile-avatar-wrap">
                        @if(!is_null(Auth::user()->logo))
                            <img src="{{ asset(Auth::user()->logo) }}" alt="Photo de profil">
                            <a href="{{ route('moncompte.photo.delete') }}" class="avatar-action delete">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                Supprimer
                            </a>
                        @else
                            <img src="{{ asset('profil_default.jpg') }}" alt="Photo de profil">
                        @endif
                        <a href="{{ route('moncompte.photo') }}" class="avatar-action modify">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            Modifier la photo
                        </a>
                    </div>

                    {{-- Name & bio --}}
                    <div class="profile-info">
                        <h1 class="profile-fullname">
                            {{ Auth::user()->nomSociete ?? (Auth::user()->nom.' '.Auth::user()->prenoms) }}
                        </h1>
                        <hr class="profile-divider">
                        <a href="{{ route('moncompte.surmoi') }}" class="profile-surmoi-edit">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Modifier ma description
                        </a>
                        <p class="profile-surmoi">{{ Auth::user()->surmoi ?? 'Aucune description renseignée.' }}</p>
                    </div>
                </div>

            </div>
        </section>

        {{-- ── TABS ── --}}
        <div class="tabs-wrapper">
            <nav class="tabs-bar" aria-label="Sections du compte">
                <div class="tab-item">
                    <a href="{{ route('moncompte') }}"
                       class="tab-link {{ request()->routeIs('moncompte') || request()->routeIs('moncompte.edit') ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/female.png') }}" alt="">
                        <span>Mon Profil</span>
                    </a>
                </div>
                <div class="tab-item">
                    <a href="{{ route('mesSetting') }}"
                       class="tab-link {{ request()->routeIs('mesSetting') ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/sett.png') }}" alt="">
                        <span>Paramètres</span>
                    </a>
                </div>
                <div class="tab-item">
                    <a href="{{ route('mesAbonnements') }}"
                       class="tab-link {{ request()->routeIs('mesAbonnements') ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/ticket.png') }}" alt="">
                        <span>Abonnement</span>
                    </a>
                </div>
                <div class="tab-item">
                    <a href="{{ route('mesformations') }}"
                       class="tab-link {{ request()->routeIs('mesformations') ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/grad.png') }}" alt="">
                        <span>Formations</span>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    {{-- ── MAIN ── --}}
    <main>
        <div class="main-inner">
            @yield('contenu')
        </div>
    </main>

    {{-- ── FOOTER ── --}}
    <footer>
        @include('layout.userLayout.footer')
    </footer>

    @include('includes.userLink.jsLink')
    @yield('code')

    <script>
    // Hamburger
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