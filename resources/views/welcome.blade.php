@extends('layout.userLayout.template')

@section('titre')
<title>Le Consultant | Accueil</title>
<!-- Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

<style>
:root {
    --blue:    #0136ba;
    --rouge:   #c8102fa8;
    --bg:      #F5F4F0;
    --card-bg: #FFFFFF;
    --muted:   #6B7280;
    --border:  #E5E3DC;
}

*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); }

/* ── BANNER ─────────────────────────────────────────────── */
#banner { position: relative; overflow: hidden; }

.banner-blue {
    background: var(--blue);
    padding: 5rem 0 3rem;
    position: relative;
}
.banner-blue::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 60%, rgba(200,16,46,0.18) 0%, transparent 65%);
    pointer-events: none;
}

.banner-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(200,16,46,0.2);
    border: 1px solid rgba(200,16,46,0.4);
    color: rgba(255,255,255,0.85);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 0.3rem 0.85rem;
    border-radius: 50px;
    margin-bottom: 1.25rem;
}
.banner-eyebrow span { width: 6px; height: 6px; background: var(--rouge); border-radius: 50%; display: inline-block; }

.banner-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(2.4rem, 5.5vw, 4.5rem);
    color: #fff;
    line-height: 1.08;
    margin: 0 0 1.5rem;
}
.banner-title em { color: var(--rouge); font-style: italic; }

.banner-sub {
    color: rgba(255,255,255,0.68);
    font-size: 1rem;
    line-height: 1.75;
    max-width: 520px;
    margin-bottom: 2.5rem;
}

/* Stats strip */
.stats-strip {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}
.stat-item { display: flex; flex-direction: column; }
.stat-val {
    font-family: 'Instrument Serif', serif;
    font-size: 1.9rem;
    color: #fff;
    line-height: 1;
}
.stat-lbl { font-size: 0.72rem; color: rgba(255,255,255,0.5); font-weight: 500; letter-spacing: 0.05em; }

/* CTA buttons */
.banner-ctas { display: flex; flex-wrap: wrap; gap: 0.75rem; }

.btn-primary {
    background: var(--rouge);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 1.6rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
    display: inline-flex; align-items: center; gap: 0.4rem;
}
.btn-primary:hover { background: #a50d26; transform: translateY(-2px); }

.btn-outline-white {
    background: transparent;
    color: rgba(255,255,255,0.85);
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    padding: 0.75rem 1.4rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.2s, border-color 0.2s;
    display: inline-flex; align-items: center; gap: 0.4rem;
}
.btn-outline-white:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.6); }

/* Hero image */
.hero-image-wrap {
    position: absolute;
    right: -4%;
    top: 0; bottom: 0;
    width: 45%;
    display: flex;
    align-items: flex-end;
}
.hero-image-wrap img { width: 100%; height: 100%; object-fit: cover; object-position: top; }
.hero-image-wrap::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 160px;
    background: linear-gradient(to right, var(--blue), transparent);
    z-index: 1;
}

/* ── SEARCH BAR ──────────────────────────────────────────── */
.search-section {
    background: var(--rouge);
    padding: 2rem 0;
    position: relative;
    z-index: 2;
}

.search-card {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.25);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    max-width: 860px;
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
.search-card input:focus { box-shadow: 0 0 0 3px rgba(11,45,94,0.3); }

.search-card .search-row {
    display: flex;
    gap: 0.6rem;
    flex: 1 1 100%;
}
.search-card input[type="search"] { flex: 1; }

.btn-search-red {
    background: var(--blue);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.65rem 1.3rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.2s;
    display: flex; align-items: center; gap: 0.35rem;
}
.btn-search-red:hover { background: #0d3978; }

.btn-alerte-white {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(255,255,255,0.15);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,0.4);
    border-radius: 10px;
    padding: 0.6rem 1.1rem;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
    white-space: nowrap;
}
.btn-alerte-white:hover { background: rgba(255,255,255,0.25); }

/* ── OFFER CARDS ─────────────────────────────────────────── */
#offres { padding: 4.5rem 0 5rem; }

.section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2.5rem;
}

.section-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    color: var(--blue);
    margin: 0;
}
.section-title span { color: var(--rouge); }

