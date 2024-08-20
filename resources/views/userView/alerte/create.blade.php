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
<div class="py-4">
    <div class="container">
        <form action="{{ route('alerte.save') }}" method="post">
            @csrf

            <div class="row">
                <!-- Type de marché -->
                <div class="col-lg-6 mb-4">
                    <div class="bg-primary text-center text-white py-3 rounded mb-4 shadow-sm">
                        <h2 class="h5">Type de marché qui vous intéresse</h2>
                    </div>
                    @foreach ($les_types_marches as $item)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="type_marches[]" value="{{ $item->id }}" id="marche{{ $item->id }}">
                        <label class="form-check-label" for="marche{{ $item->id }}">
                            {{ $item->title }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Type d'autorité contractante (AC) -->
                <div class="col-lg-6 mb-4">
                    <div class="bg-primary text-center text-white py-3 rounded mb-4 shadow-sm">
                        <h2 class="h5">Type de AC qui vous intéresse</h2>
                    </div>
                    @foreach ($les_categories as $item)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="categories_ac[]" value="{{ $item->id }}" id="ac{{ $item->id }}">
                        <label class="form-check-label" for="ac{{ $item->id }}">
                            {{ $item->title }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" name="type" value="">
            <input type="hidden" name="idAbonnement" value="">

            <!-- Submit button -->
            <div class="text-center">
                <button type="submit" class="btn btn-danger btn-lg">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


@section('code')
    <script src="https://cdn.kkiapay.me/k.js"></script>
@endsection