@extends('layout.userLayout.template-auth')

@section('titre')
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<title>Le Consultant | Inscription — Personne Morale</title>
@endsection

@section('banner')
<section class="page-banner">
    <div class="page-banner-inner">
        <div class="page-banner-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/>
            </svg>
        </div>
        <h1 class="page-banner-title">Inscription</h1>
        <p class="page-banner-sub">Créez votre espace entreprise sur la plateforme</p>
    </div>
</section>
@endsection

@section('contenu')
<style>
/* ── BANNER ──────────────────────────────────────── */
.page-banner {
    background: var(--blue);
    border-bottom: 3px solid var(--rouge);
    padding: 3rem 1.5rem;
    position: relative; overflow: hidden;
    text-align: center;
}
.page-banner::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 50%, rgba(200,16,46,0.15) 0%, transparent 55%);
    pointer-events: none;
}
.page-banner-inner { position: relative; z-index: 1; }
.page-banner-icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.2);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
}
.page-banner-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    color: #fff; margin: 0 0 0.5rem; line-height: 1.1;
}
.page-banner-sub { font-size: 0.9rem; color: rgba(255,255,255,0.6); margin: 0; }

/* ── PAGE WRAPPER ────────────────────────────────── */
.register-page { padding: 2.5rem 1rem 4rem; }

/* ── TYPE SWITCHER ───────────────────────────────── */
.type-switcher {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
}
.type-switcher-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--muted);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-right: 0.25rem;
}
.type-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    border: 1.5px solid var(--border);
    color: var(--muted);
    background: var(--white);
    transition: all 0.2s;
}
.type-btn:hover { border-color: var(--blue); color: var(--blue); }
.type-btn.active {
    background: var(--blue);
    border-color: var(--blue);
    color: #fff;
    box-shadow: 0 4px 14px rgba(1,54,186,0.2);
}

/* ── CARD ────────────────────────────────────────── */
.register-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    max-width: 720px;
    margin: 0 auto;
    box-shadow: 0 8px 40px rgba(11,45,94,0.07);
}

/* ── CARD HEADER ─────────────────────────────────── */
.register-card-header {
    background: var(--blue);
    padding: 1.75rem 2rem;
    position: relative; overflow: hidden;
    border-bottom: 3px solid var(--rouge);
}
.register-card-header::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 90% 50%, rgba(200,16,46,0.18) 0%, transparent 60%);
    pointer-events: none;
}
.register-header-inner {
    display: flex; align-items: center; gap: 1.25rem;
    position: relative; z-index: 1;
}
.register-avatar {
    width: 56px; height: 56px;
    border-radius: 14px;
    background: rgba(255,255,255,0.12);
    border: 1.5px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.register-card-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.35rem; color: #fff;
    margin: 0 0 0.2rem; line-height: 1.2;
}
.register-badge {
    display: inline-flex; align-items: center; gap: 0.35rem;
    background: rgba(200,16,46,0.25);
    border: 1px solid rgba(200,16,46,0.4);
    color: rgba(255,255,255,0.85);
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    padding: 0.2rem 0.65rem; border-radius: 50px;
}
.register-badge span { width: 5px; height: 5px; background: var(--rouge); border-radius: 50%; }

/* ── SECTIONS ────────────────────────────────────── */
.register-section { padding: 1.75rem 2rem; }
.register-section + .register-section { border-top: 1px solid var(--border); }
.register-section-title {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.register-section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

/* ── FORM GRID ───────────────────────────────────── */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-item { display: flex; flex-direction: column; gap: 0.4rem; }
.form-item.full { grid-column: 1 / -1; }

.form-label {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase;
    color: var(--muted); display: flex; align-items: center; gap: 0.4rem;
}
.form-input, .form-select {
    width: 100%; padding: 0.75rem 1rem;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem; font-weight: 500; color: var(--blue);
    outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none; -webkit-appearance: none;
}
.form-input::placeholder { color: var(--muted); font-weight: 400; }
.form-input:focus, .form-select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(1,54,186,0.08);
}
.form-input.is-invalid { border-color: var(--rouge); }
.form-input.is-valid   { border-color: #16a34a; }

.select-wrap { position: relative; }
.select-wrap::after {
    content: ''; position: absolute; right: 1rem; top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 4px solid transparent; border-right: 4px solid transparent;
    border-top: 5px solid var(--muted); pointer-events: none;
}
.select-wrap .form-select { padding-right: 2.5rem; cursor: pointer; }

/* Field validation messages */
.field-msg {
    font-size: 0.72rem; font-weight: 600;
    min-height: 1rem; display: block;
    transition: color 0.2s;
}
.field-msg.error { color: var(--rouge); }
.field-msg.success { color: #16a34a; }

/* ── CHECKBOXES ──────────────────────────────────── */
.check-list { display: flex; flex-direction: column; gap: 0.75rem; }
.check-row {
    display: flex; align-items: flex-start; gap: 0.85rem;
    padding: 0.85rem 1rem;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 12px; transition: border-color 0.2s;
    cursor: pointer;
}
.check-row:hover { border-color: rgba(1,54,186,0.2); }
.check-row input[type="checkbox"] {
    width: 18px; height: 18px;
    border-radius: 5px; border: 1.5px solid var(--border);
    background: var(--white); cursor: pointer;
    flex-shrink: 0; margin-top: 1px;
    accent-color: var(--blue);
}
.check-row-text {
    font-size: 0.875rem; font-weight: 500;
    color: #374151; line-height: 1.45;
}
.check-row-text a { color: var(--blue); text-decoration: underline; }

/* ── FOOTER ──────────────────────────────────────── */
.register-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.25rem;
}
.btn-register {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--rouge); color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem; font-weight: 700;
    padding: 0.8rem 2.5rem; border-radius: 50px;
    border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(200,16,46,0.25);
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    letter-spacing: 0.02em;
}
.btn-register:hover {
    background: #a80d26;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(200,16,46,0.35);
}
.btn-register:active { transform: translateY(0); }

