@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le Consultant | Mes Abonnements</title>
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
    --green:  #059669;
}

*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); }

/* ── PAGE ────────────────────────────────────────── */
.abon-page { padding: 2.5rem 0 4rem; }

/* ── SECTION TITLE ───────────────────────────────── */
.abon-section-label {
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
.abon-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

/* ── ACTIVE SUBSCRIPTION CARD ────────────────────── */
.abon-active-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 24px rgba(11,45,94,0.06);
}

.abon-active-header {
    background: var(--blue);
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    border-bottom: 3px solid var(--rouge);
    position: relative;
    overflow: hidden;
}
.abon-active-header::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 90% 50%, rgba(200,16,46,0.15) 0%, transparent 60%);
    pointer-events: none;
}

.abon-active-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.25rem;
    color: #fff;
    margin: 0;
    position: relative; z-index: 1;
}

.abon-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.85rem;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    position: relative; z-index: 1;
}
.abon-status-badge.active {
    background: rgba(5,150,105,0.2);
    border: 1px solid rgba(5,150,105,0.4);
    color: #6EE7B7;
}
.abon-status-badge.active::before {
    content: '';
    width: 6px; height: 6px;
    background: #34D399;
    border-radius: 50%;
    animation: pulse-dot 1.5s infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.6; transform: scale(0.8); }
}

.abon-active-body {
    padding: 1.5rem 2rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.abon-stat {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.abon-stat-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
}

.abon-stat-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--blue);
}
.abon-stat-value.highlight { color: var(--rouge); }

/* Progress bar */
.abon-progress-wrap {
    padding: 0 2rem 1.5rem;
}
.abon-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.78rem;
    color: var(--muted);
    margin-bottom: 0.5rem;
}
.abon-progress-label strong { color: var(--blue); font-weight: 600; }
.abon-progress-bar {
    width: 100%;
    height: 6px;
    background: var(--border);
    border-radius: 50px;
    overflow: hidden;
}
.abon-progress-fill {
    height: 100%;
    background: linear-gradient(to right, var(--blue), var(--rouge));
    border-radius: 50px;
    transition: width 0.8s ease;
}

/* ── HISTORY TABLE ───────────────────────────────── */
.abon-history-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(11,45,94,0.06);
}

.abon-table {
    width: 100%;
    border-collapse: collapse;
}

.abon-table thead tr {
    background: var(--bg);
    border-bottom: 2px solid var(--border);
}

.abon-table th {
    padding: 0.85rem 1.5rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    white-space: nowrap;
}

.abon-table td {
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    color: var(--blue);
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.abon-table tbody tr:last-child td { border-bottom: none; }
.abon-table tbody tr:hover td { background: rgba(11,45,94,0.02); }

.table-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.25rem 0.65rem;
    border-radius: 50px;
}
.table-badge.current {
    background: rgba(5,150,105,0.1);
    color: var(--green);
    border: 1px solid rgba(5,150,105,0.25);
}
.table-badge.expired {
    background: rgba(107,114,128,0.1);
    color: var(--muted);
    border: 1px solid rgba(107,114,128,0.2);
}

/* empty state */
.abon-empty {
    padding: 3rem 2rem;
    text-align: center;
    color: var(--muted);
}
.abon-empty svg { margin: 0 auto 1rem; display: block; opacity: 0.3; }
.abon-empty p { font-size: 0.9rem; }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 640px) {
    .abon-page            { padding: 1.5rem 0 3rem; }
    .abon-active-header   { padding: 1.25rem; }
    .abon-active-body     { grid-template-columns: 1fr 1fr; padding: 1rem; }
    .abon-progress-wrap   { padding: 0 1rem 1.25rem; }
    .abon-table th,
    .abon-table td        { padding: 0.75rem 1rem; font-size: 0.8rem; }
}
</style>
@endsection

@section('banner')
@endsection

