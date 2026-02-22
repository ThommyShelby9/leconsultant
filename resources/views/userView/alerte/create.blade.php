@extends('layout.userLayout.template')

@section('titre')
<title>Le Consultant | Créer une alerte</title>
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
#banner { background: var(--blue); padding: 4rem 0 3.5rem; position: relative; overflow: hidden; }
#banner::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 50%, rgba(200,16,46,0.15) 0%, transparent 65%);
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
    color: #fff; line-height: 1.1; margin: 0 0 0.75rem;
}
.banner-title em { color: var(--rouge); font-style: italic; }

.banner-sub { color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.7; max-width: 480px; }

/* ── FORM WRAPPER ────────────────────────────────── */
.form-section { padding: 4rem 0 5rem; }

.form-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    max-width: 860px;
    margin: 0 auto;
    box-shadow: 0 8px 40px rgba(11,45,94,0.07);
}

/* ── FORM HEADER ─────────────────────────────────── */
.form-card-header {
    background: linear-gradient(135deg, var(--blue) 0%, #0d3978 100%);
    padding: 1.5rem 2.5rem;
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem;
    border-bottom: 3px solid var(--rouge);
    position: relative;
}
.form-card-header::after {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 90% 50%, rgba(200,16,46,0.15) 0%, transparent 60%);
    pointer-events: none;
}

.form-card-header-text { position: relative; z-index: 1; }
.form-card-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.4rem; color: #fff; margin: 0 0 0.2rem;
}
.form-card-sub { font-size: 0.8rem; color: rgba(255,255,255,0.55); }

.header-icon {
    width: 48px; height: 48px;
    background: rgba(200,16,46,0.2);
    border: 1px solid rgba(200,16,46,0.4);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; position: relative; z-index: 1;
}

/* ── FORM BODY ───────────────────────────────────── */
.form-body { padding: 2rem 2.5rem 2.5rem; }

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* ── CHOICE GROUP ────────────────────────────────── */
.choice-group { display: flex; flex-direction: column; gap: 0; }

.choice-group-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.choice-group-label::after {
    content: '';
    flex: 1; height: 1px; background: var(--border);
}

.choice-list { display: flex; flex-direction: column; gap: 0.5rem; }

.choice-item {
    display: flex; align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    user-select: none;
}
.choice-item:hover { border-color: rgba(11,45,94,0.3); background: rgba(11,45,94,0.02); }
.choice-item.selected { border-color: var(--blue); background: rgba(11,45,94,0.04); }
.choice-item.selected .choice-check { background: var(--blue); border-color: var(--blue); }
.choice-item.selected .choice-check::after { opacity: 1; }
.choice-item.selected .choice-text { color: var(--blue); font-weight: 600; }

/* hide native checkbox */
.choice-item input[type="checkbox"] { display: none; }

.choice-check {
    width: 18px; height: 18px;
    border: 2px solid var(--border);
    border-radius: 5px;
    flex-shrink: 0;
    position: relative;
    background: var(--white);
    transition: background 0.2s, border-color 0.2s;
}
.choice-check::after {
    content: '';
    position: absolute;
    top: 2px; left: 5px;
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg);
    opacity: 0;
    transition: opacity 0.15s;
}

.choice-text { font-size: 0.875rem; color: var(--muted); transition: color 0.2s; }

/* count badge */
.choice-count {
    margin-left: auto;
    font-size: 0.7rem;
    font-weight: 700;
    color: #fff;
    background: var(--blue);
    padding: 0.1rem 0.5rem;
    border-radius: 50px;
    opacity: 0;
    transition: opacity 0.2s;
}

/* ── DOMAINE D'ACTIVITÉ ──────────────────────────── */
.domaine-section { margin-bottom: 2rem; }

.domaine-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.domaine-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

.domaine-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 0.5rem;
}

/* ── SUMMARY BAR ─────────────────────────────────── */
.summary-bar {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.summary-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; flex: 1; min-height: 26px; }

.summary-chip {
    background: rgba(11,45,94,0.08);
    color: var(--blue);
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.25rem 0.65rem;
    border-radius: 50px;
    display: inline-flex; align-items: center; gap: 0.3rem;
}
.summary-chip button {
    background: none; border: none; cursor: pointer;
    color: var(--muted); font-size: 0.85rem;
    padding: 0; line-height: 1;
    transition: color 0.15s;
}
.summary-chip button:hover { color: var(--rouge); }

.summary-empty { font-size: 0.82rem; color: var(--muted); font-style: italic; }

