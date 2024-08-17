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
            <li class="breadcrumb-item active">Publier une nouvelle</li>
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
            <form class="px-4" action="{{ route('admin.formation.save') }} " method="post" >
                @csrf

                <div class="form-row mt-3">
                    <div class="form-group col-md-3">
                        <label for="niveau">Niveau</label>
                        <select class="form-control" name="niveau">
                            <option value="Debutant">Débutant</option>
                            <option value="Avance">Avancé</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="titre">Titre de la formation</label>
                        <input type="text" name="titre" id="" class="form-control" value="{{ @old('titre') }}" >
                        @error('titre')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <label for="description">Description de la formation</label>
                        <textarea name="description" id="" cols="30" rows="5" class="form-control" >{{ @old('description')}}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="competence">Compétences requises</label>
                        <textarea name="competence" id="" cols="30" rows="5" class="form-control" >{{ @old('competence') }}</textarea>
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
                                  <input type="number" value="{{ @old('dureeNbre',1)}}" name="dureeNbre" id="" class="form-control" placeholder="">
                                @error('dureeNbre')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Tranche</label>
                                <select class="form-control" name="dureeMode">
                                    <option value="Heures">Heure(s)</option>
                                    <option value="Jours">Jour(s)</option>
                                    <option value="Semaines">Semaine(s)</option>
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
                                  <input type="date" name="firstDate" value="{{ @old('firstDate') }}" id="" class="form-control" placeholder="">
                                  @error('firstDate')
                                  <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="niveau">Heure</label>
                                <input type="time" name="firstTime"  value="{{ @old('firstTime') }}" id="" class="form-control" >
                                @error('firstTime')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Lieu de la formation</label>
                    <input type="text" name="lieu" value="{{ @old('lieu') }}" class="form-control"  placeholder="">
                    @error('lieu')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputCity">Prix de la formation</label>
                        <input type="number" name="prix" value="{{ @old('prix',0) }}" class="form-control" id="inputCity">
                        <span>Mettre 0 si c'est gratuit</span>
                        @error('prix')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">Nombre de place</label>
                        <input type="number"  name="nbrePlace" value="{{ @old('nbrePlace',25) }}" class="form-control">
                        @error('nbrePlace')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputZip">Fermer la reservation de place le</label>
                        <input type="date" name="dateExpiration" value="{{ @old('dateExpiration') }}" class="form-control" id="inputZip">
                        @error('dateExpiration')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Contenu de la formation</label>
                    <textarea name="contenu" id="" cols="30" rows="10" class="textarea form-control">{{  @old('contenu')}}</textarea>
                    @error('contenu')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Nom du conférencier</label>
                        <input type="text" name="confName" value="{{ @old('confName') }}" class="form-control" >
                        @error('confName')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputState">Poste</label>
                        <input type="text" name="confPoste" value="{{ @old('confPoste') }}" class="form-control">
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
                <button type="submit" class="btn btn-primary py-2 px-4 mb-5">Publier sur la plateforme</button>
            </form>

        </div>
    </div>
</div>
@endsection


@section('code')

@endsection
