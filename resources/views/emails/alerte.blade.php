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

            <div class="form-group mb-4">
                <label for="type_marche" class="form-label">Type de marché</label>
                <select class="form-control" name="type_marche[]" id="type_marche" multiple>
                    @foreach ($marches as $marche)
                    <option value="{{ $marche->id }}">{{ $marche->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="ac" class="form-label">Autorité Contractante</label>
                <select class="form-control" name="ac[]" id="ac" multiple>
                    @foreach ($ac as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Créer Alerte</button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-group {
        margin-bottom: 1.5rem;
        /* Spacing between form groups */
    }

    .form-label {
        font-weight: 600;
        /* Makes the label text bold */
        margin-bottom: 0.5rem;
        /* Spacing below the label */
        display: block;
        /* Ensures label is above the input/select */
        color: #333;
        /* Dark gray color for the label */
    }

    .form-control {
        width: 100%;
        /* Make the select box take full width */
        padding: 0.5rem 1rem;
        /* Add padding inside the select box */
        font-size: 1rem;
        /* Set a consistent font size */
        line-height: 1.5;
        /* Adjust the line height */
        border-radius: 0.25rem;
        /* Slightly rounded corners */
        border: 1px solid #ced4da;
        /* Light gray border */
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        /* Inner shadow for a subtle 3D effect */
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        /* Smooth transition for focus state */
    }

    .form-control:focus {
        border-color: #80bdff;
        /* Blue border on focus */
        outline: 0;
        /* Remove the default focus outline */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        /* Blue glow on focus */
    }

    select[multiple] {
        height: auto;
        /* Adjust height automatically based on content */
    }

    .bg-white {
        background-color: #fff;
        /* Ensures background is white */
    }

    .p-5 {
        padding: 3rem;
        /* Large padding inside the form */
    }

    .rounded {
        border-radius: 0.25rem;
        /* Slightly rounded corners */
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        /* Light shadow for depth */
    }

    .text-center {
    text-align: center; /* Centers the content horizontally */
}

.btn {
    display: inline-block; /* Allows setting width and margin */
    font-weight: 400; /* Normal font weight */
    color: #fff; /* White text color */
    text-align: center; /* Centers text inside the button */
    vertical-align: middle; /* Aligns text vertically */
    user-select: none; /* Prevents text selection */
    background-color: transparent; /* Default background color */
    border: 1px solid transparent; /* Default border */
    padding: 0.375rem 0.75rem; /* Padding inside the button */
    font-size: 1rem; /* Font size */
    line-height: 1.5; /* Line height */
    border-radius: 0.25rem; /* Slightly rounded corners */
    transition: all 0.15s ease-in-out; /* Smooth transition for hover and focus states */
}

.btn-primary {
    color: #fff; /* White text color */
    background-color: #007bff; /* Primary color */
    border-color: #007bff; /* Primary color border */
}

.btn-primary:hover {
    color: #fff; /* White text color on hover */
    background-color: #0056b3; /* Darker shade of primary color on hover */
    border-color: #004085; /* Darker shade of primary color border on hover */
}

.btn-primary:focus, .btn-primary.focus {
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5); /* Shadow on focus */
}

.btn-primary:active, .btn-primary.active, .show > .btn-primary.dropdown-toggle {
    color: #fff; /* White text color when active */
    background-color: #0056b3; /* Darker shade of primary color when active */
    border-color: #004085; /* Darker shade of primary color border when active */
}

.btn-primary:disabled, .btn-primary[disabled] {
    opacity: 0.65; /* Reduced opacity for disabled state */
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