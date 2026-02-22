@extends('layout.userLayout.template-auth')

@section('titre')
<title>Le consultant | Vérification de l'e-mail</title>
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

    .auth-card__side img {
        width: 80%;
        max-width: 280px;
        position: relative;
        z-index: 1;
        border-radius: 12px;
        object-fit: cover;
    }

    /* ── Panneau droit ── */
    .auth-card__form {
        padding: 3.5rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 1.5rem;
    }

    /* Icône enveloppe */
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
    .auth-card__form p {
        font-size: 0.9rem;
        color: var(--muted);
        line-height: 1.65;
        margin: 0;
    }

    .verify-divider {
        width: 40px;
        height: 3px;
        background: var(--rouge);
        border-radius: 2px;
    }

    /* Encadré info */
    .verify-info {
        background: rgba(1,54,186,0.05);
        border-left: 3px solid var(--blue);
        border-radius: 8px;
        padding: 0.85rem 1rem;
        font-size: 0.85rem;
        color: #374151;
        line-height: 1.6;
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
        .auth-card__side { padding: 2rem 1.5rem; display: none; }
        .auth-card__form { padding: 2rem 1.5rem; }
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        {{-- Panneau gauche : image --}}
        <div class="auth-card__side">
            <img src="{{ asset('assets/img/african-american-businesswoman-working-on-laptop-in-cafe 1.png') }}" alt="Illustration">
        </div>

        {{-- Panneau droit : contenu --}}
        <div class="auth-card__form">

            <div class="verify-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0-9.75 6.75L2.25 6.75" />
                </svg>
            </div>

            <div>
                <h2>Vérifiez votre e-mail</h2>
                <div class="verify-divider" style="margin: 0.75rem 0;"></div>
                <p>Un lien de vérification vous a été envoyé. Cliquez dessus pour activer votre compte.</p>
            </div>

            <div class="verify-info">
                Vous ne trouvez pas l'e-mail ? Pensez à vérifier votre dossier <strong>spam ou courrier indésirable</strong>. Le délai de réception peut varier selon votre opérateur.
            </div>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-submit">
                    Renvoyer l'e-mail de vérification
                </button>
            </form>

            <a href="{{ route('admin.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-verify-form').submit();"
               class="auth-link">
               ← Se déconnecter
            </a>
            <form id="logout-verify-form" action="{{ route('admin.logout') }}" method="POST" style="display:none">
                @csrf
            </form>

        </div>
    </div>
</div>

@endsection