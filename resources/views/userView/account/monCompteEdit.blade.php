@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le Consultant | Modifier mon compte</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

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

/* ── FORM GRID ───────────────────────────────────── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.form-item {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.form-item.full { grid-column: 1 / -1; }

.form-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.form-input,
.form-select {
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
    appearance: none;
    -webkit-appearance: none;
}
.form-input::placeholder { color: var(--muted); font-weight: 400; }
.form-input:focus,
.form-select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(1, 54, 186, 0.08);
}

/* Select wrapper for custom arrow */
.select-wrapper {
    position: relative;
}
.select-wrapper::after {
    content: '';
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 5px solid var(--muted);
    pointer-events: none;
}
.form-select { padding-right: 2.5rem; cursor: pointer; }

/* ── SUBMIT BUTTON ───────────────────────────────── */
.profil-footer {
    padding: 1.25rem 2rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--blue);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.65rem 1.5rem;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    box-shadow: 0 4px 16px rgba(1,54,186,0.18);
}
.btn-save:hover {
    background: #0140d4;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(1,54,186,0.28);
}
.btn-save:active { transform: translateY(0); }
.btn-save svg { flex-shrink: 0; }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 600px) {
    .profil-page        { padding: 1.5rem 0 3rem; }
    .profil-card-header { padding: 1.25rem 1.25rem; }
    .profil-section     { padding: 1.25rem 1.25rem; }
    .profil-footer      { padding: 1rem 1.25rem; }
    .form-grid          { grid-template-columns: 1fr; }
    .form-item.full     { grid-column: 1; }
    .profil-name        { font-size: 1.15rem; }
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
                    <div>
                        <div class="profil-name">Modifier mon profil</div>
                        <div class="profil-type-badge">
                            <span></span> Particulier
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ Route('save.edit.compte') }}">
                @csrf
                <input type="hidden" name="idUser" value="{{ $infos->id }}">

                {{-- Informations personnelles --}}
                <div class="profil-section">
                    <div class="profil-section-title">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Informations personnelles
                    </div>
                    <div class="form-grid">
                        <div class="form-item">
                            <label class="form-label" for="nom">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Nom
                            </label>
                            <input id="nom" type="text" class="form-input" placeholder="Nom *" name="nom"
                                value="{{ old('nom', $infos->nom) }}">
                        </div>
                        <div class="form-item">
                            <label class="form-label" for="prenoms">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Prénom(s)
                            </label>
                            <input id="prenoms" type="text" class="form-input" placeholder="Prénom(s) *" name="prenoms"
                                value="{{ old('prenoms', $infos->prenoms) }}" autocomplete="prenoms">
                        </div>
                        <div class="form-item full">
                            <label class="form-label" for="adresse">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Adresse
                            </label>
                            <input id="adresse" type="text" class="form-input" name="adresse" placeholder="Adresse *"
                                value="{{ old('adresse', $infos->adresse) }}">
                        </div>
                        <div class="form-item">
                            <label class="form-label" for="telephone">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.52 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.91-1.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.64 15z"/></svg>
                                Téléphone
                            </label>
                            <input id="telephone" type="text" class="form-input" name="telephone"
                                placeholder="Numéro de téléphone *" value="{{ old('telephone', $infos->telephone) }}">
                        </div>
                    </div>
                </div>

                {{-- Situation professionnelle --}}
                <div class="profil-section">
                    <div class="profil-section-title">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        Situation professionnelle
                    </div>
                    <div class="form-grid">
                        <div class="form-item">
                            <label class="form-label" for="fonction">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                                Fonction actuelle
                            </label>
                            <input id="fonction" type="text" class="form-input" name="fonction"
                                placeholder="Ex : Développeur Web" value="{{ old('fonction', $infos->fonction ?? '') }}">
                        </div>
                        <div class="form-item">
                            <label class="form-label" for="structure">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
                                Structure de travail
                            </label>
                            <input id="structure" type="text" class="form-input" name="structure"
                                placeholder="Ex : Drwintech" value="{{ old('structure', $infos->structure ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="profil-footer">
                    <button type="submit" class="btn-save">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>

            @elseif($infos->typeActor == 2)
            {{-- ── PERSONNE MORALE ── --}}

            <div class="profil-card-header">
                <div class="profil-header-inner">
                    <div class="profil-avatar">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                            <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/>
                        </svg>
                    </div>
                    <div>
                        <div class="profil-name">Modifier mon entreprise</div>
                        <div class="profil-type-badge">
                            <span></span> {{ $infos->typeSociete ?? 'Personne morale' }}
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ Route('save.edit.compte') }}">
                @csrf
                <input type="hidden" name="idUser" value="{{ $infos->id }}">

                {{-- Informations société --}}
                <div class="profil-section">
                    <div class="profil-section-title">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
                        Informations société
                    </div>
                    <div class="form-grid">
                        <div class="form-item">
                            <label class="form-label" for="societeType">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                Type de société
                            </label>
                            <div class="select-wrapper">
                                <select name="societeType" id="societeType" class="form-select">
                                    <option value="Societe"       {{ $infos->typeSociete == 'Societe'       ? 'selected' : '' }}>Société</option>
                                    <option value="SARL"          {{ $infos->typeSociete == 'SARL'          ? 'selected' : '' }}>SARL</option>
                                    <option value="Etablissement" {{ $infos->typeSociete == 'Etablissement' ? 'selected' : '' }}>Etablissement</option>
                                    <option value="Autres"        {{ $infos->typeSociete == 'Autres'        ? 'selected' : '' }}>Autres</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label" for="nomSociete">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                Dénomination sociale
                            </label>
                            <input id="nomSociete" type="text" class="form-input" name="nomSociete"
                                placeholder="Dénomination sociale *" value="{{ old('nomSociete', $infos->nomSociete) }}">
                        </div>
                        <div class="form-item full">
                            <label class="form-label" for="adresse">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Adresse
                            </label>
                            <input id="adresse" type="text" class="form-input" name="adresse"
                                value="{{ old('adresse', $infos->adresseSociete) }}" placeholder="Adresse de l'entreprise *">
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="profil-section">
                    <div class="profil-section-title">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Contact
                    </div>
                    <div class="form-grid">
                        <div class="form-item full">
                            <label class="form-label" for="telephone">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.52 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.91-1.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.64 15z"/></svg>
                                Téléphone
                            </label>
                            <input id="telephone" type="text" class="form-input" name="telephone"
                                value="{{ old('telephone', $infos->telephoneSociete) }}" placeholder="Numéro de téléphone *">
                        </div>
                    </div>
                </div>

                <div class="profil-footer">
                    <button type="submit" class="btn-save">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>

            @endif

        </div>
    </div>
</div>
@endsection