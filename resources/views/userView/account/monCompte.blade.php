@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le Consultant | Mon Compte</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

<style>
:root {
    --blue:   #0B2D5E;
    --rouge:  #C8102E;
    --bg:     #F5F4F0;
    --white:  #FFFFFF;
    --muted:  #6B7280;
    --border: #E5E3DC;
}

*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); }

/* ── PAGE WRAPPER ────────────────────────────────── */
.profil-page {
    padding: 2.5rem 0 4rem;
    min-height: 60vh;
}

/* ── PROFILE CARD ────────────────────────────────── */
.profil-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    max-width: 720px;
    margin: 0 auto;
    box-shadow: 0 8px 40px rgba(11,45,94,0.07);
}

/* Card top header bar */
.profil-card-header {
    background: var(--blue);
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
    border-bottom: 3px solid var(--rouge);
}
.profil-card-header::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 90% 50%, rgba(200,16,46,0.18) 0%, transparent 60%);
    pointer-events: none;
}

.profil-header-inner {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    position: relative; z-index: 1;
}

.profil-avatar {
    width: 56px; height: 56px;
    border-radius: 14px;
    background: rgba(255,255,255,0.12);
    border: 1.5px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.profil-avatar svg { opacity: 0.9; }

.profil-header-text {}
.profil-name {
    font-family: 'Instrument Serif', serif;
    font-size: 1.35rem;
    color: #fff;
    margin: 0 0 0.2rem;
    line-height: 1.2;
}
.profil-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: rgba(200,16,46,0.25);
    border: 1px solid rgba(200,16,46,0.4);
    color: rgba(255,255,255,0.85);
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.2rem 0.65rem;
    border-radius: 50px;
}
.profil-type-badge span {
    width: 5px; height: 5px;
    background: var(--rouge);
    border-radius: 50%;
}

/* ── SECTIONS ────────────────────────────────────── */
.profil-section {
    padding: 1.75rem 2rem;
}
.profil-section + .profil-section {
    border-top: 1px solid var(--border);
}

.profil-section-title {
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
.profil-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

/* ── INFO ROWS ───────────────────────────────────── */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    padding: 0.9rem 1.1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: border-color 0.2s;
}
.info-item:hover { border-color: rgba(11,45,94,0.2); }
.info-item.full  { grid-column: 1 / -1; }

.info-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.info-value {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--blue);
    word-break: break-word;
}
.info-value.empty { color: var(--muted); font-style: italic; font-size: 0.875rem; }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 600px) {
    .profil-page          { padding: 1.5rem 0 3rem; }
    .profil-card-header   { padding: 1.25rem 1.25rem; }
    .profil-section       { padding: 1.25rem 1.25rem; }
    .info-grid            { grid-template-columns: 1fr; }
    .info-item.full       { grid-column: 1; }
    .profil-name          { font-size: 1.15rem; }
}
</style>
@endsection


@section('banner')
@endsection


@section('contenu')
<div class="profil-page">
    <div class="container mx-auto px-4">

        <div class="profil-card">

            @if($infos->typeActor == 1)
            {{-- ── PERSONNE PHYSIQUE ── --}}

            <div class="profil-card-header">
                <div class="profil-header-inner">
                    <div class="profil-avatar">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                    <div class="profil-header-text">
                        <div class="profil-name">{{ $infos->nom ?? 'Mon compte' }}</div>
                        <div class="profil-type-badge">
                            <span></span> Particulier
                        </div>
                    </div>
                </div>
            </div>

            <div class="profil-section">
                <div class="profil-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Informations personnelles
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Adresse e-mail
                        </span>
                        <span class="info-value">{{ $infos->email ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.52 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.91-1.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.64 15z"/></svg>
                            Téléphone
                        </span>
                        <span class="info-value {{ empty($infos->telephone) ? 'empty' : '' }}">
                            {{ $infos->telephone ?? 'Non renseigné' }}
                        </span>
                    </div>
                    <div class="info-item full">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Adresse
                        </span>
                        <span class="info-value {{ empty($infos->adresse) ? 'empty' : '' }}">
                            {{ $infos->adresse ?? 'Non renseignée' }}
                        </span>
                    </div>
                </div>
            </div>

            @elseif($infos->typeActor == 2)
            {{-- ── PERSONNE MORALE ── --}}

            <div class="profil-card-header">
                <div class="profil-header-inner">
                    <div class="profil-avatar">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                            <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/>
                        </svg>
                    </div>
                    <div class="profil-header-text">
                        <div class="profil-name">{{ $infos->nomSociete ?? 'Mon entreprise' }}</div>
                        <div class="profil-type-badge">
                            <span></span> {{ $infos->typeSociete ?? 'Personne morale' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Société --}}
            <div class="profil-section">
                <div class="profil-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
                    Informations société
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            Type de société
                        </span>
                        <span class="info-value {{ empty($infos->typeSociete) ? 'empty' : '' }}">
                            {{ $infos->typeSociete ?? 'Non renseigné' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            Dénomination sociale
                        </span>
                        <span class="info-value {{ empty($infos->nomSociete) ? 'empty' : '' }}">
                            {{ $infos->nomSociete ?? 'Non renseignée' }}
                        </span>
                    </div>
                    <div class="info-item full">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Adresse
                        </span>
                        <span class="info-value {{ empty($infos->adresseSociete) ? 'empty' : '' }}">
                            {{ $infos->adresseSociete ?? 'Non renseignée' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="profil-section">
                <div class="profil-section-title">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Contact
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Adresse e-mail
                        </span>
                        <span class="info-value">{{ $infos->email ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.52 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.91-1.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.64 15z"/></svg>
                            Téléphone
                        </span>
                        <span class="info-value {{ empty($infos->telephoneSociete) ? 'empty' : '' }}">
                            {{ $infos->telephoneSociete ?? 'Non renseigné' }}
                        </span>
                    </div>
                </div>
            </div>

            @endif

        </div>

    </div>
</div>
@endsection