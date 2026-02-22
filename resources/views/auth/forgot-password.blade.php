@extends('layout.userLayout.template-auth')

@section('titre')
<title>Le consultant | Mot de passe oublié</title>
@endsection

@section('contenu')

<style>
    .auth-wrapper {
        min-height: calc(100vh - 68px);
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.25rem;
    }

    .auth-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 8px 48px rgba(1, 54, 186, 0.10);
        overflow: hidden;
        width: 100%;
        max-width: 960px;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* ── Panneau gauche (bleu) ── */
    .auth-card__side {
        background: var(--blue);
        padding: 3.5rem 2.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        position: relative;
        overflow: hidden;
    }
    .auth-card__side::before {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        border-radius: 50%;
        border: 60px solid rgba(255,255,255,0.05);
        top: -80px; left: -80px;
    }
    .auth-card__side::after {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        border-radius: 50%;
        border: 40px solid rgba(255,255,255,0.05);
        bottom: -40px; right: -40px;
    }
    .auth-card__side h2 {
        font-family: 'Instrument Serif', serif;
        font-size: 2rem;
        color: var(--white);
        text-align: center;
        margin: 0;
        position: relative;
        z-index: 1;
        line-height: 1.25;
    }
    .auth-card__side p {
        color: rgba(255,255,255,0.65);
        font-size: 0.9rem;
        text-align: center;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    .auth-card__side .side-divider {
        width: 40px;
        height: 3px;
        background: var(--rouge);
        border-radius: 2px;
        position: relative;
        z-index: 1;
    }
    .btn-side {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--white);
        border: 1.5px solid rgba(255,255,255,0.4);
        border-radius: 50px;
        padding: 0.55rem 1.6rem;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-side:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.7);
    }

    /* ── Panneau droit ── */
    .auth-card__form {
        padding: 3.5rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 1.5rem;
    }

    /* Icône clé */
    .verify-icon {
        width: 60px; height: 60px;
        background: rgba(1,54,186,0.08);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .verify-icon svg {
        width: 28px; height: 28px;
        stroke: var(--blue);
    }

    .auth-card__form h2 {
        font-family: 'Instrument Serif', serif;
        font-size: 1.85rem;
        color: #1a1a2e;
        margin: 0 0 0.25rem;
    }
    .auth-card__form .form-subtitle {
        font-size: 0.875rem;
        color: var(--muted);
        margin: 0;
        line-height: 1.6;
    }

    /* Alertes */
    .auth-alert-error {
        background: rgba(200,16,46,0.08);
        border-left: 3px solid var(--rouge);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: var(--rouge);
    }
    .auth-alert-success {
        background: rgba(1,54,186,0.06);
        border-left: 3px solid var(--blue);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: var(--blue);
    }

    /* Champ */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    .form-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }
    .form-group input {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        color: #1a1a2e;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.7rem 1rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
    }
    .form-group input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(1,54,186,0.1);
    }

    /* Bouton submit */
    .btn-submit {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--white);
        background: var(--blue);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        cursor: pointer;
        width: 100%;
        box-shadow: 0 4px 14px rgba(1,54,186,0.25);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-submit:hover {
        background: #0140d4;
        box-shadow: 0 6px 20px rgba(1,54,186,0.35);
    }

    .auth-link {
        font-size: 0.85rem;
        color: var(--muted);
        text-decoration: none;
        text-align: center;
        transition: color 0.2s;
    }
    .auth-link:hover { color: var(--blue); }

    /* ── Responsive ── */
    @media (max-width: 720px) {
        .auth-card { grid-template-columns: 1fr; }
        .auth-card__side { display: none; }
        .auth-card__form { padding: 2rem 1.5rem; }
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        {{-- Panneau gauche --}}
        <div class="auth-card__side">
            <h2>Pas encore de compte&nbsp;?</h2>
            <div class="side-divider"></div>
            <p>Rejoignez Le Consultant et accédez à tous les appels d'offres en un seul endroit.</p>
            <a href="{{ route('register.morale') }}" class="btn-side">Créer mon compte</a>
        </div>

        {{-- Panneau droit --}}
        <div class="auth-card__form">

            <div class="verify-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                </svg>
            </div>

            <div>
                <h2>Mot de passe oublié</h2>
                <p class="form-subtitle">Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            </div>

            @error('email')
                <div class="auth-alert-error">Cet e-mail n'existe pas dans notre base.</div>
            @enderror

            @if(session('status'))
                <div class="auth-alert-success">
                    Le lien de réinitialisation a été envoyé à votre adresse e-mail.
                </div>
            @endif

            <form method="POST" action="{{ route('password.request') }}" style="display:flex; flex-direction:column; gap:1rem;">
                @csrf

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        autocomplete="email" autofocus
                        placeholder="votre@email.com">
                </div>

                <button type="submit" class="btn-submit">Envoyer le lien</button>
            </form>

            <a href="{{ route('login') }}" class="auth-link">← Retour à la connexion</a>

        </div>
    </div>
</div>

@endsection