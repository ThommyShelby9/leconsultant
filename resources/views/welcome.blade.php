@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Accueil</title>
@endsection

@section('banner')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@if($user)
@if(!$hasActiveSubscription)

<!-- Inclure le script SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Afficher le formulaire de paiement PayPlus
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Abonnement requis!",
            text: "Veuillez souscrire à l'abonnement de 1490 FCFA pour accéder à la plateforme.",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: 'Souscrire maintenant',
            allowOutsideClick: false,
            allowEscapeKey: false,
            html: `
                <div class="p-4">
                    <p class="mb-4">Pour continuer, veuillez entrer votre numéro de téléphone Mobile Money</p>
                    <form id="subscription-form" action="{{ route('subscription.initiate', ['packId' => 10]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="tel"
                                   name="phone"
                                   id="phone-input"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                   placeholder="Ex: 97000000"
                                   pattern="[0-9]{8,15}"
                                   required>
                            <small class="text-gray-500">Format: 8 à 15 chiffres</small>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600 mb-2">1490 FCFA</p>
                            <p class="text-sm text-gray-600">Abonnement mensuel</p>
                        </div>
                    </form>
                </div>
            `,
            preConfirm: () => {
                const phone = document.getElementById('phone-input').value;
                if (!phone || phone.length < 8) {
                    Swal.showValidationMessage('Veuillez entrer un numéro de téléphone valide');
                    return false;
                }
                return phone;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Soumettre le formulaire
                document.getElementById('subscription-form').submit();
            }
        });
    });
</script>

@endif
@endif

@include('sweetalert::alert') <!-- Inclus pour afficher les alertes -->

