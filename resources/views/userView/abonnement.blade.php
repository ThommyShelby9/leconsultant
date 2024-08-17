@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:pt-14 pt-6 lg:pb-64 pb-20">
        <div class="container">
            <h1 class="text-center text-white lg:text-7xl text-5xl font-normal uppercase mb-3">
                Abonnement
            </h1>
            <h2 class="text-white lg:text-xl text-sm text-center">
                Simple and affordable pricing that will meet your business needs
            </h2>
        </div>
    </div>
</section>

@endsection


@section('contenu')


<section class="container">
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-10 -mt-24">
        @foreach ($les_packs as $item)
        <div class="relative bg-white rounded-3xl border border-consultant-rouge2">
            <div class="py-5 px-8">
                <div class="flex flex-col justify-between">
                    <div class="flex flex-col items-center">
                        <h3 class="pills-abonnement">
                            {{$item->titre}}
                         </h3>
                         <div class="mb-2">
                             <h4 class="lg:text-5xl text-xl text-consultant-rouge flex items-center">
                                {{$item->prix}} Fcfa
                             </h4>
                         </div>
                         <div class="mb-7">
                            <h4 class="lg:text-3xl text-xl text-consultant-rouge flex items-center">
                               <span class="lg:text-2xl text-lg text-consultant-blue ml-2">pour {{$item->nombre." ".$item->modalite}}</span>
                            </h4>
                        </div>
                         <ul class="list-abo">
                            <li class="lg:text-lg text-sm mb-3">
                                Faire des Recherches avancées
                            </li>
                            <li class="lg:text-lg text-sm mb-3">
                                Créer des alertes et Recevoir les offres par mail
                            </li>
                            <li class="lg:text-lg text-sm mb-3">
                                Possibilité de voir les détails et de télécharger les appels d'offres
                            </li>
                            <li class="lg:text-lg text-sm">
                                Possibilité de télecharger l'avis des appels d'offres
                            </li>
                        </ul>
                    </div>
                    <div class="flex mt-24 mb-12">
                        <a href="{{ route('mesAbonnements') }}" class="py-4 px-16 border text-center border-consultant-rouge2 rounded-full w-full bg-white">
                            S'ouscrire à ce pack
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
