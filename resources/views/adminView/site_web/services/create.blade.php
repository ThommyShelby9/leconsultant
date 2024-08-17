@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Site web</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Créer un service</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('adminSite.services.list') }}">Site web</a></li>
            <!--li class="breadcrumb-item active">New</li-->
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-navy">
            <div class="card-header">
                Creer un service
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">
                <form action="{{ route('adminSite.services.save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Titre</label>
                                <input type="text" name="titre" value="{{ @old('titre') }}" id="" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                                    @error('titre')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="col-md-12">
                            <label for="fichier">Texte mis en avant</label>
                            <textarea  class="form-control" name="description"  id="" cols="30" rows="5">{{ @old('description') }}</textarea>
                            @error('description')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="">Contenu de la page</label>
                      <textarea name="contenu" id="" cols="30" rows="10" class="textarea">{{ @old('contenu') }}</textarea>
                      @error('contenu')
                                    <span class="text-danger">{{$message }}</span>
                                    @enderror
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Statut</label>
                                <select name="statut" id="" class="form-control">
                                    <option value="1">Publier en meme temps</option>
                                    <option value="0">Ne pas Publier en meme temps</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fichier">Image mis en avant</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="fichier">
                                        <label class="custom-file-label" for="logo">Choisir</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Chosir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success px-9 py-2">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection

@section('code')

@endsection
