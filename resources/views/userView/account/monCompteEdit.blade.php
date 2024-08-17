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
        <form method="POST" action="{{Route('save.edit.compte')}}" class="">
            @csrf

            <div class="flex items-center mb-5">
                <i class="fi-xnsuxx-map-marker-solid mr-2"></i>
                <h4 class="font-medium">Nom</h4>
            </div>
            <input id="nom" type="text" class="inp-profil" placeholder="Nom *" name="nom"
                    value="{{ old('nom', $infos->nom) }}">

            <div class="flex items-center mb-5">
                <i class="fi-xnsuxx-map-marker-solid mr-2"></i>
                <h4 class="font-medium"> Prénom(s)</h4>
            </div>
            <input id="prenoms" type="text" class="inp-profil" placeholder="Prénom(s) *" name="prenoms"
                    value="{{ old('prenoms',$infos->prenoms) }}" autocomplete="prenoms">

            <div class="flex items-center mb-5">
                <i class="fi-xnsrxx-phone-solid mr-2"></i>
                <h4 class="font-medium">Adresse </h4>
            </div>
            <input id="adresse" type="text" class="inp-profil" name="adresse" placeholder="Adresse *"
                    value="{{ old('adresse',$infos->adresse) }}">

            <div class="flex items-center mb-5">
                <i class="fi-xnsrxx-phone-solid mr-2"></i>
                <h4 class="font-medium">Téléphone</h4>
            </div>
            <input id="telephone" type="text"  class="inp-profil" name="telephone"
            placeholder="Numéro de téléphone*" value="{{ old('telephone',$infos->telephone) }}">
            <input type="hidden" name="idUser" value="{{$infos->id }}">


            <div class="flex items-center mb-5">
                <i class="fi-xnsuxx-building-solid mr-2"></i>
                <h4 class="font-medium">Fonction actuelle</h4>
            </div>
            <input type="text" placeholder="Développeur Web" class="inp-profil">
            <div class="flex items-center mb-5">
                <i class="fi-xnsuxx-building-solid mr-2"></i>
                <h4 class="font-medium">Structure de travail</h4>
            </div>
            <input type="text" placeholder="Drwintech" class="inp-profil">

            <div class="flex flex-wrap justify-end">
                <!--a href="" class="link-consultant mr-2">
                    Enregistrer les modifications
                </a><i class="fi-xwlrxl-arrow-simple-wide text-consultant-blue"></i-->
                <button class="btn  my-3" style="color: #0140BA; ">Enregistrer les modifications</button>
            </div>
        </form>
    </div>

</div>

@elseif($infos->typeActor==2)

<div class="tab-pane fade show active bg-white shadow-lg" id="tabs-profilJustify" role="tabpanel"
    aria-labelledby="tabs-profil-tabJustify">

    <div class="p-8">
        <form method="POST" action="{{Route('save.edit.compte')}}"  class="">
            @csrf

            <div class="col-lg-4">
                <div class="form-group">
                    <label for=""> Nom</label>
                    <select name="societeType" id="" class="form-control">
                        @switch($infos->typeSociete)
                        @case("Societe")
                        <option class="text-2xl" selected value="Societe">Société</option>
                        <option class="text-2xl" value="SARL">SARL</option>
                        <option class="text-2xl" value="Etablissement">Etablissement</option>
                        <option class="text-2xl" value="Autres">Autres</option>
                        @break
                        @case("SARL")
                        <option class="text-2xl" value="Societe">Société</option>
                        <option class="text-2xl" selected value="SARL">SARL</option>
                        <option class="text-2xl" value="Etablissement">Etablissement</option>
                        <option class="text-2xl" value="Autres">Autres</option>
                        @break
                        @case("Etablissement")
                        <option class="text-2xl" value="Societe">Société</option>
                        <option class="text-2xl" selected value="SARL">SARL</option>
                        <option class="text-2xl" selected value="Etablissement">Etablissement</option>
                        <option class="text-2xl" value="Autres">Autres</option>
                        @break
                        @case("Autres")
                        <option class="text-2xl" value="Societe">Société</option>
                        <option class="text-2xl" selected value="SARL">SARL</option>
                        <option class="text-2xl" value="Etablissement">Etablissement</option>
                        <option class="text-2xl" selected value="Autres">Autres</option>
                        @break
                        @endswitch

                    </select>
                </div>
            </div>

            <div class="flex items-center mb-5">
                <i class="fi-xnsuxx-map-marker-solid mr-2"></i>
                <h4 class="font-medium">Nom Société</h4>
            </div>
            <input id="nomSociete" type="text" class="inp-profil" name="nomSociete"
                    placeholder="Dénomination sociale *" value="{{ old('nomSociete', $infos->nomSociete) }}">

            <div class="flex items-center mb-5">
                <i class="fi-xnsrxx-phone-solid mr-2"></i>
                <h4 class="font-medium">Adresse </h4>
            </div>
            <input id="adresse" type="text" class="inp-profil" name="adresse"
                    value="{{ old('adresse', $infos->adresseSociete) }}" placeholder="Adresse de l'entreprise *">


            <div class="flex items-center mb-5">
                <i class="fi-xnsuxx-building-solid mr-2"></i>
                <h4 class="font-medium">Téléphone</h4>
            </div>
            <input id="telephone" type="text" class="inp-profil" name="telephone"
                    value="{{ old('telephone', $infos->telephoneSociete) }}" placeholder="Numero de telephone *">

                    <input type="hidden" name="idUser" value="{{$infos->id }}">

            <div class="flex flex-wrap justify-end">
                <!--a href="" class="link-consultant mr-2">
                    Enregistrer les modifications
                </a><i class="fi-xwlrxl-arrow-simple-wide text-consultant-blue"></i-->
                <button class="btn  my-3" style="color: #0140BA; ">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>

@endif

@endsection