.see-all {
    display: inline-flex; align-items: center; gap: 0.35rem;
    color: var(--rouge);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: gap 0.2s;
}
.see-all:hover { gap: 0.6rem; }

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
    display: flex;
    flex-direction: column;
    cursor: pointer;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
    animation: fadeUp 0.5s ease both;
}
.offer-card:hover { transform: translateY(-5px); box-shadow: 0 20px 48px rgba(11,45,94,0.11); border-color: rgba(200,16,46,0.25); }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
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
    padding: 4px;
    flex-shrink: 0;
}

.card-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.05rem;
    color: var(--blue);
    line-height: 1.35;
    margin: 0 0 0.2rem;
    transition: color 0.2s;
}
.offer-card:hover .card-title { color: var(--rouge); }
.card-ac { font-size: 0.78rem; color: var(--muted); font-weight: 500; }

.card-body { padding: 1rem 1.5rem; flex: 1; }

.card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
.tag {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 0.25rem 0.65rem;
    border-radius: 50px;
}
.tag-categ { background: #EEF2FF; color: #3730A3; }
.tag-type  { background: #FEF3C7; color: #92400E; }

.card-dates { display: flex; justify-content: space-between; gap: 0.5rem; }
.date-item { font-size: 0.8rem; }
.date-label { color: var(--muted); display: block; margin-bottom: 0.1rem; font-size: 0.72rem; }
.date-value { color: var(--blue); font-weight: 600; }
.date-value.expired { color: var(--rouge); }

.card-footer {
    padding: 0.9rem 1.5rem;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    gap: 0.75rem;
}

.btn-card-details {
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
    flex: 1;
}
.btn-card-details:hover { background: #0d3978; }

/* Load more */
.load-more-wrap { margin-top: 3rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }

.btn-load {
    background: var(--rouge);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    display: inline-flex; align-items: center; gap: 0.4rem;
}
.btn-load:hover { background: #a50d26; transform: translateY(-2px); }

.btn-load-less {
    background: transparent;
    color: var(--muted);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0.75rem 1.8rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: border-color 0.2s, color 0.2s;
}
.btn-load-less:hover { border-color: var(--muted); color: var(--blue); }

/* ── NEWS ─────────────────────────────────────────────────── */
#actualites { padding: 4.5rem 0; background: #fff; }

.news-card {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    text-align: left;
    max-width: 800px;
    margin: 0 auto;
}

.news-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
}

.news-card-body { padding: 1.5rem 2rem 2rem; }

.news-source {
    display: inline-block;
    background: rgba(11,45,94,0.08);
    color: var(--blue);
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.25rem 0.7rem;
    border-radius: 50px;
    margin-bottom: 0.85rem;
}

.news-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.5rem;
    color: var(--blue);
    line-height: 1.3;
    margin: 0 0 0.75rem;
}

.news-desc { color: var(--muted); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem; }

.btn-news {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: var(--blue);
    color: #fff;
    border-radius: 10px;
    padding: 0.65rem 1.3rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.btn-news:hover { background: #0d3978; }

.swiper-button-next,
.swiper-button-prev {
    background: #fff;
    width: 44px !important; height: 44px !important;
    border-radius: 50%;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    color: var(--blue) !important;
}
.swiper-button-next::after,
.swiper-button-prev::after { font-size: 1rem !important; font-weight: 900 !important; }

.swiper-pagination-bullet { background: var(--blue); opacity: 0.3; }
.swiper-pagination-bullet-active { opacity: 1; background: var(--rouge); }

/* ── CTA STRIP ───────────────────────────────────────────── */
#subscription-call {
    padding: 5rem 0;
    background: var(--blue);
    position: relative;
    overflow: hidden;
}
#subscription-call::before {
    content: '';
    position: absolute;
    top: -50%; right: -10%;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,16,46,0.2) 0%, transparent 70%);
    pointer-events: none;
}

.cta-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(1.8rem, 4vw, 3rem);
    color: #fff;
    margin: 0 0 1rem;
}

.cta-sub {
    color: rgba(255,255,255,0.7);
    font-size: 1rem;
    max-width: 580px;
    margin: 0 auto 2.5rem;
    line-height: 1.75;
}

.cta-price {
    display: inline-block;
    font-family: 'Instrument Serif', serif;
    font-size: 1.5rem;
    color: #F9D949;
}

