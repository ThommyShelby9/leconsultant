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
<div class="py-8">
    <div class="container mx-auto">
        <form action="{{ route('alerte.save') }}" method="post" class="bg-white shadow-md rounded-lg p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type de marché -->
                <div class="mb-4">
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
                <div class="mb-4">
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
            <div class="text-center mt-6">
                <button type="submit" class="bg-red-500 text-white py-3 px-6 rounded-lg hover:bg-red-600 transition duration-300">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('code')
    {{-- Pas de script nécessaire --}}
@endsection
