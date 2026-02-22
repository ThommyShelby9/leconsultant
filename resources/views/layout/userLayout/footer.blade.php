<style>
footer {
    background: var(--blue, #0136ba);
    position: relative;
    overflow: hidden;
}

footer::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 90% 0%, rgba(200,16,46,0.12) 0%, transparent 60%);
    pointer-events: none;
}

.footer-inner {
    position: relative; z-index: 1;
    padding: 4rem 0 2rem;
}

/* ── DIVIDER ───────────────────────────────────── */
.footer-divider {
    height: 1px;
    background: rgba(255,255,255,0.08);
    margin: 2.5rem 0;
}

/* ── SECTION TITLE ─────────────────────────────── */
.footer-section-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.35rem;
    color: #fff;
    margin: 0 0 0.5rem;
    padding-left: 1rem;
    border-left: 3px solid #C8102E;
    line-height: 1.3;
}

.footer-section-sub {
    color: rgba(255,255,255,0.5);
    font-size: 0.82rem;
    padding-left: 1rem;
    margin-bottom: 1.5rem;
}

.footer-text {
    color: rgba(255,255,255,0.62);
    font-size: 0.875rem;
    line-height: 1.75;
    padding-left: 1rem;
    margin-bottom: 1.75rem;
}

/* ── SOCIAL ICONS ──────────────────────────────── */
.social-list {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding-left: 1rem;
    list-style: none;
    margin: 0; padding-top: 0;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
}
.social-link:hover {
    background: #C8102E;
    border-color: #C8102E;
    color: #fff;
    transform: translateY(-3px);
}

/* ── NEWSLETTER FORM ───────────────────────────── */
.newsletter-form {
    display: flex;
    gap: 0.5rem;
    padding-left: 1rem;
    flex-wrap: wrap;
}

.newsletter-input {
    flex: 1 1 200px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 10px;
    padding: 0.7rem 1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    color: #fff;
    outline: none;
    transition: border-color 0.2s, background 0.2s;
}
.newsletter-input::placeholder { color: rgba(255,255,255,0.35); }
.newsletter-input:focus {
    border-color: rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.12);
}

.newsletter-btn {
    background: #C8102E;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.7rem 1.4rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.2s, transform 0.15s;
    display: inline-flex; align-items: center; gap: 0.4rem;
}
.newsletter-btn:hover { background: #a50d26; transform: translateY(-2px); }

/* ── BOTTOM BAR ────────────────────────────────── */
.footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.footer-copy {
    color: rgba(255,255,255,0.35);
    font-size: 0.78rem;
}
.footer-copy strong { color: rgba(255,255,255,0.6); font-weight: 600; }

.footer-links {
    display: flex;
    gap: 1.25rem;
    list-style: none;
    margin: 0; padding: 0;
}
.footer-links a {
    color: rgba(255,255,255,0.35);
    font-size: 0.78rem;
    text-decoration: none;
    transition: color 0.2s;
}
.footer-links a:hover { color: rgba(255,255,255,0.75); }

@media (max-width: 640px) {
    .footer-bottom { flex-direction: column; text-align: center; }
    .footer-links { justify-content: center; }
    .newsletter-form { padding-left: 0; }
    .social-list { padding-left: 0; }
    .footer-text,
    .footer-section-title,
    .footer-section-sub { padding-left: 0; }
}
</style>

<footer>
    <div class="footer-inner">
        <div class="container mx-auto px-4">

            <div class="grid lg:grid-cols-2 grid-cols-1 gap-12 mb-4">

                <!-- Suivez-nous -->
                <div>
                    <div class="footer-section-title">Suivez-nous</div>
                    <div class="footer-section-sub">Restez connectés à notre communauté</div>
                    <p class="footer-text">
                        Suivez Le Consultant sur nos réseaux sociaux et soyez les premiers informés des dernières actualités, conseils exclusifs et opportunités de marchés publics et privés.
                    </p>
                    <ul class="social-list">
                        <li>
                            <a href="#" class="social-link" aria-label="Facebook">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="social-link" aria-label="LinkedIn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="social-link" aria-label="Twitter / X">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <div class="footer-section-title">Newsletter</div>
                    <div class="footer-section-sub">Recevez les offres directement par mail</div>
                    <p class="footer-text">
                        Abonnez-vous pour recevoir toutes les informations pertinentes sur les appels d'offres, les conseils d'experts et les dernières tendances en matière de marchés publics.
                    </p>
                    <div class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Votre adresse e-mail" />
                        <button type="button" class="newsletter-btn">
                            S'inscrire
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

            </div>

            <div class="footer-divider"></div>

            <!-- Bottom bar -->
            <div class="footer-bottom">
                <p class="footer-copy">
                    &copy; 2026 <strong>Le Consultant</strong> — Bénin. Tous droits réservés.
                </p>
                <ul class="footer-links">
                    <li><a href="#">Mentions légales</a></li>
                    <li><a href="#">Confidentialité</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>