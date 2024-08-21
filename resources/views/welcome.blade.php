@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Accueil</title>
@endsection

@section('banner')
@if($user)
@if(!$hasActiveSubscription)
<script src="https://cdn.kkiapay.me/k.js"></script>

<!-- Inclure le script SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Abonnement requis',
            text: "Veuillez souscrire à l'abonnement unique de 2999 FCFA afin de pouvoir accéder à la plateforme.",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Souscrire',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            backdrop: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Ouvrir le widget Kkiapay pour le paiement
                KkiapayWidget.init({
                    amount: 2999, // Montant à payer en FCFA
                    key: "2a9363b7c6c78cf76717f8895a561990f39bac73", // Votre clé publique Kkiapay
                    sandbox: true, // Utilisez false en production
                    callback: "https://votre-site.com/kkiapay-callback", // URL de callback
                    onSuccess: function(response) {
                        if (response.status === 'SUCCESS') {
                            Swal.fire({
                                title: 'Paiement réussi',
                                text: "Votre abonnement a été activé avec succès.",
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload(); // Rechargez la page pour mettre à jour l'état
                            });
                        } else {
                            Swal.fire({
                                title: 'Erreur',
                                text: "Une erreur est survenue lors du paiement. Veuillez réessayer.",
                                icon: 'error',
                                confirmButtonText: 'Réessayer'
                            });
                        }
                    },
                    onError: function(error) {
                        Swal.fire({
                            title: 'Erreur',
                            text: "Une erreur est survenue lors du paiement. Veuillez réessayer.",
                            icon: 'error',
                            confirmButtonText: 'Réessayer'
                        });
                    }
                });

                // Ouvrir le widget Kkiapay
                KkiapayWidget.requestPayment();
            }
        });
    });
</script>
@endif
@endif


<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:pt-32 lg:pb-48 pt-10">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="lg:w-2/3 w-full">
                    <h1 class="text-white lg:text-6xl text-4xl font-bold mb-4">
                        Explorer les Appels d'offres disponibles au
                    </h1>
                    <h1 class="text-consultant-rouge lg:text-6xl text-4xl font-bold mb-6">
                        Bénin
                    </h1>
                    <p class="text-white text-justify mb-2">
                        Découvrez les opportunités d’affaires au Bénin à travers notre plateforme dédiée aux appels d’offres publics et privés. Que vous soyez une petite ou grande entreprise, nous vous aidons à identifier les projets les plus pertinents pour développer vos activités et accroître votre chiffre d’affaires. Ne manquez plus aucune opportunité grâce à notre système d’alerte personnalisée. </p>
                    <p class="text-white text-justify">
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-consultant-rouge lg:pt-12 lg:pb-12 py-6">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="lg:w-2/3 w-full">
                    <form action="{{ route('offre.recherche') }}" method="post" class="flex m-0">
                        @csrf
                        <!--input type="hidden" name="page" value="welcome" -->

                        <div class="flex flex-wrap justify-center lg:w-2/3 w-full">
                            <div class="w-1/2 pr-1 mb-4">
                                <select class="form-select c-select" name="categ" aria-label="Default select example">
                                    <option selected class="" value="0">Toutes les Catégories d'A.C</option>
                                    @foreach ($les_categories as $item)
                                    <option value="{{$item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-1/2 pl-1 mb-4">
                                <select name="type" class="form-select c-select" aria-label="Default select example">
                                    <option value="0" selected>Tous les Types d'offre</option>
                                    @foreach ($les_types_marches as $item)
                                    <option value="{{$item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-1/3 pr-1 mb-4">
                                <select class="form-select c-select" name="statut" aria-label="Default select example">
                                    <option selected class="" value="0">Tous les Statuts</option>
                                    <option value="en_cours">En cours</option>
                                    <option value="expire">Expiré</option>
                                </select>
                            </div>
                            <div class="flex items-center mb-8 lg:mb-0">
                                <div class="relative w-full">
                                    <input type="search" name="search" placeholder="Que cherchez-vous ?" id="validate" class="w-full px-3 py-6 bg-white bg-opacity-75 rounded-lg outline-none focus:outline-2 focus:outline-offset-0 focus:outline-consultant-rouge">
                                    <button type="submit" class="absolute right-0 top-0 bottom-0 bg-white px-6 rounded-lg">
                                        <i class="fi-xnsuh2-search text-consultant-rouge"></i>
                                    </button>
                                </div>
                                <a href="{{route('alerte')}}" class="ml-4 px-6 py-3 alerte_text-white rounded-lg hover:bg-consultant-rouge-dark alerte-bg">
                                <button type="button" class=" ">
                                    Créer une alerte
                                </button>
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div data-aos="fade-left" class="absolute lg:right-[-30%] xl:right-[0%] xl:top-0 lg:bottom-0 lg:block hidden">
        <img src="{{asset('assets/img/Photo%201.png')}}" alt="" class="xl:w-full lg:w-3/5">
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
            <div class="w-1/5 lg:mb-16 mb-6" data-aos="fade-up"
                data-aos-anchor-placement="top-bottom">
                @if( $item->logo !=null and file_exists($item->logo))
                <img src="{{ asset($item->logo)}}" alt=""
                    class="w-full rounded-lg">
                @else
                <img src="{{asset('default_offres.jpg')}}" alt=""
                    class="w-full rounded-lg">
                @endif
            </div>

            <div class="w-4/5 lg:mb-16 mb-6" data-aos="fade-up"
                data-aos-anchor-placement="top-bottom">
                <div class="px-5">
                    <a class="text-black lg:text-3xl text-xl text-justify mb-4 inline-block w-full">
                        <h3>
                            {{$item->titre}}
                        </h3>
                    </a>
                    <h3 class="text-consultant-blue lg:text-3xl text-xl inline-block font-medium">
                        {{ $item->autName }}
                    </h3>
                    <hr class="bg-consultant-blue h-[2px] mt-3 mb-1 lg:block hidden">
                    <div class="flex flex-wrap lg:flex-row flex-col">
                        <div class="lg:w-3/4 w-full">
                            <div class="text-consultant-gris font-medium flex flex-wrap">
                                <h4 class="mr-12"><span class="text-black">Catégorie</span> : {{$item->categTitle }}</h4>
                                <h4 class="mr-12"><span class="text-black">Type d'offre</span> : {{$item->typeTitle }}</h4>
                                <h4 class="mr-12"><span class="text-black">Publiée le </span> : {{ date('d M Y', strtotime($item->datePublication))  }} </h4>
                                <h4 class="mr-12"><span class="text-black">Expire le </span> : {{ date('d M Y', strtotime($item->dateExpiration))  }} </h4>
                                <h4 class="mr-12 w-full"><span class="text-black">Lieu de dépot </span> : {{ $item->lieu_depot }} </h4>
                            </div>
                        </div>

                        <?php $file = str_replace(("upload_files/"), '', $item->fichier);  ?>

                        <div class="lg:w-1/4 w-full mt-8" data-aos="zoom-in-up">
                            <a href="{{ route('voirFichier',$file)  }}">
                                <button
                                    class="inline-block lg:mt-0 mt-10 py-4 bg-consultant-blue text-white  rounded-lg w-full">
                                    Télécharger
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="flex flex-wrap justify-center items-center mb-12">
            <a href="{{ Route('offre') }}">
                <h3 class="text-center px-4 py-3 border border-consultant-blue text-consultant-blue font-medium lg:text-2xl text-lg mr-2">
                    Voir toutes les offres </h3>

            </a>
        </div>
    </div>
