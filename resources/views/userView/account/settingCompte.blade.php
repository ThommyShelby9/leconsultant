@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le Consultant | Paramètres</title>
@endsection

@section('banner')
@endsection

@section('contenu')
<style>
/* ── SETTINGS CARD ───────────────────────────────── */
.settings-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(11,45,94,0.07);
}

/* Card header */
.settings-card-header {
    background: var(--blue);
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
    border-bottom: 3px solid var(--rouge);
}
.settings-card-header::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 90% 50%, rgba(200,16,46,0.18) 0%, transparent 60%);
    pointer-events: none;
}
.settings-header-inner {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    position: relative; z-index: 1;
}
.settings-avatar {
    width: 56px; height: 56px;
    border-radius: 14px;
    background: rgba(255,255,255,0.12);
    border: 1.5px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.settings-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.35rem;
    color: #fff;
    margin: 0 0 0.2rem;
    line-height: 1.2;
}
.settings-badge {
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
.settings-badge span {
    width: 5px; height: 5px;
    background: var(--rouge);
    border-radius: 50%;
}

/* Section */
.settings-section {
    padding: 1.75rem 2rem;
}
.settings-section-title {
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
.settings-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

/* Notification rows */
.notif-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.notif-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: border-color 0.2s;
}
.notif-row:hover { border-color: rgba(1,54,186,0.2); }

.notif-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(1,54,186,0.08);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.notif-icon svg { color: var(--blue); }

.notif-label {
    flex: 1;
    font-size: 0.9rem;
    font-weight: 500;
    color: #374151;
    line-height: 1.4;
}

/* Toggle switch */
.toggle-wrap {
    flex-shrink: 0;
    position: relative;
}
.toggle-wrap input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0; height: 0;
}
.toggle-wrap label {
    display: block;
    width: 42px; height: 24px;
    background: var(--border);
    border-radius: 50px;
    cursor: pointer;
    transition: background 0.25s;
    position: relative;
}
.toggle-wrap label::after {
    content: '';
    position: absolute;
    left: 3px; top: 3px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: var(--white);
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    transition: transform 0.25s, box-shadow 0.2s;
}
.toggle-wrap input:checked + label {
    background: var(--blue);
}
.toggle-wrap input:checked + label::after {
    transform: translateX(18px);
    box-shadow: 0 1px 6px rgba(1,54,186,0.25);
}

/* Footer */
.settings-footer {
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
    text-decoration: none;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    box-shadow: 0 4px 16px rgba(1,54,186,0.18);
}
.btn-save:hover {
    background: #0140d4;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(1,54,186,0.28);
}
.btn-save:active { transform: translateY(0); }

@media (max-width: 600px) {
    .settings-card-header { padding: 1.25rem; }
    .settings-section     { padding: 1.25rem; }
    .settings-footer      { padding: 1rem 1.25rem; }
    .notif-label          { font-size: 0.82rem; }
}
</style>

<div class="settings-card">

    {{-- Header --}}
    <div class="settings-card-header">
        <div class="settings-header-inner">
            <div class="settings-avatar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.8">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
            </div>
            <div>
                <div class="settings-title">Paramètres</div>
                <div class="settings-badge">
                    <span></span> Notifications & préférences
                </div>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    <div class="settings-section">
        <div class="settings-section-title">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Notifications par e-mail
        </div>

        <div class="notif-list">

            <div class="notif-row">
                <div class="notif-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <span class="notif-label">
                    Recevoir les notifications de publication de nouveaux appels d'offres
                </span>
                <div class="toggle-wrap">
                    <input type="checkbox" id="c1">
                    <label for="c1"></label>
                </div>
            </div>

            <div class="notif-row">
                <div class="notif-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <span class="notif-label">
                    Recevoir les récapitulatifs hebdomadaires des offres disponibles
                </span>
                <div class="toggle-wrap">
                    <input type="checkbox" id="c2">
                    <label for="c2"></label>
                </div>
            </div>

            <div class="notif-row">
                <div class="notif-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="notif-label">
                    Recevoir des rappels avant la date de clôture des offres
                </span>
                <div class="toggle-wrap">
                    <input type="checkbox" id="c3">
                    <label for="c3"></label>
                </div>
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <div class="settings-footer">
        <button type="button" class="btn-save">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Enregistrer les modifications
        </button>
    </div>

</div>
@endsection