@section('contenu')
<div class="abon-page">
    <div class="container mx-auto px-4">

        {{-- ── ABONNEMENT ACTUEL ── --}}
        @forelse ($actuel as $item)
            @if($item->typePack == 1)

            <?php
                $debut    = new DateTime($item->dateDebut);
                $fin      = new DateTime($item->dateFin);
                $today    = new DateTime(date('Y-m-d'));
                $totalDays = $debut->diff($fin)->days;
                $elapsed   = $debut->diff($today)->days;
                $remaining = $today < $fin ? $fin->diff($today)->days : 0;
                $pct       = $totalDays > 0 ? min(100, round(($elapsed / $totalDays) * 100)) : 100;
                $isActive  = $today <= $fin;
            ?>

            <div class="abon-section-label" style="margin-bottom:1rem;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Abonnement actuel
            </div>

            <div class="abon-active-card">
                <div class="abon-active-header">
                    <div class="abon-active-title">Abonnement {{ $item->nombre }} mois</div>
                    @if($isActive)
                        <div class="abon-status-badge active">En cours</div>
                    @else
                        <div class="abon-status-badge" style="background:rgba(200,16,46,0.15);border:1px solid rgba(200,16,46,0.3);color:#FCA5A5;">Expiré</div>
                    @endif
                </div>

                <div class="abon-active-body">
                    <div class="abon-stat">
                        <span class="abon-stat-label">Souscrit le</span>
                        <span class="abon-stat-value">{{ date('d M Y', strtotime($item->dateDebut)) }}</span>
                    </div>
                    <div class="abon-stat">
                        <span class="abon-stat-label">Expire le</span>
                        <span class="abon-stat-value {{ !$isActive ? 'highlight' : '' }}">{{ date('d M Y', strtotime($item->dateFin)) }}</span>
                    </div>
                    <div class="abon-stat">
                        <span class="abon-stat-label">Jours restants</span>
                        <span class="abon-stat-value {{ $remaining < 7 ? 'highlight' : '' }}">
                            {{ $isActive ? $remaining . ' jour' . ($remaining > 1 ? 's' : '') : 'Expiré' }}
                        </span>
                    </div>
                </div>

                <div class="abon-progress-wrap">
                    <div class="abon-progress-label">
                        <span>Progression</span>
                        <strong>{{ $pct }}% écoulé</strong>
                    </div>
                    <div class="abon-progress-bar">
                        <div class="abon-progress-fill" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            </div>

            @include('component.alerte')

            @endif
        @empty
            <div class="abon-active-card" style="padding:2.5rem 2rem; text-align:center; color:var(--muted);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;display:block;opacity:0.3;"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <p style="font-size:0.9rem;">Aucun abonnement actif pour le moment.</p>
            </div>
        @endforelse

        {{-- ── HISTORIQUE ── --}}
        <div class="abon-section-label" style="margin-top:2.5rem; margin-bottom:1rem;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Historique des abonnements
        </div>

        <div class="abon-history-card">
            @if($lesAbonnements->count())
            <div style="overflow-x:auto;">
                <table class="abon-table">
                    <thead>
                        <tr>
                            <th>Pack</th>
                            <th>Date de souscription</th>
                            <th>Date de fin</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lesAbonnements as $item)
                        <?php $isExp = now()->gt(\Carbon\Carbon::parse($item->dateFin)); ?>
                        <tr>
                            <td>
                                <span style="font-weight:600;">{{ $item->titre }}</span>
                            </td>
                            <td>{{ date('d M Y', strtotime($item->dateDebut)) }}</td>
                            <td>{{ date('d M Y', strtotime($item->dateFin)) }}</td>
                            <td>
                                @if($isExp)
                                    <span class="table-badge expired">Expiré</span>
                                @else
                                    <span class="table-badge current">Actif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="abon-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p>Aucun abonnement dans l'historique.</p>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@section('code')
@endsection