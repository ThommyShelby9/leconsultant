@extends('layout.userLayout.template')

@section('titre')
<title>Le Consultant | Créer une alerte</title>
@endsection

@section('banner')
<section class="page-banner">
    <div class="page-banner-inner">
        <div class="page-banner-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                <line x1="12" y1="2" x2="12" y2="4"/>
            </svg>
        </div>
        <h1 class="page-banner-title">Créer une alerte</h1>
        <p class="page-banner-sub">Soyez notifié dès qu'un appel d'offres correspond à vos critères</p>
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
    position: relative;
    overflow: hidden;
    text-align: center;
}
.page-banner::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 50%, rgba(200,16,46,0.15) 0%, transparent 55%),
                radial-gradient(ellipse at 15% 50%, rgba(255,255,255,0.03) 0%, transparent 50%);
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
    color: #fff;
    margin: 0 0 0.5rem;
    line-height: 1.1;
}
.page-banner-sub {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.6);
    margin: 0;
}

/* ── PAGE WRAPPER ────────────────────────────────── */
.alerte-page {
    padding: 2.5rem 1rem 4rem;
}

/* ── CARD ────────────────────────────────────────── */
.alerte-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    max-width: 720px;
    margin: 0 auto;
    box-shadow: 0 8px 40px rgba(11,45,94,0.07);
}

/* ── SECTION ─────────────────────────────────────── */
.alerte-section {
    padding: 1.75rem 2rem;
}
.alerte-section + .alerte-section {
    border-top: 1px solid var(--border);
}
.alerte-section-title {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.alerte-section-title::after {
    content: ''; flex: 1;
    height: 1px; background: var(--border);
}

/* ── FORM GRID ───────────────────────────────────── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.form-item { display: flex; flex-direction: column; gap: 0.4rem; }
.form-item.full { grid-column: 1 / -1; }

.form-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    display: flex; align-items: center; gap: 0.4rem;
}

/* Select & multi-select */
.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--blue);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none; -webkit-appearance: none;
}
.form-select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(1,54,186,0.08);
}
.form-select option { color: #374151; font-weight: 400; }
.form-select option:checked { background: rgba(1,54,186,0.08); color: var(--blue); }

/* Multi-select specific */
.form-select[multiple] {
    height: auto;
    min-height: 120px;
    padding: 0.5rem;
    cursor: pointer;
}
.form-select[multiple] option {
    padding: 0.45rem 0.6rem;
    border-radius: 8px;
    margin-bottom: 2px;
    cursor: pointer;
    transition: background 0.15s;
}
.form-select[multiple] option:checked {
    background: var(--blue);
    color: #fff;
}

/* Select hint */
.select-hint {
    font-size: 0.72rem;
    color: var(--muted);
    margin-top: 0.2rem;
    display: flex; align-items: center; gap: 0.3rem;
}

/* Single select wrapper */
.select-wrap { position: relative; }
.select-wrap::after {
    content: '';
    position: absolute; right: 1rem; top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 5px solid var(--muted);
    pointer-events: none;
}
.select-wrap .form-select { padding-right: 2.5rem; }

/* ── FOOTER ──────────────────────────────────────── */
.alerte-footer {
    padding: 1.25rem 2rem;
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.alerte-footer-note {
    font-size: 0.78rem;
    color: var(--muted);
    display: flex; align-items: center; gap: 0.4rem;
}
.btn-save {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--blue); color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 600;
    padding: 0.65rem 1.5rem;
    border-radius: 50px; border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(1,54,186,0.18);
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    text-decoration: none;
}
.btn-save:hover {
    background: #0140d4;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(1,54,186,0.28);
}
.btn-save:active { transform: translateY(0); }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 600px) {
    .alerte-page    { padding: 1.5rem 0.75rem 3rem; }
    .alerte-section { padding: 1.25rem; }
    .alerte-footer  { padding: 1rem 1.25rem; }
    .form-grid      { grid-template-columns: 1fr; }
    .form-item.full { grid-column: 1; }
    .alerte-footer-note { display: none; }
}
</style>

<div class="alerte-page">
    <div class="alerte-card">

        <form action="{{ route('alerte.save') }}" method="POST">
            @csrf

            {{-- Critères de marché --}}
            <div class="alerte-section">
                <div class="alerte-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    Critères de marché
                </div>
                <div class="form-grid">

                    <div class="form-item full">
                        <label class="form-label" for="type_marche">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 6h16M4 10h16M4 14h8"/></svg>
                            Type de marché
                        </label>
                        <select class="form-select" name="type_marche[]" id="type_marche" multiple>
                            @foreach ($marches as $marche)
                                <option value="{{ $marche->id }}">{{ $marche->title }}</option>
                            @endforeach
                        </select>
                        <span class="select-hint">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Maintenez Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs types
                        </span>
                    </div>

                    <div class="form-item full">
                        <label class="form-label" for="ac">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
                            Autorité contractante
                        </label>
                        <select class="form-select" name="ac[]" id="ac" multiple>
                            @foreach ($ac as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                            @endforeach
                        </select>
                        <span class="select-hint">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Maintenez Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs autorités
                        </span>
                    </div>

                </div>
            </div>

            {{-- Domaine d'activité --}}
            <div class="alerte-section">
                <div class="alerte-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    Domaine d'activité
                </div>
                <div class="form-grid">
                    <div class="form-item full">
                        <label class="form-label" for="domaineActivite">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            Domaine d'activité
                        </label>
                        <div class="select-wrap">
                            <select class="form-select" id="domaineActivite" name="domaine_activite">
                                <option value="" disabled selected>Choisissez un domaine d'activité</option>
                                @foreach($domainesActivite as $domaine)
                                    <option value="{{ $domaine->id }}">{{ $domaine->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="alerte-footer">
                <span class="alerte-footer-note">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Vous recevrez une notification par e-mail pour chaque nouvelle offre correspondante
                </span>
                <button type="submit" class="btn-save">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Créer l'alerte
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('code')
<script src="https://cdn.kkiapay.me/k.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@if(session('success'))
<script>
    Toastify({
        text: "{{ session('success') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
            background: "var(--blue)",
            borderRadius: "50px",
            fontFamily: "'DM Sans', sans-serif",
            fontSize: "0.875rem",
            fontWeight: "600",
            boxShadow: "0 6px 20px rgba(1,54,186,0.25)"
        },
        stopOnFocus: true,
    }).showToast();
</script>
@endif
@endsection