<!-- Vos scripts -->
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
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
<section id="offres" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-consultant-rouge text-3xl lg:text-5xl font-bold mb-8" data-aos="fade-up">Les dernières offres publiées</h2>
        <div id="offre-list" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach ($offres as $item)
            <div class="offre-item bg-white shadow-lg rounded-xl p-6 flex flex-col lg:flex-row h-80 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-2 hover:border-consultant-rouge" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="w-full lg:w-1/5 flex items-center justify-center mb-4 lg:mb-0">
                    <img src="{{ $item->logo ? asset($item->logo) : asset('default_offres.jpg') }}" alt="logo" class="w-full rounded-lg object-contain transition-transform duration-300 hover:scale-110">
                </div>
                <div class="w-full lg:w-4/5 lg:pl-6 flex flex-col justify-between">
                    <a href="javascript:void(0);" class="text-xl lg:text-2xl font-bold text-gray-800 hover:text-consultant-rouge transition-colors duration-300"
                        onclick="handleOfferClick('{{ $item->id }}')">
                        {{ Str::limit($item->titre, 60) }}
                    </a>
                    <p class="text-consultant-blue text-lg font-medium mt-2">{{ $item->autName }}</p>
                    <hr class="my-3 border-gray-200">
                    <div class="text-gray-600 text-sm space-y-2">
                        <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-consultant-rouge" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>Catégorie: {{ $item->categTitle }}</p>
                        @if(auth()->check())
                        <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-consultant-blue" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>Type: {{ $item->typeTitle }}</p>
                        @endif
                        <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>Publiée le: {{ date('d M Y', strtotime($item->datePublication)) }}</p>
                        <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>Expire le: {{ date('d M Y', strtotime($item->dateExpiration)) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Ajouter le bouton "Voir plus" si le nombre total d'offres est supérieur à 4 -->
        @if ($totalOffres > 4)
            <div class="mt-8 text-center">
                <button id="load-more" class="bg-consultant-rouge text-white px-6 py-2 rounded-lg" 
                    onclick="handleLoadMore()">Voir plus</button>
                <button id="load-less" class="bg-gray-500 text-white px-6 py-2 rounded-lg" 
                    style="display:none;" onclick="loadLessOffres()">Voir moins</button>
            </div>
        @endif
    </div>
</section>


<!-- Section des actualités du Bénin -->
@if(!empty($news) && count($news) > 0)
<section id="actualites" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-consultant-blue text-3xl lg:text-5xl font-bold mb-8 text-center" data-aos="fade-up">Actualités du Bénin</h2>
        <div class="swiper-container" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                @foreach($news as $article)
                <div class="swiper-slide">
                    <div class="bg-[#F5FAFE] rounded-xl shadow-lg p-8 max-w-4xl mx-auto hover:shadow-2xl transition-shadow duration-300">
                        @if(isset($article->urlToImage) && $article->urlToImage)
                        <img src="{{ $article->urlToImage }}" alt="{{ $article->title ?? 'Actualité' }}" class="rounded-lg mb-6 shadow-md">
                        @endif
                        <h4 class="text-2xl font-bold text-gray-800 mb-4">{{ $article->title ?? 'Sans titre' }}</h4>
                        <p class="text-gray-700 leading-relaxed mb-6">{{ Str::limit($article->description ?? '', 200) }}</p>
                        @if(isset($article->url))
                        <a href="{{ $article->url }}" target="_blank" class="inline-flex items-center bg-consultant-blue text-white px-6 py-3 rounded-lg hover:bg-consultant-rouge transition-colors duration-300">
                            Lire l'article complet
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        @endif
                        @if(isset($article->source->name))
                        <p class="text-sm text-gray-500 mt-4">Source: {{ $article->source->name }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Navigation Swiper -->
            <div class="swiper-pagination mt-8"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
@endif

<!-- Section pour inciter à s'inscrire et s'abonner -->
@if(!auth()->check())

<section id="subscription-call" class="py-16 bg-gradient-to-r from-consultant-blue to-consultant-rouge">
    <div class="container mx-auto text-center px-4" data-aos="zoom-in">
        <h2 class="text-white text-3xl lg:text-5xl font-bold mb-4">Accédez pleinement à notre plateforme</h2>
        <p class="text-white text-lg lg:text-xl mb-8 max-w-3xl mx-auto">
            Inscrivez-vous dès aujourd'hui et souscrivez à notre abonnement mensuel à seulement <span class="font-bold text-yellow-300">1490 FCFA</span> pour profiter de toutes les fonctionnalités et ne manquer aucune opportunité d'affaires.
        </p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('register.morale') }}" class="bg-white text-consultant-rouge py-3 px-8 rounded-lg text-lg font-semibold hover:bg-yellow-300 hover:text-consultant-blue transition-all duration-300 transform hover:scale-105 shadow-lg">S'inscrire maintenant</a>
            <a href="{{ route('login') }}" class="bg-yellow-400 text-consultant-blue py-3 px-8 rounded-lg text-lg font-semibold hover:bg-white hover:text-consultant-rouge transition-all duration-300 transform hover:scale-105 shadow-lg" style="display: inline-block;">Se connecter</a>
        </div>
    </div>
</section>
@endif



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

    /* Animation de fade-in lors de l'affichage des nouvelles offres */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Classe appliquée pour l'animation */
.offre-item {
    animation: fadeIn 0.6s ease-in-out;
    cursor: pointer;
}

/* Amélioration de l'effet hover sur les cartes d'offres */
.offre-item:hover {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
}

/* Animation pour les boutons */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.hover\:scale-105:hover {
    animation: pulse 2s infinite;
}

/* Style amélioré pour le conteneur Swiper */
.swiper-container {
    padding: 20px 0;
}

.swiper-button-next,
.swiper-button-prev {
    background-color: rgba(255, 255, 255, 0.8);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    color: #1e40af;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background-color: rgba(255, 255, 255, 1);
    transform: scale(1.1);
    transition: all 0.3s ease;
}

.swiper-pagination-bullet {
    background: #1e40af;
    opacity: 0.5;
    width: 12px;
    height: 12px;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background: #dc2626;
}

/* Responsive amélioré */
@media (max-width: 768px) {
    .offre-item {
        height: auto;
        min-height: 320px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }
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



</script>
<!-- Inclure SweetAlert via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
// Initialiser AOS
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100
});

function handleOfferClick(offerId) {
    const isLoggedIn = @json(auth()->check());
    const hasSubscription = @json($hasActiveSubscription ?? false);

    if (!isLoggedIn) {
        swal({
            title: "Connexion requise",
            text: "Vous devez vous connecter pour consulter les détails de cette offre.",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Se connecter",
            cancelButtonText: "Annuler"
        }).then((willRedirect) => {
            if (willRedirect) {
                window.location.href = '/login';
            }
        });
    } else if (!hasSubscription) {
        swal({
            title: "Abonnement requis",
            text: "Vous devez avoir un abonnement actif pour consulter les détails des offres.",
            type: "warning",
            confirmButtonText: "OK"
        });
    } else {
        // Rediriger vers la page de détails de l'offre
        window.location.href = '/appels-d-offres';
    }
}

function handleLoadMore() {
    const isLoggedIn = @json(auth()->check());

    if (!isLoggedIn) {
        swal({
            title: "Connexion requise",
            text: "Vous devez vous connecter pour voir plus d'offres. Inscrivez-vous gratuitement !",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Se connecter",
            cancelButtonText: "Annuler"
        }).then((willRedirect) => {
            if (willRedirect) {
                window.location.href = '/login';
            }
        });
    } else {
        window.location.href = '/appels-d-offres';
    }
}
</script>


@endsection