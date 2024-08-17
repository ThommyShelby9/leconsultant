@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Formation</title>
@endsection

@section('titre')

<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Créer une Formation</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.formation.list') }}">Les formations</a></li>
            <li class="breadcrumb-item active">Modifier une formation</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')


<div class="row">

    <div class="col-lg-12">
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="card  card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    Publier une formation
                </h3>
            </div>
            <form class="px-4" action="{{ route('admin.formation.edit.save') }} " method="post" >
                @csrf
                <input type="hidden" name="id" value="{{ $formation->id }}" >

                <div class="form-row mt-3">
                    <div class="form-group col-md-3">
                        <label for="niveau">Niveau</label>

                        <select class="form-control" name="niveau">
                            @switch($formation->niveau )
                            @case("Debutant")
                                <option value="Debutant" selected >Débutant</option>
                                <option value="Avance">Avancé</option>
                                <option value="Expert">Expert</option>
                                @break
                            @case("Avance")
                                <option value="Debutant">Débutant</option>
                                <option value="Avance" selected>Avancé</option>
                                <option value="Expert">Expert</option>
                                @break
                            @case("Expert")
                                <option value="Debutant">Débutant</option>
                                <option value="Avance">Avancé</option>
                                <option value="Expert" selected >Expert</option>
                                @break
                            @default
                            @endswitch

                        </select>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="titre">Titre de la formation</label>
                        <input type="text" name="titre" id="" class="form-control" value="{{ @old('titre',$formation->titre) }}" >
                        @error('titre')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <label for="description">Description de la formation</label>
                        <textarea name="description" id="" cols="30" rows="5" class="form-control" >{{ @old('description',$formation->description)}}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="competence">Compétences requises</label>
                        <textarea name="competence" id="" cols="30" rows="5" class="form-control" >{{ @old('competence',$formation->competence) }}</textarea>
                        <small>Si aucune, laissez ça vide </small>
                        @error('competence')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <label for="titre">Durée de la formation</label>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <div class="form-group">
                                  <label for="dureeNbre">Nombre</label>
                                  <input type="number" value="{{ @old('dureeNbre',$formation->dureeNbre)}}" name="dureeNbre" id="" class="form-control" placeholder="">
                                @error('dureeNbre')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Tranche</label>
                                <select class="form-control" name="dureeMode">
                                    @switch($formation->dureeMode)
                                        @case("Heures")
                                            <option value="Heures" selected>Heure(s)</option>
                                            <option value="Jours">Jour(s)</option>
                                            <option value="Semaines"  >Semaine(s)</option>
                                            @break
                                        @case("Jours")
                                            <option value="Heures">Heure(s)</option>
                                            <option value="Jours" selected >Jour(s)</option>
                                            <option value="Semaines"  >Semaine(s)</option>
                                            @break
                                        @case("Semaines")
                                            <option value="Heures">Heure(s)</option>
                                            <option value="Jours">Jour(s)</option>
                                            <option value="Semaines" selected >Semaine(s)</option>
                                        @break

                                        @default
                                    @endswitch

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="titre">Première séance de la formation</label>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <div class="form-group">
                                  <label for="">Date</label>
                                  <input type="date" name="firstDate" value="{{ @old('firstDate',$formation->firstDate) }}" id="" class="form-control" placeholder="">
                                  @error('firstDate')
                                  <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="niveau">Heure</label>
                                <input type="time" name="firstTime"  value="{{ @old('firstTime',$formation->firstTime) }}" id="" class="form-control" >
                                @error('firstTime')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Lieu de la formation</label>
                    <input type="text" name="lieu" value="{{ @old('lieu',$formation->lieu) }}" class="form-control"  placeholder="">
                    @error('lieu')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputCity">Prix de la formation</label>
                        <input type="number" name="prix" value="{{ @old('prix',$formation->prix) }}" class="form-control" id="inputCity">
                        <span>Mettre 0 si c'est gratuit</span>
                        @error('prix')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">Nombre de place</label>
                        <input type="number"  name="nbrePlace" value="{{ @old('nbrePlace',$formation->nbrePlace) }}" class="form-control">
                        @error('nbrePlace')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputZip">Fermer la reservation de place le</label>
                        <input type="date" name="dateExpiration" value="{{ @old('dateExpiration',$formation->dateExpiration) }}" class="form-control" id="inputZip">
                        @error('dateExpiration')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Contenu de la formation</label>
                    <textarea name="contenu" id="" cols="30" rows="10" class="textarea form-control">{{  @old('contenu',$formation->contenu)}}</textarea>
                    @error('contenu')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Nom du conférencier</label>
                        <input type="text" name="confName" value="{{ @old('confName',$formation->confName) }}" class="form-control" >
                        @error('confName')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputState">Poste</label>
                        <input type="text" name="confPoste" value="{{ @old('confPoste',$formation->confPost) }}" class="form-control">
                        @error('confPoste')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Source de la formation</label>
                        <input readonly name="source" type="text" value="DRWWINTECH - Leconsultant" class="form-control" id="inputCity">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary py-2 px-4 mb-5">Publier la plateforme</button>
            </form>

        </div>
    </div>
</div>
@endsection


@section('code')

@endsection