/* ── SUBMIT ──────────────────────────────────────── */
.form-footer {
    display: flex; align-items: center; justify-content: flex-end;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.btn-cancel {
    background: transparent;
    color: var(--muted);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 600;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
    cursor: pointer;
}
.btn-cancel:hover { border-color: var(--muted); color: var(--blue); }

.btn-save {
    background: var(--rouge);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 700;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    display: inline-flex; align-items: center; gap: 0.5rem;
}
.btn-save:hover { background: #a50d26; transform: translateY(-2px); }
.btn-save:disabled { background: var(--border); color: var(--muted); transform: none; cursor: not-allowed; }

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .form-body { padding: 1.5rem; }
    .form-card-header { padding: 1.25rem 1.5rem; }
    .form-footer { flex-direction: column-reverse; }
    .btn-cancel, .btn-save { width: 100%; justify-content: center; }
}
</style>
@endsection


@section('banner')
<section id="banner">
    <div class="container mx-auto px-4" style="position:relative; z-index:1;">
        <div class="banner-eyebrow">
            <span></span> Notifications personnalisées
        </div>
        <h1 class="banner-title">
            Créez votre <em>alerte</em><br>sur mesure
        </h1>
        <p class="banner-sub">
            Sélectionnez vos types de marchés et autorités contractantes. Vous serez notifié dès qu'une offre correspondante est publiée.
        </p>
    </div>
</section>
@endsection


@section('contenu')
<section class="form-section">
    <div class="container mx-auto px-4">
        <form action="{{ route('alerte.save') }}" method="post" id="alerte-form" class="form-card">
            @csrf
            <input type="hidden" name="type" value="">
            <input type="hidden" name="idAbonnement" value="">

            <!-- Card Header -->
            <div class="form-card-header">
                <div class="form-card-header-text">
                    <div class="form-card-title">Paramètres de l'alerte</div>
                    <div class="form-card-sub">Cochez vos préférences dans chaque catégorie</div>
                </div>
                <div class="header-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </div>
            </div>

            <div class="form-body">

                <!-- Summary bar -->
                <div class="summary-bar">
                    <div class="summary-chips" id="summary-chips">
                        <span class="summary-empty">Aucune sélection pour l'instant…</span>
                    </div>
                </div>

                <!-- Grid: marchés + AC -->
                <div class="form-grid">

                    <!-- Types de marchés -->
                    <div class="choice-group">
                        <div class="choice-group-label">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                            Type de marché
                        </div>
                        <div class="choice-list">
                            @foreach ($les_types_marches as $item)
                            <label class="choice-item" for="marche{{ $item->id }}" data-group="marche" data-label="{{ $item->title }}">
                                <input type="checkbox" name="type_marches[]" value="{{ $item->id }}" id="marche{{ $item->id }}">
                                <span class="choice-check"></span>
                                <span class="choice-text">{{ $item->title }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Autorités contractantes -->
                    <div class="choice-group">
                        <div class="choice-group-label">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21V11h6v10"/></svg>
                            Autorité contractante
                        </div>
                        <div class="choice-list">
                            @foreach ($les_categories as $item)
                            <label class="choice-item" for="ac{{ $item->id }}" data-group="ac" data-label="{{ $item->title }}">
                                <input type="checkbox" name="categories_ac[]" value="{{ $item->id }}" id="ac{{ $item->id }}">
                                <span class="choice-check"></span>
                                <span class="choice-text">{{ $item->title }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- Domaine d'activité -->
                @if(isset($domainesActivite) && $domainesActivite->count())
                <div class="domaine-section">
                    <div class="domaine-label">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                        Domaine d'activité
                    </div>
                    <div class="domaine-grid">
                        @foreach ($domainesActivite as $item)
                        <label class="choice-item" for="domaine{{ $item->id }}" data-group="domaine" data-label="{{ $item->title }}">
                            <input type="checkbox" name="domaine_activite[]" value="{{ $item->id }}" id="domaine{{ $item->id }}">
                            <span class="choice-check"></span>
                            <span class="choice-text">{{ $item->title }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Footer -->
                <div class="form-footer">
                    <a href="{{ route('home') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-save" id="btn-submit" disabled>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Enregistrer l'alerte
                    </button>
                </div>

            </div>
        </form>
    </div>
</section>
@endsection


@section('code')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items       = document.querySelectorAll('.choice-item');
    const chipsWrap   = document.getElementById('summary-chips');
    const btnSubmit   = document.getElementById('btn-submit');
    const selected    = {}; // { inputId: { label, group } }

    items.forEach(label => {
        label.addEventListener('click', function () {
            const input = this.querySelector('input[type="checkbox"]');
            input.checked = !input.checked;

            if (input.checked) {
                this.classList.add('selected');
                selected[input.id] = {
                    label: this.dataset.label,
                    group: this.dataset.group,
                    id: input.id
                };
            } else {
                this.classList.remove('selected');
                delete selected[input.id];
            }

            renderChips();
        });
    });

    function renderChips() {
        const keys = Object.keys(selected);
        btnSubmit.disabled = keys.length === 0;

        if (keys.length === 0) {
            chipsWrap.innerHTML = '<span class="summary-empty">Aucune sélection pour l\'instant…</span>';
            return;
        }

        chipsWrap.innerHTML = keys.map(k => `
            <span class="summary-chip">
                ${selected[k].label}
                <button type="button" onclick="removeChip('${k}')" title="Retirer">&times;</button>
            </span>
        `).join('');
    }

    window.removeChip = function (inputId) {
        const label = document.querySelector(`label[for="${inputId}"]`);
        const input = document.getElementById(inputId);
        if (input)  input.checked = false;
        if (label)  label.classList.remove('selected');
        delete selected[inputId];
        renderChips();
    };
});
</script>
@endsection