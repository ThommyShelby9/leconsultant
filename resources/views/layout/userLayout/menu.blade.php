<style>
/* ── NAVBAR ─────────────────────────────────────── */
#navbar {
    position: sticky; top: 0; z-index: 100;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border, #E5E3DC);
    transition: box-shadow 0.3s;
}
#navbar.scrolled {
    box-shadow: 0 4px 24px rgba(11,45,94,0.09);
}

.navbar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    gap: 1.5rem;
}

/* ── LOGO ───────────────────────────────────────── */
.navbar-logo img {
    height: 42px;
    width: auto;
    display: block;
    transition: opacity 0.2s;
}
.navbar-logo:hover img { opacity: 0.82; }

/* ── DESKTOP MENU ───────────────────────────────── */
.nav-menu {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    list-style: none;
    margin: 0; padding: 0;
}

.nav-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.5rem 0.85rem;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--blue, #0B2D5E);
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
    white-space: nowrap;
}
.nav-link:hover { background: rgba(11,45,94,0.06); }
.nav-link.active {
    background: rgba(11,45,94,0.08);
    font-weight: 600;
}

/* Alert link — subtle accent */
.nav-link.accent {
    color: var(--rouge, #C8102E);
}
.nav-link.accent:hover { background: rgba(200,16,46,0.06); }

/* Divider between groups */
.nav-divider {
    width: 1px; height: 20px;
    background: var(--border, #E5E3DC);
    margin: 0 0.25rem;
}

/* CTA buttons */
.nav-btn-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.1rem;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--blue, #0B2D5E);
    border: 1.5px solid var(--border, #E5E3DC);
    text-decoration: none;
    transition: border-color 0.2s, background 0.2s;
    white-space: nowrap;
}
.nav-btn-outline:hover { border-color: rgba(11,45,94,0.35); background: rgba(11,45,94,0.04); }

.nav-btn-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.2rem;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 700;
    color: #fff;
    background: var(--rouge, #C8102E);
    border: none;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    white-space: nowrap;
}
.nav-btn-primary:hover { background: #a50d26; transform: translateY(-1px); }

/* Logout — text only */
.nav-logout {
    background: none; border: none;
    cursor: pointer; padding: 0;
    font-family: inherit;
}

/* ── MOBILE TOGGLE ──────────────────────────────── */
.nav-toggle {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5px;
    width: 38px; height: 38px;
    border-radius: 8px;
    background: transparent;
    border: 1.5px solid var(--border, #E5E3DC);
    cursor: pointer;
    padding: 0;
    transition: background 0.2s;
}
.nav-toggle:hover { background: rgba(11,45,94,0.05); }
.nav-toggle span {
    display: block;
    width: 18px; height: 2px;
    background: var(--blue, #0B2D5E);
    border-radius: 2px;
    transition: transform 0.3s, opacity 0.3s, width 0.3s;
    transform-origin: center;
}

/* open state */
.nav-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nav-toggle.open span:nth-child(2) { opacity: 0; width: 0; }
.nav-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ── MOBILE MENU ────────────────────────────────── */
@media (max-width: 1023px) {
    .nav-toggle { display: flex; }

    .nav-menu {
        display: none;
        position: absolute;
        top: 70px; left: 0; right: 0;
        background: #fff;
        border-top: 1px solid var(--border, #E5E3DC);
        border-bottom: 1px solid var(--border, #E5E3DC);
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        padding: 0.75rem 1rem 1rem;
        box-shadow: 0 12px 32px rgba(11,45,94,0.1);
    }

    .nav-menu.open { display: flex; }

    .nav-divider { display: none; }

    .nav-link,
    .nav-btn-outline,
    .nav-btn-primary,
    .nav-logout .nav-link {
        width: 100%;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
    }

    .nav-btn-primary {
        margin-top: 0.25rem;
        justify-content: center;
    }

    .nav-btn-outline {
        justify-content: flex-start;
    }
}
</style>

<nav id="navbar">
    <div class="container mx-auto px-4">
        <div class="navbar-inner">

            <!-- Logo -->
            <a href="{{ Route('welcome') }}" class="navbar-logo flex-shrink-0">
                <img src="{{ asset('assets/img/Logoconsultant%201.png') }}" alt="Le Consultant">
            </a>

            <!-- Mobile toggle -->
            <button class="nav-toggle" id="nav-toggle" aria-label="Menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Menu -->
            <ul class="nav-menu" id="main-menu-navigation">

                <!-- Public links -->
                <li>
                    <a href="{{ Route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                        Accueil
                    </a>
                </li>
                <li>
                    <a href="{{ Route('offre') }}" class="nav-link {{ request()->routeIs('offre') ? 'active' : '' }}">
                        Appels d'offres
                    </a>
                </li>

                @auth
                    <li><span class="nav-divider"></span></li>

                    <li>
                        <a href="{{ Route('alerte') }}" class="nav-link accent {{ request()->routeIs('alerte') ? 'active' : '' }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            Mes alertes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('moncompte') }}" class="nav-link {{ request()->routeIs('moncompte') ? 'active' : '' }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            Mon compte
                        </a>
                    </li>

                    <li><span class="nav-divider"></span></li>

                    <li>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
                        <button class="nav-logout" onclick="document.getElementById('logout-form').submit()">
                            <span class="nav-link" style="color: var(--rouge, #C8102E);">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Déconnexion
                            </span>
                        </button>
                    </li>

                @else
                    <li><span class="nav-divider"></span></li>

                    <li>
                        <a href="{{ Route('login') }}" class="nav-btn-outline">
                            Se connecter
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('register.morale') }}" class="nav-btn-primary">
                            S'inscrire
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<script>
(function () {
    const toggle = document.getElementById('nav-toggle');
    const menu   = document.getElementById('main-menu-navigation');
    const navbar = document.getElementById('navbar');

    // Toggle mobile menu
    toggle.addEventListener('click', function () {
        const isOpen = menu.classList.toggle('open');
        toggle.classList.toggle('open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen);
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
        if (!navbar.contains(e.target)) {
            menu.classList.remove('open');
            toggle.classList.remove('open');
            toggle.setAttribute('aria-expanded', false);
        }
    });

    // Scroll shadow
    window.addEventListener('scroll', function () {
        navbar.classList.toggle('scrolled', window.scrollY > 10);
    });
})();
</script>