</section>


<section id="news" class="relative mb-8">
    <div class="container">
        <h2 data-aos="zoom-out" class="lg:text-5xl text-3xl text-consultant-rouge font-bold mb-16 text-center">
            Actualités
        </h2>
        <div class="bg-[#F5FAFE] shadow-lg p-8 -m-8">
            <h3 class="lg:text-2xl text-lg font-medium mb-3">
                Ministère de l'économie et des finances
            </h3>
            <div class="flex flex-wrap">
                <div class="lg:w-3/5 w-full lg:pr-4 pr-0 lg:my-0 my-4">
                    <p class="text-justify lg:text-lg text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur. Excepteur
                        sint occaecat
                    </p>
                    <p class="text-justify lg:text-lg text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur. Excepteur
                        sint occaecat
                    </p>
                    <p class="text-justify lg:text-lg text-sm mb-10">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur. Excepteur
                        sint occaecat
                    </p>
                    <button
                        class="inline-block lg:text-2xl text-lg float-right text-white font-semibold bg-consultant-blue rounded-lg px-16 py-3">
                        Voir plus
                    </button>
                </div>
                <div class="lg:w-2/5 w-full lg:px-4 px-0 lg:my-0 my-4">
                    <img src="assets/img/0720349001625050856%201.png" class="w-full object-center object-cover"
                        alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .ml-4 {
    margin-left: 1rem; /* 16px, équivalent à 4 unités Bootstrap */
}

.px-6 {
    padding-left: 1.5rem; /* 24px, équivalent à 6 unités Bootstrap */
    padding-right: 1.5rem; /* 24px, équivalent à 6 unités Bootstrap */
}

.py-3 {
    padding-top: 0.75rem; /* 12px, équivalent à 3 unités Bootstrap */
    padding-bottom: 0.75rem; /* 12px, équivalent à 3 unités Bootstrap */
}



.alerte_text-white {
    color: black; /* Couleur du texte blanche */
}

.rounded-lg {
    border-radius: 0.5rem; /* 8px, équivalent à 'lg' dans Bootstrap */
}

.hover\:bg-consultant-rouge-dark:hover {
    background-color: whitesmoke; /* Couleur rouge foncée pour l'état de survol, ajustez la valeur hexadécimale selon vos besoins */
}

.alerte-bg{
    background-color: white;
}

</style>

@endsection

@section('code')
<script src="https://cdn.kkiapay.me/k.js"></script>
@endsection