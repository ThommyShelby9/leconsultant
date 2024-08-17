@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')

@endsection


@section('contenu')

@if($infos->typeActor == 1)

<div class="tab-pane fade show active bg-white shadow-lg" id="tabs-profilJustify" role="tabpanel"
    aria-labelledby="tabs-profil-tabJustify">

    <div class="p-8">
        <div class="flex items-center mb-3">
            <i class="fi-xnsux3-map-marker-solid mr-2"></i>
            <h4 class="font-medium">Mon Email</h4>
        </div>
        <h4 class="ml-14 mb-7">{{$infos->email}}</h4>

        <div class="flex items-center mb-3">
            <i class="fi-xnsrx3-phone-solid mr-2"></i>
            <h4 class="font-medium">Teléphone </h4>
        </div>
        <h4 class="ml-14 mb-12">{{$infos->telephone }}</h4>
    </div>
    <hr class="h-1 w-full mb-5">
    <div class="p-8">
        <div class="flex items-center mb-5">
            <i class="fi-xnsrx3-phone-solid mr-2"></i>
            <h4 class="font-medium">Adresse  </h4>
        </div>
        <h4 class="ml-14 mb-12">{{$infos->adresse}}</h4>
    </div>

</div>

@elseif($infos->typeActor==2)

<div class="tab-pane fade show active bg-white shadow-lg" id="tabs-profilJustify" role="tabpanel"
    aria-labelledby="tabs-profil-tabJustify">

    <div class="p-8">
        <div class="flex items-center mb-5">
            <i class="fi-xnsux3-map-marker-solid mr-2"></i>
            <h4 class="font-medium">Type de Societe</h4>
        </div>
        <h4 class="ml-14 mb-7">{{$infos->typeSociete}}</h4>

        <div class="flex items-center mb-5">
            <i class="fi-xnsrx3-phone-solid mr-2"></i>
            <h4 class="font-medium">Dénomination Sociale</h4>
        </div>
        <h4 class="ml-14 mb-12">{{$infos->nomSociete}}</h4>
    </div>
    <hr class="h-1 w-full mb-12">
    <div class="p-8">
        <div class="flex items-center mb-5">
            <i class="fi-xnsux3-map-marker-solid mr-2"></i>
            <h4 class="font-medium">Email</h4>
        </div>
        <h4 class="ml-14 mb-7">{{$infos->email}}</h4>

        <div class="flex items-center mb-5">
            <i class="fi-xnsrx3-phone-solid mr-2"></i>
            <h4 class="font-medium">Teléphone </h4>
        </div>
        <h4 class="ml-14 mb-12">{{$infos->telephoneSociete }}</h4>
    </div>
    <hr class="h-1 w-full mb-12">
    <div class="p-8">
        <div class="flex items-center mb-5">
            <i class="fi-xnsrx3-phone-solid mr-2"></i>
            <h4 class="font-medium">Adresse  </h4>
        </div>
        <h4 class="ml-14 mb-12">{{$infos->adresseSociete}}</h4>
    </div>
</div>

@endif

@endsection
