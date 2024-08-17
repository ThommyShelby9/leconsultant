@extends('bru.template')

@section('contenu')

@if($infos->typeActor == 1)
<form method="POST" action="{{Route('save.edit.compte')}}" class="pt-2 pb-4">
    @csrf

    <div class="row bg-white mb-5 p-3" id="param">

        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Nom</label>
                <input id="nom" type="text" class="form-control" placeholder="Nom *" name="nom"
                    value="{{ old('nom', $infos->nom) }}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Prénom(s)</label>
                <input id="prenoms" type="text" class="form-control" placeholder="Prénom(s) *" name="prenoms"
                    value="{{ old('prenoms',$infos->prenoms) }}" autocomplete="prenoms">
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Adresse </label>
                <input id="adresse" type="text" class="form-control" name="adresse" placeholder="Adresse *"
                    value="{{ old('adresse',$infos->adresse) }}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Téléphone </label>
                <input id="telephone" type="text" class="form-control" name="telephone"
                    placeholder="Numéro de téléphone*" value="{{ old('telephone',$infos->telephone) }}">
            </div>
        </div>

        <input type="hidden" name="idUser" value="{{$infos->id }}">

        <div class="col-12 text-right ">
            <button class="btn  my-3" style="color: #0140BA; ">Enregistrer les modifications</button>
        </div>

    </div>
</form>

@elseif($infos->typeActor==2)
<form method="POST" action="{{Route('save.edit.compte')}}" class="pt-2 pb-4">
    @csrf

    <div class="row bg-white mb-5 p-3" id="param">

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

        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Nom Société</label>
                <input id="nomSociete" type="text" class="form-control" name="nomSociete"
                    placeholder="Dénomination sociale *" value="{{ old('nomSociete', $infos->nomSociete) }}">
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Adresse </label>
                <input id="adresse" type="text" class="form-control" name="adresse"
                    value="{{ old('adresse', $infos->adresseSociete) }}" placeholder="Adresse de l'entreprise *">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for=""> Téléphone </label>
                <input id="telephone" type="text" class="form-control" name="telephone"
                    value="{{ old('telephone', $infos->telephoneSociete) }}" placeholder="Numero de telephone *">
            </div>
        </div>

        <input type="hidden" name="idUser" value="{{$infos->id }}">

        <div class="col-12 text-right ">
            <button class="btn  my-3" style="color: #0140BA; ">Enregistrer les modifications</button>
        </div>

    </div>
</form>

@endif

@endsection
