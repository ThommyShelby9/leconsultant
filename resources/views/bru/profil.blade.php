@extends('bru.template')

@section('contenu')

@if($infos->typeActor == 1)
<div class="row bg-white mb-5 p-3" id="param">

    <div class="col-lg-3">
      <div class="form-group">
        <label for="">  Nom</label>
        <p>{{$infos->nom}}</p>
      </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Prénoms </label>
          <p>{{$infos->prenoms}}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Email </label>
          <p>{{$infos->email}}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Teléphone </label>
          <p>{{$infos->telephone }}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Adresse </label>
          <p>{{$infos->adresse}}</p>
        </div>
    </div>
</div>
@elseif($infos->typeActor==2)
<div class="row bg-white mb-5 p-3" id="param">

    <div class="col-lg-3">
      <div class="form-group">
        <label for="">  Type de Societe</label>
        <p>{{$infos->typeSociete}}</p>
      </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for="">Dénomination Sociale </label>
          <p>{{$infos->nomSociete}}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Email </label>
          <p>{{$infos->email}}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Teléphone </label>
          <p>{{$infos->telephoneSociete }}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
          <label for=""> Adresse </label>
          <p>{{$infos->adresseSociete}}</p>
        </div>
    </div>
</div>
@endif

@endsection
