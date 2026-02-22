@extends('layout.userLayout.template')

@section('titre')
<title>Le Consultant | Appels d'Offres</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --blue: #0B2D5E;
        --rouge: #C8102E;
        --bg: #F5F4F0;
        --card-bg: #FFFFFF;
        --text-muted: #6B7280;
        --border: #E5E3DC;
    }

    body { font-family: 'DM Sans', sans-serif; background: var(--bg); }

    /* ─── BANNER ──────────────────────────────────────────── */
    #banner { background: var(--blue); position: relative; overflow: hidden; }
    #banner::after {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse at 80% 50%, rgba(200,16,46,0.15) 0%, transparent 65%);
        pointer-events: none;
    }

    .banner-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        color: #fff;
        line-height: 1.1;
        margin-bottom: 1rem;
    }

    .banner-sub { color: rgba(255,255,255,0.72); font-size: 1rem; line-height: 1.7; max-width: 540px; margin-bottom: 2rem; }

    /* Search bar */
    .search-bar {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        max-width: 680px;
    }

    .search-bar select,
    .search-bar input[type="search"] {
        background: rgba(255,255,255,0.95);
        border: none;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        color: var(--blue);
        outline: none;
        transition: box-shadow 0.2s;
    }
    .search-bar select:focus,
    .search-bar input[type="search"]:focus {
        box-shadow: 0 0 0 3px rgba(200,16,46,0.35);
    }

    .search-bar select { flex: 1 1 180px; }
    .search-bar .search-input-wrap { flex: 1 1 100%; display: flex; gap: 0.5rem; }
    .search-bar input[type="search"] { flex: 1; }

    .btn-search {
        background: var(--rouge);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.65rem 1.4rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        white-space: nowrap;
    }
    .btn-search:hover { background: #a50d26; }
    .btn-search:active { transform: scale(0.98); }

    .btn-alerte {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: transparent;
        border: 1.5px solid rgba(255,255,255,0.45);
        color: rgba(255,255,255,0.9);
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
        margin-top: 0.25rem;
    }
    .btn-alerte:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.7); }

    /* ─── CARDS ───────────────────────────────────────────── */
    #offres { padding: 4rem 0 5rem; }

    .section-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.8rem);
        color: var(--blue);
        margin-bottom: 2.5rem;
    }
    .section-title span { color: var(--rouge); }

    .offers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
    }

    .offer-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }
    .offer-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(11,45,94,0.12); }

    .card-header {
        padding: 1.25rem 1.5rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        border-bottom: 1px solid var(--border);
    }

    .card-logo {
        width: 52px; height: 52px;
        border-radius: 10px;
        object-fit: contain;
        background: var(--bg);
        padding: 4px;
        flex-shrink: 0;
        border: 1px solid var(--border);
    }

    .card-title {
        font-family: 'Instrument Serif', serif;
        font-size: 1.1rem;
        color: var(--blue);
        line-height: 1.35;
        margin-bottom: 0.2rem;
        transition: color 0.2s;
    }
    .offer-card:hover .card-title { color: var(--rouge); }

    .card-ac { font-size: 0.8rem; color: var(--text-muted); font-weight: 500; }

    .card-body { padding: 1rem 1.5rem; flex: 1; }

    .card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 0.9rem; }
    .tag {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 0.25rem 0.65rem;
        border-radius: 50px;
    }
    .tag-categ { background: #EEF2FF; color: #3730A3; }
    .tag-type  { background: #FEF3C7; color: #92400E; }

    .card-dates { display: flex; justify-content: space-between; gap: 0.5rem; }
    .date-item { font-size: 0.8rem; }
    .date-label { color: var(--text-muted); display: block; margin-bottom: 0.1rem; }
    .date-value { color: var(--blue); font-weight: 600; }

    .card-footer {
        padding: 0.9rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .btn-details {
        background: var(--blue);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.55rem 1.1rem;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-details:hover { background: #0d3978; }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: transparent;
        color: var(--rouge);
        border: 1.5px solid var(--rouge);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
    }
    .btn-download:hover { background: var(--rouge); color: #fff; }

    /* ─── PAGINATION ──────────────────────────────────────── */
    .pagination-wrap { margin-top: 3rem; display: flex; justify-content: center; }
    .pagination-wrap nav span[aria-current],
    .pagination-wrap nav a {
        border-radius: 8px !important;
        font-family: 'DM Sans', sans-serif;
    }

    /* ─── MODAL ───────────────────────────────────────────── */
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
        height: 3px;
        background: var(--rouge);
    }

    .modal-badge {
        display: inline-block;
        background: rgba(200,16,46,0.25);
        color: rgba(255,255,255,0.85);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
        margin-bottom: 0.65rem;
    }

    .modal-title {
        font-family: 'Instrument Serif', serif;
        font-size: 1.5rem;
        color: #fff;
        line-height: 1.3;
        margin: 0;
        text-align: left;
    }

    .modal-ac {
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        margin-top: 0.4rem;
        text-align: left;
    }

    .modal-body { padding: 1.5rem 2rem; }

    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .modal-field { display: flex; flex-direction: column; gap: 0.2rem; }
    .modal-field-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-muted);
    }
    .modal-field-value {
        font-size: 0.92rem;
        color: var(--blue);
        font-weight: 500;
    }

    .modal-divider { border: none; border-top: 1px solid var(--border); margin: 0 0 1.25rem; }

    .modal-dates {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        background: var(--bg);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .date-block { display: flex; flex-direction: column; gap: 0.15rem; }
    .date-block .lbl { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted); }
    .date-block .val { font-size: 0.95rem; font-weight: 600; color: var(--blue); }
    .date-block.expire .val { color: var(--rouge); }

    .modal-actions { display: flex; gap: 0.75rem; }

    .modal-btn-primary {
        flex: 1;
        background: var(--blue);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .modal-btn-primary:hover { background: #0d3978; }

    .modal-btn-download {
        flex: 1;
        background: var(--rouge);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: background 0.2s;
    }
    .modal-btn-download:hover { background: #a50d26; }

    /* loading skeleton */
    .modal-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 2rem;
        gap: 1rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .spinner {
        width: 36px; height: 36px;
        border: 3px solid var(--border);
        border-top-color: var(--blue);
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection


@section('banner')
<section id="banner">
    <div style="padding: 4rem 0 5rem;">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="w-full lg:w-2/3">
                    <h1 class="banner-title">Tous les<br><em>Appels d'Offres</em></h1>
                    <p class="banner-sub">
                        Découvrez toutes les opportunités disponibles. Que vous soyez une entreprise en quête de marchés ou un entrepreneur à la recherche de projets, explorez notre sélection d'appels d'offres publics et privés.
                    </p>

                    <form action="{{ route('offre.recherche') }}" method="post" class="search-bar">
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

                        <div class="search-input-wrap">
                            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Que cherchez-vous ?" />
                            <button type="submit" class="btn-search">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-right:4px;vertical-align:middle;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                Rechercher
                            </button>
                        </div>

                        <a href="{{ route('alerte') }}" class="btn-alerte">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            Créer une alerte
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('contenu')
<section id="offres">
    <div class="container mx-auto px-4">

        <h2 class="section-title">
            Dernières offres <span>publiées</span>
        </h2>

        @if($offres->isEmpty())
            <div style="text-align:center; padding: 4rem 0; color: var(--text-muted);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; display:block; opacity:0.4;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <p style="font-size:1.1rem;">Aucune offre ne correspond à votre recherche.</p>
            </div>
        @else
            <div class="offers-grid">
                @foreach ($offres as $item)
                <div class="offer-card" onclick="handleOfferClick('{{ $item->id }}')">
                    <div class="card-header">
                        <img src="{{ $item->logo ? asset($item->logo) : asset('default_offres.jpg') }}" alt="logo" class="card-logo">
                        <div style="flex:1; min-width:0;">
                            <div class="card-title">{{ Str::limit($item->titre, 60) }}</div>
                            <div class="card-ac">{{ $item->autName }} · {{ $item->autAbre ?? '' }}</div>
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
                                <span class="date-value" style="color: var(--rouge);">{{ date('d M Y', strtotime($item->dateExpiration)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn-details" onclick="event.stopPropagation(); handleOfferClick('{{ $item->id }}')">
                            Voir les détails
                        </button>
                        <a href="{{ route('voirFichier', basename($item->fichier)) }}"
                           class="btn-download"
                           onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Télécharger
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <div class="pagination-wrap">
            {{ $offres->links() }}
        </div>
    </div>
</section>
@endsection


@section('code')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleOfferClick(offerId) {
        @if(!auth()->check())
            Swal.fire({
                title: 'Accès restreint',
                html: `<p style="color:#6B7280; font-family:'DM Sans',sans-serif;">Vous devez être inscrit et disposer d'un abonnement actif pour consulter les détails de cette offre.</p>`,
                icon: 'warning',
                confirmButtonText: "S'inscrire maintenant",
                confirmButtonColor: '#0B2D5E',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                cancelButtonColor: '#E5E3DC',
                customClass: { cancelButton: 'swal-cancel-custom' },
                borderRadius: '16px',
            }).then((result) => {
                if (result.isConfirmed) window.location.href = "{{ route('register') }}";
            });
        @else
            fetchOfferDetails(offerId);
        @endif
    }

    function fetchOfferDetails(offerId) {
        // Show loading modal
        Swal.fire({
            html: `
                <div class="modal-loading">
                    <div class="spinner"></div>
                    <span>Chargement de l'offre…</span>
                </div>
            `,
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
                    : `<span style="flex:1; text-align:center; color:#9CA3AF; font-size:0.82rem;">Aucun fichier disponible</span>`;

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