@extends('layout.userLayout.template')

@section('titre')
<title>Le Consultant | Appels d'Offres</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

/* ── BANNER ──────────────────────────────────────── */
#banner {
    background: var(--blue);
    padding: 4rem 0 3.5rem;
    position: relative;
    overflow: hidden;
}
#banner::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 75% 50%, rgba(200,16,46,0.15) 0%, transparent 65%);
    pointer-events: none;
}

.banner-eyebrow {
    display: inline-flex;
    align-items: center; gap: 0.5rem;
    background: rgba(200,16,46,0.2);
    border: 1px solid rgba(200,16,46,0.4);
    color: rgba(255,255,255,0.85);
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    padding: 0.3rem 0.85rem; border-radius: 50px;
    margin-bottom: 1rem;
}
.banner-eyebrow span { width: 6px; height: 6px; background: var(--rouge); border-radius: 50%; display: inline-block; }

.banner-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(2rem, 4.5vw, 3.5rem);
    color: #fff; line-height: 1.1; margin: 0 0 0.85rem;
}
.banner-title em { color: var(--rouge); font-style: italic; }

.banner-sub {
    color: rgba(255,255,255,0.62);
    font-size: 0.9rem; line-height: 1.7;
    max-width: 520px; margin-bottom: 2rem;
}

/* ── SEARCH CARD ─────────────────────────────────── */
.search-card {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    max-width: 760px;
}

.search-card select,
.search-card input[type="search"] {
    background: rgba(255,255,255,0.95);
    border: none;
    border-radius: 10px;
    padding: 0.65rem 1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    color: var(--blue);
    outline: none;
    flex: 1 1 200px;
    transition: box-shadow 0.2s;
}
.search-card select:focus,
.search-card input:focus { box-shadow: 0 0 0 3px rgba(200,16,46,0.3); }

.search-row { display: flex; gap: 0.6rem; flex: 1 1 100%; }
.search-card input[type="search"] { flex: 1; }

.btn-search {
    background: var(--rouge);
    color: #fff; border: none;
    border-radius: 10px;
    padding: 0.65rem 1.3rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    display: flex; align-items: center; gap: 0.35rem;
    transition: background 0.2s;
}
.btn-search:hover { background: #a50d26; }

.btn-alerte {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,0.35);
    border-radius: 10px;
    padding: 0.6rem 1.1rem;
    font-size: 0.82rem; font-weight: 600;
    text-decoration: none; white-space: nowrap;
    transition: background 0.2s;
}
.btn-alerte:hover { background: rgba(255,255,255,0.22); }

/* ── OFFERS SECTION ──────────────────────────────── */
#offres { padding: 4rem 0 5rem; }

.section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap; gap: 1rem;
    margin-bottom: 2.5rem;
}

.section-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    color: var(--blue); margin: 0;
}
.section-title span { color: var(--rouge); }

.result-count {
    font-size: 0.82rem;
    color: var(--muted);
    font-weight: 500;
}

/* ── OFFER CARDS ─────────────────────────────────── */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.5rem;
}

.offer-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    display: flex; flex-direction: column;
    cursor: pointer;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}
.offer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 48px rgba(11,45,94,0.11);
    border-color: rgba(200,16,46,0.25);
}

.card-header {
    padding: 1.25rem 1.5rem 1rem;
    display: flex; align-items: flex-start; gap: 1rem;
    border-bottom: 1px solid var(--border);
}

.card-logo {
    width: 50px; height: 50px;
    border-radius: 10px;
    object-fit: contain;
    background: var(--bg);
    border: 1px solid var(--border);
    padding: 4px; flex-shrink: 0;
}

.card-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.05rem;
    color: var(--blue); line-height: 1.35;
    margin: 0 0 0.2rem;
    transition: color 0.2s;
}
.offer-card:hover .card-title { color: var(--rouge); }
.card-ac { font-size: 0.78rem; color: var(--muted); font-weight: 500; }

.card-body { padding: 1rem 1.5rem; flex: 1; }

