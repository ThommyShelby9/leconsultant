@extends('layout.userLayout.template-auth')

@section('titre')
<title>Le Consultant | Se connecter</title>
@endsection

@section('contenu')
<style>
/* ── AUTH PAGE ───────────────────────────────────── */
.auth-page {
    min-height: calc(100vh - 68px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    background: var(--bg);
}

/* ── AUTH WRAPPER ────────────────────────────────── */
.auth-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 900px;
    width: 100%;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(11,45,94,0.14);
    border: 1px solid var(--border);
}

/* ── LEFT PANEL (register CTA) ───────────────────── */
.auth-panel-left {
    background: var(--blue);
    padding: 3.5rem 2.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    border-right: 3px solid var(--rouge);
}
.auth-panel-left::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 80%, rgba(200,16,46,0.2) 0%, transparent 55%);
    pointer-events: none;
}
.auth-panel-left::after {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 10%, rgba(255,255,255,0.04) 0%, transparent 50%);
    pointer-events: none;
}

.auth-panel-deco {
    width: 64px; height: 64px;
    border-radius: 18px;
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.75rem;
    position: relative; z-index: 1;
}

.auth-panel-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.9rem;
    color: #fff;
    text-align: center;
    line-height: 1.2;
    margin-bottom: 0.75rem;
    position: relative; z-index: 1;
}

.auth-panel-sub {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.6);
    text-align: center;
    line-height: 1.6;
    margin-bottom: 2.5rem;
    position: relative; z-index: 1;
}

.btn-register {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--rouge);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    padding: 0.75rem 1.75rem;
    border-radius: 50px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    position: relative; z-index: 1;
    box-shadow: 0 6px 20px rgba(200,16,46,0.35);
    transition: transform 0.15s, box-shadow 0.2s, background 0.2s;
    letter-spacing: 0.02em;
}
.btn-register:hover {
    background: #a80d26;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(200,16,46,0.4);
}
.btn-register:active { transform: translateY(0); }

/* divider line above button */
.auth-panel-divider {
    width: 40px; height: 2px;
    background: rgba(255,255,255,0.15);
    border-radius: 2px;
    margin-bottom: 2.5rem;
    position: relative; z-index: 1;
}

/* ── RIGHT PANEL (login form) ────────────────────── */
.auth-panel-right {
    background: var(--white);
    padding: 3.5rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-form-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.75rem;
    color: var(--blue);
    margin: 0 0 0.4rem;
    line-height: 1.2;
}
.auth-form-sub {
    font-size: 0.82rem;
    color: var(--muted);
    margin-bottom: 2rem;
}

/* Error alert */
.auth-error {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    background: rgba(200,16,46,0.07);
    border: 1px solid rgba(200,16,46,0.2);
    color: var(--rouge);
    font-size: 0.82rem;
    font-weight: 600;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin-bottom: 1.25rem;
}

/* Form fields */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
}

.auth-field {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.auth-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.auth-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--blue);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.auth-input::placeholder { color: var(--muted); font-weight: 400; }
.auth-input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(1,54,186,0.08);
}

/* Forgot password */
.auth-forgot {
    display: flex;
    justify-content: flex-end;
    margin-top: 0.1rem;
}
.auth-forgot a {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--muted);
    text-decoration: none;
    border-bottom: 1px dashed var(--border);
    padding-bottom: 1px;
    transition: color 0.2s, border-color 0.2s;
}
.auth-forgot a:hover { color: var(--blue); border-color: var(--blue); }

/* Submit */
.btn-login {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    background: var(--blue);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    padding: 0.8rem 1.5rem;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    margin-top: 0.5rem;
    box-shadow: 0 4px 16px rgba(1,54,186,0.2);
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    letter-spacing: 0.02em;
}
.btn-login:hover {
    background: #0140d4;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(1,54,186,0.3);
}
.btn-login:active { transform: translateY(0); }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 700px) {
    .auth-wrapper {
        grid-template-columns: 1fr;
        border-radius: 20px;
    }
    .auth-panel-left {
        padding: 2.5rem 1.75rem;
        border-right: none;
        border-bottom: 3px solid var(--rouge);
    }
    .auth-panel-right { padding: 2rem 1.75rem 2.5rem; }
    .auth-panel-title { font-size: 1.5rem; }
    .auth-form-title  { font-size: 1.4rem; }
}
</style>

<div class="auth-page">
    <div class="auth-wrapper">

        {{-- ── LEFT: Register CTA ── --}}
        <div class="auth-panel-left">
            <div class="auth-panel-deco">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
            </div>
            <h2 class="auth-panel-title">Pas encore<br>membre ?</h2>
            <p class="auth-panel-sub">
                Rejoignez la plateforme et accédez à tous les appels d'offres disponibles.
            </p>
            <div class="auth-panel-divider"></div>
            <a href="{{ route('register.morale') }}" class="btn-register">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Créer mon compte
            </a>
        </div>

        {{-- ── RIGHT: Login form ── --}}
        <div class="auth-panel-right">
            <h1 class="auth-form-title">Se connecter</h1>
            <p class="auth-form-sub">Accédez à votre espace personnel</p>

            @error('email')
            <div class="auth-error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Identifiants incorrects. Veuillez réessayer.
            </div>
            @enderror

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label class="auth-label" for="email">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Adresse e-mail
                    </label>
                    <input id="email" type="email" class="auth-input" name="email"
                        value="{{ old('email') }}" autocomplete="email" autofocus
                        placeholder="votre@email.com">
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="password">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Mot de passe
                    </label>
                    <input id="password" type="password" class="auth-input" name="password"
                        autocomplete="current-password" placeholder="••••••••">
                </div>

                <div class="auth-forgot">
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-login">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Connexion
                </button>

            </form>
        </div>

    </div>
</div>

@endsection