.login-link {
    font-size: 0.875rem; color: var(--muted);
    display: flex; align-items: center; gap: 0.4rem;
}
.login-link a {
    color: var(--blue); font-weight: 700;
    text-decoration: none;
    border-bottom: 1.5px solid rgba(1,54,186,0.2);
    padding-bottom: 1px;
    transition: border-color 0.2s;
}
.login-link a:hover { border-color: var(--blue); }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 600px) {
    .register-page          { padding: 1.5rem 0.75rem 3rem; }
    .register-card-header   { padding: 1.25rem; }
    .register-section       { padding: 1.25rem; }
    .register-footer        { padding: 1.25rem; }
    .form-grid              { grid-template-columns: 1fr; }
    .form-item.full         { grid-column: 1; }
}
</style>

<div class="register-page">

    {{-- Type switcher --}}
    <div class="type-switcher">
        <span class="type-switcher-label">S'inscrire en tant que</span>
        <a href="{{ Route('register.morale') }}" class="type-btn active">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
            Personne morale
        </a>
        <a href="{{ Route('register.physique') }}" class="type-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Personne physique
        </a>
    </div>

    {{-- Session alerts --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Toastify({ text: "{{ session('success') }}", duration: 3500, close: true, gravity: "top", position: "right",
                style: { background: "#0136ba", borderRadius: "50px", fontFamily: "'DM Sans',sans-serif", fontSize: "0.875rem", fontWeight: "600" }
            }).showToast();
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Toastify({ text: "{{ session('error') }}", duration: 3500, close: true, gravity: "top", position: "right",
                style: { background: "#C8102E", borderRadius: "50px", fontFamily: "'DM Sans',sans-serif", fontSize: "0.875rem", fontWeight: "600" }
            }).showToast();
        });
    </script>
    @endif
    @if(session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Toastify({ text: "{{ session('status') }}", duration: 3500, close: true, gravity: "top", position: "right",
                style: { background: "#374151", borderRadius: "50px", fontFamily: "'DM Sans',sans-serif", fontSize: "0.875rem", fontWeight: "600" }
            }).showToast();
        });
    </script>
    @endif

    <div class="register-card">

        {{-- Card header --}}
        <div class="register-card-header">
            <div class="register-header-inner">
                <div class="register-avatar">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                        <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/>
                    </svg>
                </div>
                <div>
                    <div class="register-card-title">Créer un compte entreprise</div>
                    <div class="register-badge"><span></span> Personne morale</div>
                </div>
            </div>
        </div>

        <form method="POST" name="MoralForm" id="registerForm"
              action="{{ route('registration') }}"
              onsubmit="return verificationMoral()">
            @csrf
            <input type="hidden" name="typeActor" value="2">

            {{-- Société --}}
            <div class="register-section">
                <div class="register-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
                    Informations société
                </div>
                <div class="form-grid">

                    <div class="form-item">
                        <label class="form-label" for="societeType">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            Type de société
                        </label>
                        <div class="select-wrap">
                            <select name="societeType" id="societeType" class="form-select">
                                <option value="Societe">Société</option>
                                <option value="SARL">SARL</option>
                                <option value="Etablissement">Etablissement</option>
                                <option value="Autres">Autres</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="nomSociete">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            Dénomination sociale
                        </label>
                        <span class="field-msg error" id="nomSocieteMsg"></span>
                        <input id="nomSociete" type="text" class="form-input" name="nomSociete"
                            placeholder="Raison sociale *" value="{{ old('nomSociete') }}" autocomplete="off">
                    </div>

                    <div class="form-item full">
                        <label class="form-label" for="adresse">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Adresse de l'entreprise
                        </label>
                        <span class="field-msg error" id="adresseMsg"></span>
                        <input id="adresse" type="text" class="form-input" name="adresse"
                            placeholder="Adresse complète *" value="{{ old('adresse') }}" autocomplete="off">
                    </div>

                </div>
            </div>

            {{-- Contact --}}
            <div class="register-section">
                <div class="register-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Contact & accès
                </div>
                <div class="form-grid">

                    <div class="form-item">
                        <label class="form-label" for="telephone">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.52 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.91-1.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.64 15z"/></svg>
                            Téléphone
                        </label>
                        <span class="field-msg error" id="telephoneMsg">
                            @error('telephone')<span>Vérifiez le format (Ex : +229 62 00 00 00)</span>@enderror
                        </span>
                        <input id="telephone" type="tel" class="form-input" name="telephone"
                            placeholder="+229 61 00 00 00 *" value="{{ old('telephone') }}" autocomplete="off">
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="email">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Adresse e-mail
                        </label>
                        <span class="field-msg error" id="emailMsg">
                            @error('email')<span>Adresse e-mail déjà utilisée</span>@enderror
                        </span>
                        <input id="email" type="email" class="form-input" name="email"
                            placeholder="contact@entreprise.com *" value="{{ old('email') }}" autocomplete="email">
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="password">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Mot de passe
                        </label>
                        <span class="field-msg" id="mdp1Msg"></span>
                        <input onkeyup="controlMdp1()" id="password" type="password" class="form-input"
                            placeholder="8 caractères minimum *" name="password">
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="password-confirm">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Confirmer le mot de passe
                        </label>
                        <span class="field-msg" id="mdp2Msg"></span>
                        <input onkeyup="controlMdp1()" id="password-confirm" type="password" class="form-input"
                            placeholder="Répétez le mot de passe *" name="password_confirmation">
                    </div>

                </div>
            </div>

            {{-- Conditions --}}
            <div class="register-section">
                <div class="register-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Préférences & conditions
                </div>
                <div class="check-list">
                    <label class="check-row">
                        <input type="checkbox" name="alertes">
                        <span class="check-row-text">
                            J'accepte de recevoir des alertes sur les nouveaux marchés disponibles
                        </span>
                    </label>
                    <label class="check-row">
                        <input type="checkbox" name="conditions" required>
                        <span class="check-row-text">
                            J'ai lu et j'accepte les <a href="#">conditions générales d'utilisation</a>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Footer --}}
            <div class="register-footer">
                <button type="submit" class="btn-register">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Créer mon compte
                </button>
                <p class="login-link">
                    Déjà inscrit ?
                    <a href="{{ Route('login') }}">Se connecter</a>
                </p>
            </div>

        </form>
    </div>