.card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
.tag {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.04em; text-transform: uppercase;
    padding: 0.25rem 0.65rem; border-radius: 50px;
}
.tag-categ { background: #EEF2FF; color: #3730A3; }
.tag-type  { background: #FEF3C7; color: #92400E; }

.card-dates { display: flex; justify-content: space-between; gap: 0.5rem; }
.date-item  { font-size: 0.8rem; }
.date-label { color: var(--muted); display: block; margin-bottom: 0.1rem; font-size: 0.72rem; }
.date-value { color: var(--blue); font-weight: 600; }
.date-value.expired { color: var(--rouge); }

.card-footer {
    padding: 0.9rem 1.5rem;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 0.75rem;
}

.btn-details {
    background: var(--blue); color: #fff;
    border: none; border-radius: 8px;
    padding: 0.55rem 1.1rem;
    font-size: 0.82rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; flex: 1;
    transition: background 0.2s;
}
.btn-details:hover { background: #0d3978; }

.btn-dl {
    display: inline-flex; align-items: center; gap: 0.35rem;
    background: transparent; color: var(--rouge);
    border: 1.5px solid var(--rouge);
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.82rem; font-weight: 600;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
    white-space: nowrap;
}
.btn-dl:hover { background: var(--rouge); color: #fff; }

/* ── PAGINATION ──────────────────────────────────── */
.pagination-wrap {
    margin-top: 3rem;
    display: flex; justify-content: center;
}

/* ── EMPTY STATE ─────────────────────────────────── */
.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    color: var(--muted);
}
.empty-state svg { margin: 0 auto 1.25rem; display: block; opacity: 0.3; }
.empty-state p { font-size: 1rem; }

/* ── MODAL ───────────────────────────────────────── */
.swal2-popup.offer-modal {
    border-radius: 20px !important;
    padding: 0 !important;
    max-width: 560px !important;
    overflow: hidden !important;
    font-family: 'DM Sans', sans-serif !important;
}
.modal-inner { display: flex; flex-direction: column; }
.modal-top {
    background: var(--blue);
    padding: 1.75rem 2rem 1.5rem;
    position: relative;
}
.modal-top::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; background: var(--rouge);
}
.modal-badge {
    display: inline-block;
    background: rgba(200,16,46,0.25);
    color: rgba(255,255,255,0.85);
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    padding: 0.25rem 0.7rem; border-radius: 50px; margin-bottom: 0.65rem;
}
.modal-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.5rem; color: #fff;
    line-height: 1.3; margin: 0; text-align: left;
}
.modal-ac { color: rgba(255,255,255,0.6); font-size: 0.85rem; margin-top: 0.4rem; text-align: left; }
.modal-body { padding: 1.5rem 2rem; }
.modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem; }
.modal-field { display: flex; flex-direction: column; gap: 0.2rem; }
.modal-field-label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
.modal-field-value { font-size: 0.92rem; color: var(--blue); font-weight: 500; }
.modal-divider { border: none; border-top: 1px solid var(--border); margin: 0 0 1.25rem; }
.modal-dates {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;
    background: var(--bg); border-radius: 12px;
    padding: 1rem 1.25rem; margin-bottom: 1.5rem;
}
.date-block { display: flex; flex-direction: column; gap: 0.15rem; }
.date-block .lbl { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
.date-block .val { font-size: 0.95rem; font-weight: 600; color: var(--blue); }
.date-block.expire .val { color: var(--rouge); }
.modal-actions { display: flex; gap: 0.75rem; }
.modal-btn-primary {
    flex: 1; background: var(--blue); color: #fff;
    border: none; border-radius: 10px;
    padding: 0.75rem 1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 600; cursor: pointer;
    transition: background 0.2s;
}
.modal-btn-primary:hover { background: #0d3978; }
.modal-btn-download {
    flex: 1; background: var(--rouge); color: #fff;
    border: none; border-radius: 10px;
    padding: 0.75rem 1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 600;
    cursor: pointer; text-decoration: none;
    display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    transition: background 0.2s;
}
.modal-btn-download:hover { background: #a50d26; }

/* spinner */
.modal-loading {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; padding: 3rem 2rem;
    gap: 1rem; color: var(--muted); font-size: 0.9rem;
}
.spinner {
    width: 36px; height: 36px;
    border: 3px solid var(--border);
    border-top-color: var(--blue);
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── RESPONSIVE ──────────────────────────────────── */
@media (max-width: 768px) {
    #banner         { padding: 2.5rem 0 2rem; }
    .banner-sub     { font-size: 0.875rem; }
    .search-card    { padding: 1rem; gap: 0.6rem; }
    .search-card select,
    .search-card input[type="search"] { flex: 1 1 100%; }
    .search-row     { flex-direction: column; }
    .btn-search     { width: 100%; justify-content: center; }
    .btn-alerte     { width: 100%; justify-content: center; }
    #offres         { padding: 2.5rem 0 3rem; }
    .offers-grid    { grid-template-columns: 1fr; }
    .section-head   { flex-direction: column; align-items: flex-start; }
    .swal2-popup.offer-modal { max-width: 95vw !important; }
    .modal-grid,
    .modal-dates    { grid-template-columns: 1fr; }
    .modal-actions  { flex-direction: column-reverse; }
    .modal-body     { padding: 1.25rem; }
    .modal-top      { padding: 1.25rem; }
    .card-footer    { flex-direction: column; }
    .btn-details, .btn-dl { width: 100%; justify-content: center; }
}
</style>
@endsection


@section('banner')
<section id="banner">
    <div class="container mx-auto px-4" style="position:relative; z-index:1;">
        <div class="banner-eyebrow">
            <span></span> Appels d'offres — Bénin
        </div>
        <h1 class="banner-title">
            Toutes les offres<br><em>publiées</em>
        </h1>
        <p class="banner-sub">
            Découvrez toutes les opportunités disponibles. Que vous soyez une entreprise en quête de marchés ou un entrepreneur en quête de projets, explorez notre sélection d'appels d'offres publics et privés.
        </p>

        <form action="{{ route('offre.recherche') }}" method="post" class="search-card">
            @csrf
            <select name="categ">
                <option value="0">Toutes les Autorités Contractantes</option>
                @foreach ($ac as $item)
                <option value="{{ $item->id }}" {{ (isset($categ) && $categ == $item->id) ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
                @endforeach
            </select>

            <select name="type">
                <option value="0">Tous les Domaines d'Activités</option>
                @foreach ($types as $item)
                <option value="{{ $item->id }}" {{ (isset($type) && $type == $item->id) ? 'selected' : '' }}>
                    {{ $item->title }}
                </option>
                @endforeach
            </select>

            <div class="search-row">
                <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Que cherchez-vous ?" />
                <button type="submit" class="btn-search">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Rechercher
                </button>
            </div>

            <a href="{{ route('alerte') }}" class="btn-alerte">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Créer une alerte
            </a>
        </form>
    </div>
</section>
@endsection


@section('contenu')
<section id="offres">
    <div class="container mx-auto px-4">

        <div class="section-head">
            <h2 class="section-title">Dernières offres <span>publiées</span></h2>
            @if(isset($offres) && method_exists($offres, 'total'))
                <span class="result-count">{{ $offres->total() }} offre{{ $offres->total() > 1 ? 's' : '' }} trouvée{{ $offres->total() > 1 ? 's' : '' }}</span>
            @endif
        </div>

        @if(isset($offres) && $offres->count())
            <div class="offers-grid">
                @foreach ($offres as $item)
                <div class="offer-card" onclick="handleOfferClick('{{ $item->id }}')">

                    <div class="card-header">
                        <img src="{{ $item->logo ? asset($item->logo) : asset('default_offres.jpg') }}"
                             alt="logo" class="card-logo">
                        <div style="flex:1; min-width:0;">
                            <div class="card-title">{{ Str::limit($item->titre, 65) }}</div>
                            <div class="card-ac">{{ $item->autName }}</div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-tags">
                            @if($item->categTitle)
                                <span class="tag tag-categ">{{ $item->categTitle }}</span>
                            @endif
                            @if($item->typeTitle)
                                <span class="tag tag-type">{{ $item->typeTitle }}</span>
                            @endif
                        </div>
                        <div class="card-dates">
                            <div class="date-item">
                                <span class="date-label">Publiée le</span>
                                <span class="date-value">{{ date('d M Y', strtotime($item->datePublication)) }}</span>
                            </div>
                            <div class="date-item" style="text-align:right;">
                                <span class="date-label">Expire le</span>
                                <span class="date-value expired">{{ date('d M Y', strtotime($item->dateExpiration)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn-details" onclick="event.stopPropagation(); handleOfferClick('{{ $item->id }}')">
                            Voir les détails
                        </button>
                        <a href="{{ route('voirFichier', basename($item->fichier)) }}"
                           class="btn-dl"
                           onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Télécharger
                        </a>
                    </div>

                </div>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $offres->links() }}
            </div>

        @else
            <div class="empty-state">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <p>Aucune offre disponible pour le moment.</p>
            </div>
        @endif

    </div>
</section>
@endsection


@section('code')
<script>
function handleOfferClick(offerId) {
    @if(!auth()->check())
        Swal.fire({
            html: `<div style="font-family:'DM Sans',sans-serif;padding:0.5rem 0;">
                <p style="font-size:1.05rem;font-weight:600;color:#0B2D5E;margin-bottom:0.5rem;">Accès restreint</p>
                <p style="color:#6B7280;font-size:0.875rem;">Inscrivez-vous et souscrivez à un abonnement pour consulter les détails.</p>
            </div>`,
            confirmButtonText: "S'inscrire maintenant",
            confirmButtonColor: '#0B2D5E',
            showCancelButton: true,
            cancelButtonText: 'Annuler',
        }).then(r => { if (r.isConfirmed) window.location.href = "{{ route('register') }}"; });
    @else
        fetchOfferDetails(offerId);
    @endif
}

function fetchOfferDetails(offerId) {
    Swal.fire({
        html: `<div class="modal-loading"><div class="spinner"></div><span>Chargement…</span></div>`,
        showConfirmButton: false,
        customClass: { popup: 'offer-modal' },
        allowOutsideClick: false,
    });

    $.ajax({
        url: '/offre/details/' + offerId,
        method: 'GET',
        success: function(data) {
            const fileBtn = data.file
                ? `<a href="${data.file}" target="_blank" class="modal-btn-download">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Télécharger le dossier
                   </a>`
                : `<span style="flex:1;text-align:center;color:#9CA3AF;font-size:0.82rem;">Aucun fichier disponible</span>`;

            Swal.fire({
                html: `
                    <div class="modal-inner">
                        <div class="modal-top">
                            <div class="modal-badge">Appel d'offres</div>
                            <div class="modal-title">${data.titre}</div>
                            <div class="modal-ac">${data.autName ?? '—'}</div>
                        </div>
                        <div class="modal-body">
                            <div class="modal-grid">
                                <div class="modal-field">
                                    <span class="modal-field-label">Catégorie</span>
                                    <span class="modal-field-value">${data.categTitle ?? '—'}</span>
                                </div>
                                <div class="modal-field">
                                    <span class="modal-field-label">Type de marché</span>
                                    <span class="modal-field-value">${data.typeTitle ?? 'Non spécifié'}</span>
                                </div>
                            </div>
                            <hr class="modal-divider">
                            <div class="modal-dates">
                                <div class="date-block">
                                    <span class="lbl">Date de publication</span>
                                    <span class="val">${data.datePublication}</span>
                                </div>
                                <div class="date-block expire">
                                    <span class="lbl">Date d'expiration</span>
                                    <span class="val">${data.dateExpiration}</span>
                                </div>
                            </div>
                            <div class="modal-actions">
                                ${fileBtn}
                                <button class="modal-btn-primary" onclick="Swal.close()">Fermer</button>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                customClass: { popup: 'offer-modal' },
                backdrop: 'rgba(11,45,94,0.45)',
            });
        },
        error: function() {
            Swal.fire({
                title: 'Erreur',
                text: "Impossible de récupérer les détails de l'offre.",
                icon: 'error',
                confirmButtonColor: '#0B2D5E',
                confirmButtonText: 'Fermer',
            });
        }
    });
}
</script>
@endsection