.cta-buttons { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }

.btn-cta-primary {
    background: var(--rouge);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.85rem 2rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
}
.btn-cta-primary:hover { background: #a50d26; transform: translateY(-2px); }

.btn-cta-secondary {
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    padding: 0.85rem 2rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.btn-cta-secondary:hover { background: rgba(255,255,255,0.2); }

/* ── MODAL ───────────────────────────────────────────────── */
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
    color: var(--muted);
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
.date-block .lbl { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
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

/* Subscription modal */
.sub-modal-price {
    font-family: 'Instrument Serif', serif;
    font-size: 2.5rem;
    color: var(--blue);
    display: block;
    margin: 0.5rem 0 0.2rem;
}
.sub-modal-period { font-size: 0.8rem; color: var(--muted); font-weight: 500; }

.phone-input {
    width: 100%;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    color: var(--blue);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    margin-top: 1rem;
}
.phone-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(11,45,94,0.12); }
.phone-hint { font-size: 0.75rem; color: var(--muted); margin-top: 0.4rem; }

@media (max-width: 768px) {
    .hero-image-wrap { display: none; }
    .banner-blue { padding: 3rem 0 2rem; }
    .modal-grid, .modal-dates { grid-template-columns: 1fr; }
    .modal-actions { flex-direction: column-reverse; }
    .offers-grid { grid-template-columns: 1fr; }
}
</style>
@endsection


@section('banner')

@if($user && !$hasActiveSubscription)
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        html: `
            <div style="font-family:'DM Sans',sans-serif; padding: 0;">
                <div style="background:#0B2D5E; padding:1.5rem 2rem; border-radius:0; margin:-1px; text-align:left; border-bottom:3px solid #C8102E;">
                    <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.6);margin-bottom:0.5rem;">Accès plateforme</div>
                    <div style="font-family:'Instrument Serif',serif;font-size:1.6rem;color:#fff;">Activez votre abonnement</div>
                </div>
                <div style="padding:1.5rem 2rem;">
                    <div style="background:#F5F4F0;border-radius:12px;padding:1rem 1.25rem;text-align:center;margin-bottom:1.25rem;">
                        <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#6B7280;">Abonnement mensuel</div>
                        <span style="font-family:'Instrument Serif',serif;font-size:2.2rem;color:#0B2D5E;display:block;margin:0.25rem 0 0.1rem;">50 FCFA</span>
                        <div style="font-size:0.75rem;color:#6B7280;">accès illimité pendant 30 jours</div>
                    </div>
                    <p style="color:#6B7280;font-size:0.875rem;margin-bottom:1rem;">Entrez votre numéro Mobile Money pour continuer :</p>
                    <form id="subscription-form" action="{{ route('subscription.initiate', ['packId' => 1]) }}" method="POST">
                        @csrf
                        <input type="tel" name="phone" id="phone-input" class="phone-input"
                               placeholder="Ex: 97000000" pattern="[0-9]{8,15}" required>
                        <p class="phone-hint">Format : 8 à 15 chiffres</p>
                    </form>
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'Procéder au paiement →',
        confirmButtonColor: '#C8102E',
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: { popup: 'offer-modal' },
        preConfirm: () => {
            const phone = document.getElementById('phone-input').value;
            if (!phone || phone.length < 8) {
                Swal.showValidationMessage('Veuillez entrer un numéro valide (8 chiffres minimum)');
                return false;
            }
            return phone;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('subscription-form').submit();
        }
    });
});
</script>
@endif

@include('sweetalert::alert')

<section id="banner">
    <!-- Blue Hero -->
    <div class="banner-blue">
        <div class="container mx-auto px-4" style="position:relative; z-index:1;">
            <div style="max-width: 55%;">
                <div class="banner-eyebrow">
                    <span></span> Plateforme d'appels d'offres — Bénin
                </div>
                <h1 class="banner-title">
                    Trouvez les meilleures<br>
                    <em>opportunités d'affaires</em><br>
                    au Bénin
                </h1>
                <p class="banner-sub">
                    Accédez à tous les appels d'offres publics et privés en un seul endroit. Ne manquez plus aucune opportunité grâce à nos alertes personnalisées.
                </p>

                <div class="stats-strip">
                    <div class="stat-item">
                        <span class="stat-val">{{ $totalOffres ?? '100' }}+</span>
                        <span class="stat-lbl">Offres disponibles</span>
                    </div>
                    <div class="stat-item" style="padding-left:1.5rem; border-left: 1px solid rgba(255,255,255,0.15);">
                        <span class="stat-val">24h</span>
                        <span class="stat-lbl">Mise à jour</span>
                    </div>
                    <div class="stat-item" style="padding-left:1.5rem; border-left: 1px solid rgba(255,255,255,0.15);">
                        <span class="stat-val">∞</span>
                        <span class="stat-lbl">Alertes personnalisées</span>
                    </div>
                </div>

                <div class="banner-ctas">
                    <a href="{{ route('offre.recherche') }}" class="btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Explorer les offres
                    </a>
                    <a href="{{ route('alerte') }}" class="btn-outline-white">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Créer une alerte
                    </a>
                </div>
            </div>
        </div>

        <div class="hero-image-wrap lg:flex hidden">
            <img src="{{ asset('assets/img/Photo%201.png') }}" alt="Hero" />
        </div>
    </div>

    <!-- Search bar -->
    <div class="search-section">
        <div class="container mx-auto px-4">
            <form action="{{ route('offre.recherche') }}" method="post" class="search-card">
                @csrf
                <select name="categ">
                    <option value="0">Toutes les Autorités Contractantes</option>
                    @foreach ($ac as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <select name="type">
                    <option value="0">Tous les Domaines d'Activités</option>
                    @foreach ($types as $item)
                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select>
                <div class="search-row">
                    <input type="search" name="search" placeholder="Que cherchez-vous ?" />
                    <button type="submit" class="btn-search-red">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Rechercher
                    </button>
                </div>
                <a href="{{ route('alerte') }}" class="btn-alerte-white">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Créer une alerte
                </a>
            </form>
        </div>
    </div>
</section>
@endsection


@section('contenu')
<!-- ── OFFERS ─────────────────────────────────────── -->
<section id="offres">
    <div class="container mx-auto px-4">

        <div class="section-head" data-aos="fade-up">
            <h2 class="section-title">Dernières offres <span>publiées</span></h2>
            <a href="{{ route('offre.recherche') }}" class="see-all">
                Voir toutes les offres
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div id="offre-list" class="offers-grid">
            @foreach ($offres as $item)
            <div class="offer-card" onclick="handleOfferClick('{{ $item->id }}')"
                 data-aos="fade-up" data-aos-delay="{{ min($loop->index * 80, 400) }}">

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
                        @if(auth()->check() && $item->typeTitle)
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
                    <button class="btn-card-details">Voir les détails →</button>
                </div>
            </div>
            @endforeach
        </div>

        @if ($totalOffres > 4)
        <div class="load-more-wrap">
            <button id="load-more" class="btn-load" onclick="handleLoadMore()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Voir plus d'offres
            </button>
            <button id="load-less" class="btn-load-less" style="display:none;" onclick="loadLessOffres()">
                Voir moins
            </button>
        </div>
        @endif

    </div>
</section>


<!-- ── NEWS ──────────────────────────────────────── -->
@if(!empty($news) && count($news) > 0)
<section id="actualites">
    <div class="container mx-auto px-4">

        <div class="section-head" data-aos="fade-up">
            <h2 class="section-title">Actualités <span>du Bénin</span></h2>
        </div>

        <div class="swiper-container" data-aos="fade-up" data-aos-delay="150">
            <div class="swiper-wrapper">
                @foreach($news as $article)
                <div class="swiper-slide">
                    <div class="news-card">
                        @if(isset($article->urlToImage) && $article->urlToImage)
                        <img src="{{ $article->urlToImage }}" alt="{{ $article->title ?? '' }}">
                        @endif
                        <div class="news-card-body">
                            @if(isset($article->source->name))
                            <span class="news-source">{{ $article->source->name }}</span>
                            @endif
                            <div class="news-title">{{ $article->title ?? 'Sans titre' }}</div>
                            <p class="news-desc">{{ Str::limit($article->description ?? '', 200) }}</p>
                            @if(isset($article->url))
                            <a href="{{ $article->url }}" target="_blank" class="btn-news">
                                Lire l'article complet
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination" style="margin-top: 1.5rem; position:relative;"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
@endif


<!-- ── CTA ───────────────────────────────────────── -->
@if(!auth()->check())
<section id="subscription-call">
    <div class="container mx-auto px-4 text-center" data-aos="fade-up" style="position:relative; z-index:1;">
        <div class="banner-eyebrow" style="margin: 0 auto 1.25rem; display:inline-flex;">
            <span></span> Rejoignez la plateforme
        </div>
        <h2 class="cta-title">Accédez à toutes les opportunités</h2>
        <p class="cta-sub">
            Inscrivez-vous et souscrivez à notre abonnement mensuel à seulement
            <span class="cta-price">1 490 FCFA</span>
            pour profiter de toutes les fonctionnalités et alertes personnalisées.
        </p>
        <div class="cta-buttons">
            <a href="{{ route('register.morale') }}" class="btn-cta-primary">S'inscrire maintenant</a>
            <a href="{{ route('login') }}" class="btn-cta-secondary">Se connecter</a>
        </div>
    </div>
</section>
@endif
@endsection


@section('code')
<script>
AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 80 });

var swiper = new Swiper('.swiper-container', {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 20,
    pagination: { el: '.swiper-pagination', clickable: true },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    autoplay: { delay: 6000, disableOnInteraction: false },
});

// ── Offer click ───────────────────────────────────
function handleOfferClick(offerId) {
    const isLoggedIn    = @json(auth()->check());
    const hasSub        = @json($hasActiveSubscription ?? false);

    if (!isLoggedIn) {
        Swal.fire({
            html: `
                <div style="font-family:'DM Sans',sans-serif; padding:0.5rem 0;">
                    <p style="font-size:1.1rem;font-weight:600;color:#0B2D5E;margin-bottom:0.5rem;">Connexion requise</p>
                    <p style="color:#6B7280;font-size:0.9rem;">Vous devez vous connecter pour consulter les détails de cette offre.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Se connecter',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#0B2D5E',
            cancelButtonColor: '#E5E3DC',
        }).then(r => { if (r.isConfirmed) window.location.href = '/login'; });

    } else if (!hasSub) {
        Swal.fire({
            html: `
                <div style="font-family:'DM Sans',sans-serif; padding:0.5rem 0;">
                    <p style="font-size:1.1rem;font-weight:600;color:#0B2D5E;margin-bottom:0.5rem;">Abonnement requis</p>
                    <p style="color:#6B7280;font-size:0.9rem;">Activez votre abonnement pour consulter les détails des offres.</p>
                </div>
            `,
            confirmButtonText: 'OK',
            confirmButtonColor: '#0B2D5E',
        });
    } else {
        fetchOfferDetails(offerId);
    }
}

