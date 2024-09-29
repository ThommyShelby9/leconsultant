@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Accueil</title>
@endsection

@section('banner')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
@if($user)
@if(!$hasActiveSubscription)

<!-- Inclure le script Kkiapay -->
<!-- Inclure le script SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Fonction pour charger le script Kkiapay
function loadKkiapayScript() {
    return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = "https://cdn.kkiapay.me/k.js";
        script.onload = resolve;
        script.onerror = reject;
        document.body.appendChild(script);
    });
}

// Fonction principale
async function initializePayment() {
    try {
        await loadKkiapayScript();
        
        // Attendre que Kkiapay soit défini
        let attempts = 0;
        while (typeof Kkiapay === 'undefined' && attempts < 10) {
            await new Promise(resolve => setTimeout(resolve, 500));
            attempts++;
        }

        if (typeof Kkiapay === 'undefined') {
            throw new Error("Le SDK Kkiapay n'a pas pu être chargé après plusieurs tentatives");
        }

        // Le reste de votre code ici
        Swal.fire({
            title: 'Abonnement requis',
            text: "Veuillez souscrire à l'abonnement unique de 1490 FCFA afin de pouvoir accéder à la plateforme.",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Souscrire',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            backdrop: true
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Bouton Souscrire cliqué');
                // Configuration du widget Kkiapay
                Kkiapay.init({
                    key: "2a9363b7c6c78cf76717f8895a561990f39bac73",
                    sandbox: true
                });

                // Ouvrir le widget Kkiapay
                Kkiapay.open({
                    amount: 1490,
                    callback: "https://votre-site.com/kkiapay-callback",
                    data: "Abonnement unique",
                    theme: "blue",
                    name: "Paiement de l'abonnement",
                    description: "Abonnement unique pour accéder à la plateforme",
                    reason: "Abonnement unique",
                    currency: "XOF",
                    countries: ["BJ"],
                    paymentMethods: ["card", "mobile-money", "direct-debit"],
                    key: "2a9363b7c6c78cf76717f8895a561990f39bac73"
                }, 
                function(response) {
                    console.log('Réponse de Kkiapay:', response);
                    if (response.status === 'SUCCESSFUL') {
                        Swal.fire({
                            title: 'Paiement réussi',
                            text: "Votre abonnement a été activé avec succès.",
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
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
                function(error) {
                    console.error('Erreur Kkiapay:', error);
                    Swal.fire({
                        title: 'Erreur',
                        text: "Une erreur est survenue lors du paiement. Veuillez réessayer.",
                        icon: 'error',
                        confirmButtonText: 'Réessayer'
                    });
                });
            }
        });
    } catch (error) {
        console.error("Erreur lors de l'initialisation du paiement:", error);
        Swal.fire({
            title: 'Erreur',
            text: "Une erreur est survenue lors de l'initialisation du paiement. Veuillez réessayer plus tard.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

// Exécuter la fonction principale lorsque le DOM est chargé
document.addEventListener('DOMContentLoaded', initializePayment);
</script>

@endif
@endif


<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:pt-32 lg:pb-48 pt-6 pb-6">
        <div class="container mx-auto px-0 lg:px-0">
            <div class="flex flex-wrap">
                <div class="lg:w-2/3 w-full">
                    <h1 class="text-white lg:text-6xl text-3xl font-bold mb-1 lg:mb-4 w-full">
                        Explorer les Appels d'offres disponibles au
                    </h1>
                    <h1 class="text-consultant-rouge lg:text-6xl text-3xl font-bold mb-2 lg:mb-6 w-full">
                        Bénin
                    </h1>
                    <p class="text-white text-justify mb-1 lg:mb-2 w-full">
                        Découvrez les opportunités d’affaires au Bénin à travers notre plateforme dédiée aux appels d’offres publics et privés. Que vous soyez une petite ou grande entreprise, nous vous aidons à identifier les projets les plus pertinents pour développer vos activités et accroître votre chiffre d’affaires. Ne manquez plus aucune opportunité grâce à notre système d’alerte personnalisée.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-consultant-rouge lg:pt-12 lg:pb-12 py-6">
        <div class="container mx-auto px-0 lg:px-0">
            <div class="flex flex-wrap">
                <div class="lg:w-2/3 w-full">
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
                            <button type="submit" class="absolute right-0 top-0 bottom-0 bg-consultant-blue text-white py-2 px-6 rounded-lg">
                                Rechercher
                            </button>
                        </div>
                        <!-- Lien créer une alerte -->
                        <div class="w-full text-center">
                            <a href="{{ route('alerte') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg">Créer une alerte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div data-aos="fade-left" class="absolute lg:right-[-30%] xl:right-[0%] xl:top-0 lg:bottom-0 lg:block hidden">
        <img src="{{ asset('assets/img/Photo%201.png') }}" alt="" class="xl:w-full lg:w-3/5">
    </div>
</section>


@endsection


@section('contenu')
<section id="offres" class="py-16">
    <div class="container mx-auto">
        <h2 class="text-consultant-rouge text-3xl lg:text-5xl font-bold mb-8">Les dernières offres publiées</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach ($offres as $item)
            <div class="bg-white shadow-lg rounded-lg p-6 flex">
                <div class="w-1/5 flex items-center justify-center">
                    <!-- Image centrée -->
                    <img src="{{ $item->logo ? asset($item->logo) : asset('default_offres.jpg') }}" alt="logo" class="w-full rounded-lg">
                </div>
                <div class="w-4/5 pl-6">
                    <a href="#" class="text-xl lg:text-3xl font-bold text-black">{{ $item->titre }}</a>
                    <p class="text-consultant-blue text-xl font-medium">{{ $item->autName }}</p>
                    <hr class="my-2">
                    <div class="text-gray-600 text-sm space-y-1">
                        <p>Catégorie: {{ $item->categTitle }}</p>
                        <p>Type: {{ $item->typeTitle }}</p>
                        <p>Publiée le: {{ date('d M Y', strtotime($item->datePublication)) }}</p>
                        <p>Expire le: {{ date('d M Y', strtotime($item->dateExpiration)) }}</p>
                    </div>
                    <a href="{{ route('voirFichier', $file ?? '' ) }}" class="mt-4 bg-consultant-blue text-white py-2 px-4 rounded-lg block text-center">Télécharger</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Section des actualités -->
<section id="news" class="relative mb-8">
    <div class="container">
        <h2 data-aos="zoom-out" class="lg:text-5xl text-3xl text-consultant-rouge font-bold mb-16 text-center">
            Actualités
        </h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @if (!empty($news))
                @foreach ($news as $article)
                <div class="swiper-slide">
                    <div class="bg-[#F5FAFE] shadow-lg p-8 rounded-lg w-full">
                        <div class="w-full">
                            <!-- Titre de l'article centré -->
                            <h4 class="text-xl font-semibold text-center mb-4">{{ $article->title }}</h4>
                            <!-- Description justifiée -->
                            <p class="text-justify text-lg mb-4">{{ $article->snippet }}</p>
                            <!-- Lien vers l'article complet centré -->
                            <div class="text-center mb-4">
                                <a href="{{ $article->link }}" target="_blank" class="text-consultant-blue underline">Lire l'article complet</a>
                            </div>
                            <!-- Image centrée -->
                            @if (isset($article->thumbnail))
                            <div class="w-full flex justify-center">
                                <img src="{{ $article->thumbnail }}" class="lg:w-1/3 w-full object-cover mt-4" alt="Image d'actualité">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="swiper-slide">
                    <p class="text-justify lg:text-lg text-sm">Aucune actualité disponible pour le moment.</p>
                </div>
                @endif
            </div>

            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<style>
    /* Styles de la section des actualités */
    .swiper-container {
        overflow: hidden;
    }

    /* Style des slides pour être bien centrés */
    .swiper-slide {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
    }

    /* Style du conteneur des actualités */
    .bg-[#F5FAFE] {
        background-color: #F5FAFE;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    /* Style pour le titre centré */
    .bg-[#F5FAFE] h4 {
        margin-bottom: 10px;
        font-size: 1.25rem;
        font-weight: bold;
        text-align: center;
    }

    /* Style pour le texte justifié */
    .bg-[#F5FAFE] p {
        text-align: justify;
        margin-bottom: 10px;
        font-size: 1rem;
    }

    /* Style du lien vers l'article centré */
    .bg-[#F5FAFE] a {
        color: #1e40af;
        text-decoration: underline;
        font-size: 1rem;
    }

    /* Image centrée */
    /* Image centrée */
    .bg-[#F5FAFE] img {
        width: 100%;
        max-width: 300px;
        /* Augmentez la taille max de l'image */
        height: auto;
        object-fit: cover;
        margin-top: 20px;
    }


    /* Pagination et navigation de swiper */
    .swiper-pagination,
    .swiper-button-next,
    .swiper-button-prev {
        color: #007bff;
    }

    /* Superposition sur l'image (optionnel) */
    .bg-[#F5FAFE]::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.3);
        z-index: 2;
    }

    .swiper-slide img {
        width: 100%;
        max-width: 300px;
        height: auto;
        object-fit: cover;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .w-1/5 {
            margin-right: 0.5rem;
        }

        .w-4/5 {
            margin-left: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        #offres {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    }

    #offres {
        margin-top: 2rem;
        /* au lieu de 8rem */
        margin-bottom: 2rem;
        /* au lieu de 8rem */
    }

    @media (max-width: 768px) {
        .mb-6 {
            margin-bottom: 1rem;
        }

        .mb-16 {
            margin-bottom: 2rem;
        }
    }

    .mb-6 {
        margin-bottom: 2rem;
        /* au lieu de 6rem */
    }

    .mb-16 {
        margin-bottom: 4rem;
        /* au lieu de 16rem */
    }
</style>


@endsection

@section('code')
<script>
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 1, // Affiche un seul slide à la fois
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000, // Temps en millisecondes avant de passer à la diapositive suivante
            disableOnInteraction: false, // Continue l'autoplay même après une interaction utilisateur
        },
    });
</script>


@endsection