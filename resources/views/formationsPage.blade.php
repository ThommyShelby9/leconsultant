@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Formations</title>
@endsection


@section('banner')
<section id="banner" class="relative overflow-hidden bg-contain bg-no-repeat bg-center"
    style="background-image: linear-gradient(to bottom, rgba(26, 26, 27, 0.6), rgba(26, 26, 27, 0.6)), url('assets/img/happy-confident-business-coach-wearing-glasses 1.png');">
    <div class="lg:pt-92 lg:pb-64 pt-40 pb-28">
        <div class="container">
            <h1 class="text-white text-center lg:text-6xl text-4xl font-bold mb-9 uppercase">
                Adapté à vos besoins en marchés publics / appels d'offres
            </h1>
            <p class="text-white text-justify lg:text-lg text-sm mb-3">
                Découvrez une solution conçue pour simplifier la gestion de vos réponses aux appels d'offres publics et privés. Nous mettons à votre disposition une plateforme intuitive qui vous permet d'accéder rapidement aux opportunités les plus pertinentes, adaptées à votre secteur d'activité et à vos besoins spécifiques.
            </p>
            <p class="text-white text-justify lg:text-lg text-sm">
                Que vous soyez une petite ou une grande entreprise, nous vous aidons à rester informé et à saisir les meilleures occasions sur le marché. Profitez d'un service qui optimise vos chances de succès en vous permettant de suivre, analyser et répondre aux appels d'offres en toute simplicité.
            </p>

        </div>
    </div>
</section>
@endsection


@section('contenu')

<section id="services" class="relative">
    <div class="container">
        <h2 class="lg:text-4xl text-2xl font-medium text-left mb-5 text-consultant-rouge">
            Nos formations
        </h2>
        <div class="flex flex-wrap">

        </div>
        <div class="grid lg:grid-cols-3 grid-cols-1 gap-12">
            @foreach ($formations as $item)
            <div class="card-formation" data-aos="zoom-out-left">
                <a href="">
                    <div class="h-[280px]">
                        <img src="{{asset($item->imageForm)}}" alt=""
                            class="object-cover object-center w-full h-full">
                    </div>
                    <div class="px-9 pt-6 pb-7">
                        <div class="card-formation-content">
                            <h3 class="lg:text-lg text-sm font-semibold mb-6 text-justify">
                                {{$item->titre}}
                            </h3>
                            <p class="text-xs text-justify mb-12">
                                {{ substr($item->description, 0,255)   }}
                            </p>
                            <div class="flex justify-end">
                                <a href="{{ route('formation.item',[$item->id , substr($item->titre , 0 , 10) ]) }}" class="text-lg text-consultant-blue">
                                    Lire plus | Participer
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
        <div class="flex justify-end my-4">
            <div class="flex justify-end my-4">
                {{ $formations->links('layout.pagination')}}

            </div>
        </div>
    </div>
</section>

@endsection