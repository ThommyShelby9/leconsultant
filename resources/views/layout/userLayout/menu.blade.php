<style>
/* ── RESET & BASE ───────────────────────────────── */
#navbar {
    position: sticky;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    width: 100%;
    background: #fff;
    border-bottom: 1px solid #E5E3DC;
    transition: box-shadow 0.3s;
    box-sizing: border-box;
}
#navbar.scrolled {
    box-shadow: 0 4px 24px rgba(11,45,94,0.1);
}

/* ── INNER WRAPPER ──────────────────────────────── */
.nb-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 68px;
    padding: 0 1.5rem;
    width: 100%;
    box-sizing: border-box;
    position: relative;
}

/* ── LOGO ───────────────────────────────────────── */
.nb-logo {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    text-decoration: none;
    z-index: 2;
}
.nb-logo img {
    height: 40px;
    width: auto;
}

/* ── BURGER BUTTON ──────────────────────────────── */
.nb-burger {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5px;
    width: 42px;
    height: 42px;
    background: #F5F4F0;
    border: 1.5px solid #E5E3DC;
    border-radius: 10px;
    cursor: pointer;
    flex-shrink: 0;
    padding: 0;
    z-index: 2;
    -webkit-tap-highlight-color: transparent;
    outline: none;
}
.nb-burger:active { background: #eae9e5; }
.nb-burger span {
    display: block;
    width: 20px;
    height: 2px;
    background: #0B2D5E;
    border-radius: 2px;
    transition: transform 0.28s ease, opacity 0.2s ease;
}
.nb-burger.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nb-burger.is-open span:nth-child(2) { opacity: 0; }
.nb-burger.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ── DESKTOP MENU ───────────────────────────────── */
.nb-menu {
    display: flex;
    align-items: center;
    gap: 0.2rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nb-sep {
    width: 1px;
    height: 18px;
    background: #E5E3DC;
    margin: 0 0.3rem;
    flex-shrink: 0;
    display: block;
}

.nb-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.48rem 0.85rem;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 500;
    color: #0B2D5E;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.18s, color 0.18s;
    background: transparent;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
}
.nb-link:hover     { background: rgba(11,45,94,0.07); }
.nb-link.is-active { background: rgba(11,45,94,0.09); font-weight: 600; }
.nb-link.is-red    { color: #C8102E; }
.nb-link.is-red:hover { background: rgba(200,16,46,0.07); }

.nb-btn-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.48rem 1.1rem;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: #0B2D5E;
    border: 1.5px solid #E5E3DC;
    text-decoration: none;
    white-space: nowrap;
    transition: border-color 0.18s, background 0.18s;
    box-sizing: border-box;
}
.nb-btn-outline:hover { border-color: #0B2D5E; background: rgba(11,45,94,0.04); }

.nb-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.48rem 1.2rem;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 700;
    color: #fff;
    background: #C8102E;
    border: none;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    transition: background 0.18s;
    box-sizing: border-box;
}
.nb-btn-primary:hover { background: #a50d26; }

/* ── MOBILE ─────────────────────────────────────── */
@media (max-width: 1023px) {
    .nb-burger { display: flex; }

    .nb-menu {
        display: none;
        position: absolute;
        top: 68px;
        left: 0;
        right: 0;
        width: 100%;
        background: #fff;
        border-top: 1px solid #E5E3DC;
        box-shadow: 0 16px 40px rgba(11,45,94,0.12);
        flex-direction: column;
        align-items: stretch;
        gap: 0.3rem;
        padding: 0.75rem 1rem 1.25rem;
        box-sizing: border-box;
    }

    .nb-menu.is-open { display: flex; }

    .nb-sep {
        width: 100%;
        height: 1px;
        margin: 0.2rem 0;
    }

    .nb-link {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        justify-content: flex-start;
        box-sizing: border-box;
    }

    .nb-btn-outline {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .nb-btn-primary {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
    }
}
</style>

<nav id="navbar">
    <div class="nb-inner">

        {{-- Logo --}}
        <a href="{{ Route('welcome') }}" class="nb-logo">
            <img src="{{ asset('assets/img/Logoconsultant%201.png') }}" alt="Le Consultant">
        </a>

        {{-- Burger (mobile only) --}}
        <button class="nb-burger" id="nb-burger" aria-label="Ouvrir le menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        {{-- Navigation --}}
        <ul class="nb-menu" id="nb-menu">

            <li>
                <a href="{{ Route('welcome') }}"
                   class="nb-link {{ request()->routeIs('welcome') ? 'is-active' : '' }}">
                    Accueil
                </a>
            </li>

            <li>
                <a href="{{ Route('offre') }}"
                   class="nb-link {{ request()->routeIs('offre') ? 'is-active' : '' }}">
                    Appels d'offres
                </a>
            </li>

            @auth
                <li><span class="nb-sep"></span></li>

                <li>
                    <a href="{{ Route('alerte') }}"
                       class="nb-link is-red {{ request()->routeIs('alerte') ? 'is-active' : '' }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Mes alertes
                    </a>
                </li>

                <li>
                    <a href="{{ route('moncompte') }}"
                       class="nb-link {{ request()->routeIs('moncompte') ? 'is-active' : '' }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        Mon compte
                    </a>
                </li>

                <li><span class="nb-sep"></span></li>

                <li>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                    <button class="nb-link is-red"
                            onclick="document.getElementById('logout-form').submit()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Déconnexion
                    </button>
                </li>

            @else
                <li><span class="nb-sep"></span></li>

                <li>
                    <a href="{{ Route('login') }}" class="nb-btn-outline">Se connecter</a>
                </li>
                <li>
                    <a href="{{ Route('register.morale') }}" class="nb-btn-outline">S'inscrire</a>
                </li>
            @endauth

        </ul>

    </div>
</nav>

<script>
(function () {
    var burger = document.getElementById('nb-burger');
    var menu   = document.getElementById('nb-menu');
    var navbar = document.getElementById('navbar');

    burger.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = menu.classList.toggle('is-open');
        burger.classList.toggle('is-open', isOpen);
        burger.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('click', function (e) {
        if (!navbar.contains(e.target)) {
            menu.classList.remove('is-open');
            burger.classList.remove('is-open');
            burger.setAttribute('aria-expanded', 'false');
        }
    });

    window.addEventListener('scroll', function () {
        navbar.classList.toggle('scrolled', window.scrollY > 8);
    });
})();
</script>