</div>

@endsection

@section('code')
<script>
function controlMdp1() {
    const p1 = document.forms['MoralForm']['password'];
    const p2 = document.forms['MoralForm']['password_confirmation'];
    const msg1 = document.getElementById('mdp1Msg');
    const msg2 = document.getElementById('mdp2Msg');
    const inp1 = document.getElementById('password');
    const inp2 = document.getElementById('password-confirm');

    if (p1.value.length > 0) {
        if (p1.value.length >= 8) {
            msg1.textContent = 'Mot de passe valide';
            msg1.className = 'field-msg success';
            inp1.classList.remove('is-invalid'); inp1.classList.add('is-valid');
        } else {
            msg1.textContent = 'Minimum 8 caractères requis';
            msg1.className = 'field-msg error';
            inp1.classList.remove('is-valid'); inp1.classList.add('is-invalid');
        }
    }

    if (p2.value.length >= 8) {
        if (p2.value !== p1.value) {
            msg2.textContent = 'Les mots de passe ne correspondent pas';
            msg2.className = 'field-msg error';
            inp2.classList.remove('is-valid'); inp2.classList.add('is-invalid');
        } else {
            msg2.textContent = 'Mots de passe identiques ✓';
            msg2.className = 'field-msg success';
            inp2.classList.remove('is-invalid'); inp2.classList.add('is-valid');
        }
    }
}

function setMsg(id, text, type) {
    const el = document.getElementById(id);
    el.textContent = text;
    el.className = 'field-msg ' + type;
}

function verificationMoral() {
    const f = document.forms['MoralForm'];
    const nomSociete = f['nomSociete'];
    const adresse    = f['adresse'];
    const telephone  = f['telephone'];
    const email      = f['email'];
    const p1         = f['password'];
    const p2         = f['password_confirmation'];

    if (!nomSociete.value.trim()) {
        nomSociete.focus();
        setMsg('nomSocieteMsg', 'Veuillez renseigner la dénomination sociale', 'error');
        return false;
    }
    if (!adresse.value.trim()) {
        adresse.focus();
        setMsg('adresseMsg', 'Veuillez renseigner l\'adresse', 'error');
        return false;
    }
    if (!telephone.value.trim()) {
        telephone.focus();
        setMsg('telephoneMsg', 'Veuillez renseigner un numéro de téléphone', 'error');
        return false;
    }
    if (!email.value.includes('@') || !email.value.includes('.')) {
        email.focus();
        setMsg('emailMsg', 'Adresse e-mail invalide', 'error');
        return false;
    }
    if (p1.value.length < 8) {
        p1.focus();
        setMsg('mdp1Msg', 'Le mot de passe doit contenir au moins 8 caractères', 'error');
        return false;
    }
    if (p1.value !== p2.value) {
        p2.focus();
        setMsg('mdp2Msg', 'Les mots de passe ne correspondent pas', 'error');
        return false;
    }
    return true;
}
</script>
@endsection