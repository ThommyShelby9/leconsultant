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
                        Découvrez toutes les opportunités disponibles sur notre plateforme. Que vous soyez une entreprise en quête de nouveaux marchés ou un entrepreneur à la recherche de projets à développer, nous mettons à votre disposition une sélection d'appels d'offres publics et privés. Explorez dès maintenant les différentes offres et trouvez celles qui correspondent à vos besoins et ambitions. Restez à l'affût des meilleures occasions pour faire croître votre activité.
                    </p>


                    <!-- Formulaire de recherche -->
                    <form action="{{ route('offre.recherche') }}" method="post" class="flex flex-wrap justify-center lg:w-2/3 w-full">
                        @csrf
                        <!-- Sélecteur des Autorités Contractantes -->
                        <div class="w-full lg:w-1/3 px-1 mb-4">
                            <select name="categ" class="w-full bg-white bg-opacity-75 border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-consultant-rouge focus:border-transparent">
                                <option selected value="0">Toutes les Autorités Contractantes</option>
                                @foreach ($ac as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Sélecteur des Domaines d'Activité (Types) -->
                        <div class="w-full lg:w-1/3 px-1 mb-4">
                            <select name="type" class="w-full bg-white bg-opacity-75 border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-consultant-rouge focus:border-transparent">
                                <option value="0" selected>Tous les Domaines d'Activités</option>
                                @foreach ($types as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Zone de recherche -->
                        <div class="w-full relative mb-4">
                            <input type="search" name="search" placeholder="Que cherchez-vous ?" class="w-full px-4 py-2 bg-white bg-opacity-75 rounded-lg border border-gray-300 focus:ring-2 focus:ring-consultant-rouge" />
                            <button type="submit" class="absolute right-0 top-0 bottom-0 bg-consultant-blue text-white py-2 px-6 rounded-lg " style="background-color: red;">
                                Rechercher
                            </button>
                        </div>
                        <!-- Lien créer une alerte -->
                        <div class="w-full text-center">
                            <a href="{{ route('alerte') }}" class="bg-red-600 hover:bg-red-700 focus:bg-red-700 text-white py-2 px-4 rounded-lg" style="background-color: red;">
                                Créer une alerte
                            </a>
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12"> <!-- Augmenter l'espace entre les colonnes -->

            @foreach ($offres as $item)
            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col lg:flex-row"> <!-- Flex pour responsive -->
                
                <!-- Logo centré -->
                <div class="w-full lg:w-1/5 flex items-center justify-center mb-4 lg:mb-0"> <!-- Alignement du logo -->
                    <img src="{{ $item->logo ? asset($item->logo) : asset('default_offres.jpg') }}" alt="logo" class="w-24 lg:w-32 rounded-lg"> <!-- Taille du logo -->
                </div>

                <!-- Contenu de l'offre -->
                <div class="w-full lg:w-4/5 lg:pl-6">
                    <!-- Titre de l'offre -->
                    <a href="#" class="text-xl lg:text-3xl font-bold text-black mb-2 block">
                        {{ $item->titre }}
                    </a>
                    
                    <!-- Nom de l'autorité -->
                    <p class="text-consultant-blue text-xl font-medium mb-2">
                        {{ $item->autName }}
                    </p>

                    <hr class="my-2"> <!-- Ligne de séparation -->

                    <!-- Détails de l'offre -->
                    <div class="text-gray-600 text-sm space-y-1"> <!-- Informations supplémentaires -->
                        <p><strong>Catégorie:</strong> {{ $item->categTitle }}</p>
                        <p><strong>Type:</strong> {{ $item->typeTitle }}</p>
                        <p><strong>Publiée le:</strong> {{ date('d M Y', strtotime($item->datePublication)) }}</p>
                        <p><strong>Expire le:</strong> {{ date('d M Y', strtotime($item->dateExpiration)) }}</p>
                    </div>

                    <!-- Bouton Télécharger le fichier -->
                    <a href="{{ route('voirFichier', basename($item->fichier)) }}" class="mt-4 bg-consultant-blue text-white py-2 px-4 rounded-lg block text-center">
                        Télécharger
                    </a>
                </div>
            </div>
            @endforeach

        </div>

        <!-- Ajouter la pagination -->
        <div class="mt-8">
            {{ $offres->links() }} <!-- Pagination avec liens -->
        </div>

    </div>
</section>



@endsection