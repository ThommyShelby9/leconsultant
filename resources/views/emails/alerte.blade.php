@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Formations</title>
@endsection

@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:py-14 py-6">
        <div class="container">
            <h1 class="text-center text-white lg:text-5xl text-3xl font-bold uppercase">
               Créer une alerte
            </h1>
        </div>
    </div>
</section>
@endsection

@section('contenu')
<div class="d-flex justify-content-center align-items-center py-5" style="max-height: 100vh;">
    <div class="container">
    <form action="{{ route('alerte.save') }}" method="post" class="bg-white p-5 rounded shadow" style="max-width: 800px; margin: auto;">
    @csrf

    <div class="mb-4">
    <label for="type_marche" class="form-label">Type de marché</label>
    <select class="" name="type_marche[]" id="type_marche">
        @foreach ($marches as $marche)
            <option value="{{ $marche->id }}">{{ $marche->title }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="ac" class="form-label">Autorité Contractante</label>
    <select class="" name="ac[]" id="ac">
        @foreach ($ac as $categorie)
            <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="status" class="form-label">Statut de la demande</label>
    <select class="" name="status" id="status">
        <option value="nouveau">Nouveau</option>
        <option value="en_attente">En attente</option>
        <option value="expiré">Expiré</option>
    </select>
</div>


    <div class="text-center">
        <button type="submit" class="btn btn-primary">Créer Alerte</button>
    </div>
</form>

    </div>
</div>

<style>
    /* Assure que la liste déroulante a un style propre */
.form-select {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    background-color: #ffffff;
    font-size: 1rem;
    line-height: 1.5;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* Ajoute une ombre portée légère pour un effet de profondeur */
.form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
}

/* Style les options */
.form-select option {
    padding: 0.375rem 0.75rem;
}

/* Ajuste la hauteur du select pour montrer une seule option visible */
.form-select {
    max-height: 200px; /* Ajustez cette valeur pour montrer plus ou moins d'options visibles */
    overflow-y: auto;
}

</style>
@endsection

@section('code')
    <script src="https://cdn.kkiapay.me/k.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    @if(session('success'))
        <script type="text/javascript">
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000, // Durée de la notification
                close: true, // Affiche le bouton de fermeture
                gravity: "top", // Notification affichée en haut
                position: "right", // Position sur la droite
                backgroundColor: "#4CAF50", // Couleur de fond
                stopOnFocus: true, // Arrêter le timer lorsqu'on clique sur la notification
            }).showToast();
        </script>
    @endif
@endsection
