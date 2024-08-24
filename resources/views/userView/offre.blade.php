@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')

<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:pt-32 lg:pb-48 pt-10">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="lg:w-2/3 w-full">
                    <h1 class="text-white lg:text-6xl text-4xl font-bold mb-8">
                        Toutes les offres publiées
                    </h1>
                    <p class="text-white text-justify mb-8 lg:w-4/5 w-full">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut imperdiet ultrices elit suscipit dignissim massa. Purus viverra laoreet scelerisque morbi euismod eget. Nunc id tortor dui velit dignissim faucibus feugiat. Pharetra turpis condimentum ut nul,
                    </p>
                    <form action="{{ route('offre.recherche') }}" method="post" class="flex m-0">
                        @csrf

                        <div class="flex flex-wrap justify-center lg:w-2/3 w-full">
                            <!-- Categorie -->
                            <div class="w-1/3 pr-1 mb-4">
                                <select class="form-select c-select" name="categ" aria-label="Default select example">
                                    <option selected class="" value="0">Catégories d'A.C</option>
                                    @foreach ($les_categories as $item)
                                    <option value="{{$item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type d'offre -->
                            <div class="w-1/3 pl-1 mb-4">
                                <select name="type" class="form-select c-select" aria-label="Default select example">
                                    <option value="0" selected>Types d'offre</option>
                                    @foreach ($les_types_marches as $item)
                                    <option value="{{$item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Autorité contractante -->


                            <!-- Statut de la demande -->
                            <div class="w-1/3 pr-1 mb-4">
                                <select class="form-select c-select" name="statut" aria-label="Default select example">
                                    <option selected class="" value="0">Tous les Statuts</option>
                                    <option value="en_cours">En cours</option>
                                    <option value="expire">Expiré</option>
                                </select>
                            </div>

                            <!-- Recherche -->
                            <div class="w-full relative mb-8 lg:mb-0">
                                <input type="search" name="search" placeholder="Que cherchez-vous ?" id="validate" class="w-full px-3 py-6 bg-white bg-opacity-75 rounded-lg outline-none focus:outline-2 outline-none focus:outline-offset-0 focus:outline-consultant-rouge">
                                <button type="submit" class="absolute right-0 top-0 bottom-0 bg-white px-6 rounded-lg">
                                    <i class="fi-xnsuh2-search text-consultant-rouge"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('contenu')

<section id="offres" class="relative">
    <div class="container">
        <h2 class="text-consultant-rouge lg:text-5xl text-3xl font-bold mb-8">
            Les dernières offres publiées
        </h2>

        <div class="flex flex-wrap lg:flex-row flex-col items-center mb-6">
            @foreach ($offres as $item)
            <div class="w-1/5 lg:mb-16 mb-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                @if (file_exists($item->logo))
                <img src="{{ asset($item->logo) }}" alt="" class="w-full rounded-lg">
                @else
                <img src="{{ asset('default_offres.jpg') }}" alt="" class="w-full rounded-lg">
                @endif
            </div>
            <div class="w-4/5 lg:mb-16 mb-6" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="px-5">
                    <a class="text-black lg:text-3xl text-xl text-justify mb-4 inline-block w-full">
                        <h3>{{ $item->titre }}</h3>
                    </a>
                    <h3 class="text-consultant-blue lg:text-3xl text-xl inline-block font-medium">
                        {{ $item->autName }}
                    </h3>
                    <hr class="bg-consultant-blue h-[2px] mt-3 mb-1 lg:block hidden">
                    <div class="flex flex-wrap lg:flex-row flex-col">
                        <div class="lg:w-3/4 w-full">
                            <div class="text-consultant-gris font-medium flex flex-wrap">
                                <h4 class="mr-12"><span class="text-black">Catégorie</span> : {{ $item->categTitle }}</h4>
                                <h4 class="mr-12"><span class="text-black">Type d'offre</span> : {{ $item->typeTitle }}</h4>
                                <h4 class="mr-12"><span class="text-black">Publiée le </span> : {{ date('d M Y', strtotime($item->datePublication)) }}</h4>
                                <h4 class="mr-12"><span class="text-black">Expire le </span> : {{ date('d M Y', strtotime($item->dateExpiration)) }}</h4>
                                <h4 class="mr-12 w-full"><span class="text-black">Lieu de dépôt </span> : {{ $item->lieu_depot }}</h4>
                            </div>
                        </div>
                        <div class="lg:w-1/4 w-full mt-8" data-aos="zoom-in-up">
                            <?php $file = str_replace("upload_files/", '', $item->fichier); ?>
                            <a href="{{ route('voirFichier', $file) }}">
                                <button class="inline-block lg:mt-0 mt-10 py-4 bg-consultant-blue text-white rounded-lg w-full">
                                    Télécharger
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-end my-4">
            {{ $offres->links('layout.pagination')}}

        </div>
    </div>

</section>

@endsection