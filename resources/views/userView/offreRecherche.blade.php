@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue pt-10 lg:pt-32 pb-20 lg:pb-48">
        <div class="container mx-auto">
            <div class="flex flex-wrap">
                <!-- Texte principal -->
                <div class="lg:w-2/3 w-full">
                    <h1 class="text-white font-bold text-4xl lg:text-6xl mb-8">
                        Toutes les offres publiées
                    </h1>
                    <p class="text-white text-justify mb-8 lg:w-4/5">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut imperdiet ultrices elit suscipit dignissim massa. Purus viverra laoreet scelerisque morbi euismod eget. Nunc id tortor dui velit dignissim faucibus feugiat. Pharetra turpis condimentum ut nulla.
                    </p>
                    
                    <!-- Formulaire de recherche -->
                    <form action="{{ route('offre.recherche') }}" method="post" class="flex flex-wrap lg:w-2/3 w-full">
                        @csrf
                        
                        <!-- Catégorie -->
                        <div class="w-full lg:w-1/3 px-1 mb-4">
                            <select name="categ" class="w-full bg-white bg-opacity-75 border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-consultant-rouge focus:border-transparent">
                                <option value="0" selected>Catégories d'A.C</option>
                                @foreach ($les_categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type d'offre -->
                        <div class="w-full lg:w-1/3 px-1 mb-4">
                            <select name="type" class="w-full bg-white bg-opacity-75 border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-consultant-rouge focus:border-transparent">
                                <option value="0" selected>Types d'offre</option>
                                @foreach ($les_types_marches as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Statut -->
                        <div class="w-full lg:w-1/3 px-1 mb-4">
                            <select name="statut" class="w-full bg-white bg-opacity-75 border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-consultant-rouge focus:border-transparent">
                                <option value="0" selected>Tous les Statuts</option>
                                <option value="en_cours">En cours</option>
                                <option value="expire">Expiré</option>
                            </select>
                        </div>

                        <!-- Champ de recherche -->
                        <div class="w-full relative mb-8">
                            <input type="search" name="search" placeholder="Que cherchez-vous ?" class="w-full px-4 py-4 bg-white bg-opacity-75 rounded-lg outline-none focus:ring-2 focus:ring-consultant-rouge" />
                            <button type="submit" class="absolute right-0 top-0 bottom-0 bg-white px-6 rounded-lg">
                                <i class="fi-xnsuh2-search text-consultant-rouge"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@section('contenu')
<section id="offres" class="py-16">
    <div class="container mx-auto">
        <h2 class="text-consultant-rouge text-3xl lg:text-5xl font-bold mb-8">
            Les dernières offres publiées
        </h2>
        
        <!-- Grid layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12"> <!-- Augmenté de gap-8 à gap-12 pour plus d'espace -->
            @foreach ($offres as $item)
            <div class="bg-white shadow-lg rounded-lg p-8 flex space-x-6"> <!-- Ajouté padding plus large et espacement entre logo et contenu -->
                <!-- Logo centré -->
                <div class="w-1/5 flex items-center justify-center">
                    <img src="{{ $item->logo ? asset($item->logo) : asset('default_offres.jpg') }}" alt="logo" class="w-full rounded-lg">
                </div>
                
                <!-- Contenu de l'offre -->
                <div class="w-4/5">
                    <a href="#" class="text-xl lg:text-3xl font-bold text-black mb-2 block">
                        {{ $item->titre }}
                    </a>
                    <p class="text-consultant-blue text-xl font-medium mb-2">
                        {{ $item->autName }}
                    </p>
                    <hr class="my-4"> <!-- Augmenté l'espace vertical entre les sections -->
                    
                    <!-- Détails de l'offre -->
                    <div class="text-gray-600 text-sm space-y-2"> <!-- Plus d'espace entre les lignes de texte -->
                        <p><strong>Catégorie:</strong> {{ $item->categTitle }}</p>
                        <p><strong>Type:</strong> {{ $item->typeTitle }}</p>
                        <p><strong>Publiée le:</strong> {{ date('d M Y', strtotime($item->datePublication)) }}</p>
                        <p><strong>Expire le:</strong> {{ date('d M Y', strtotime($item->dateExpiration)) }}</p>
                    </div>
                    
                    <!-- Bouton Télécharger -->
                    <a href="{{ route('voirFichier', $file ?? '' ) }}" class="mt-6 bg-consultant-blue text-white py-3 px-5 rounded-lg block text-center">
                        Télécharger
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
