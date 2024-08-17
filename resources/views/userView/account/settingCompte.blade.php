@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')

@endsection


@section('contenu')
<div class="tab-pane show active fade p-8 bg-white shadow" id="tabs-profilJustify" role="tabpanel"
aria-labelledby="tabs-profil-tabJustify">
    <div class="flex flex-wrap lg:mb-6 mb-12">
        <div class="mr-8">
            <i class="fi-xnsux2-bell-solid"></i>
        </div>
        <div class="w-auto">
            <h4 class="text-consultant-gris">
                Recevoir les messages de noification de publication d’offres par e-mail
            </h4>
        </div>
        <div class="lg:ml-64 rounded-checkbox">
            <input type="checkbox" class="" id="c1">
            <label for="c1"></label>
        </div>
    </div>
    <div class="flex flex-wrap lg:mb-6 mb-12">
        <div class="mr-8">
            <i class="fi-xnsux2-bell-solid"></i>
        </div>
        <div class="w-auto">
            <h4 class="text-consultant-gris">
                Recevoir les messages de noification de publication d’offres par e-mail
            </h4>
        </div>
        <div class="lg:ml-64 rounded-checkbox">
            <input type="checkbox" class="" id="c2">
            <label for="c1"></label>
        </div>
    </div>
    <div class="flex flex-wrap">
        <div class="mr-8">
            <i class="fi-xnsux2-bell-solid"></i>
        </div>
        <div class="w-auto">
            <h4 class="text-consultant-gris">
                Recevoir les messages de noification de publication d’offres par e-mail
            </h4>
        </div>
        <div class="lg:ml-64 rounded-checkbox">
            <input type="checkbox" class="" id="c3">
            <label for="c1"></label>
        </div>
    </div>
    <div class="flex flex-wrap justify-end mt-8">
        <a href="" class="link-consultant mr-2">
            Enregistrer les modifications
        </a><i class="fi-xwlrxl-arrow-simple-wide text-consultant-blue"></i>
    </div>
</div>
@endsection