// ── Fetch & show modal ────────────────────────────
function fetchOfferDetails(offerId) {
    Swal.fire({
        html: `<div class="modal-loading"><div class="spinner"></div><span>Chargement…</span></div>`,
        showConfirmButton: false,
        customClass: { popup: 'offer-modal' },
        allowOutsideClick: false,
    });

    fetch('/offre/details/' + offerId)
        .then(r => r.json())
        .then(data => {
            const fileBtn = data.file
                ? `<a href="${data.file}" target="_blank" class="modal-btn-download">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Télécharger
                   </a>`
                : `<span style="flex:1;text-align:center;color:#9CA3AF;font-size:0.82rem;">Aucun fichier</span>`;

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
        })
        .catch(() => {
            Swal.fire({
                title: 'Erreur',
                text: "Impossible de récupérer les détails.",
                icon: 'error',
                confirmButtonColor: '#0B2D5E',
            });
        });
}

// ── Load more ─────────────────────────────────────
function handleLoadMore() {
    const isLoggedIn = @json(auth()->check());
    if (!isLoggedIn) {
        Swal.fire({
            html: `<p style="font-family:'DM Sans',sans-serif;color:#6B7280;">Connectez-vous pour voir plus d'offres.</p>`,
            showCancelButton: true,
            confirmButtonText: 'Se connecter',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#0B2D5E',
        }).then(r => { if (r.isConfirmed) window.location.href = '/login'; });
    } else {
        window.location.href = '/appels-d-offres';
    }
}
</script>
@endsection