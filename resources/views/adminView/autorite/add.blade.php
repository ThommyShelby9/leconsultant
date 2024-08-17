@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| A.C </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Ajouter une nouvelle autorité contractante</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.ac.list') }}">Autorité C.</a></li>
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Informations sur cette A.C</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="px-4 pb-5 pt-3" method="POST" action="{{ Route('admin.ac.add') }}" enctype="multipart/form-data"  >
                @csrf
                <div class="form-row">
                    <div class="col-sm-12  col-md-6">
                        <div class="form-group">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie" id="" class="form-control" onselected="{{  @old('categorie')}}" >
                                <option value="">Choisir</option>
                                @foreach ($les_categories as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('categorie')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" value="{{ @old('nom') }}" class="form-control"
                                placeholder="" aria-describedby="helpId">
                            @error('nom')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="abrev">Abreviation</label>
                            <input type="text" name="abrev" id="" value="{{ @old('abrev') }}" class="form-control"
                                placeholder="" aria-describedby="helpId">
                            @error('abrev')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="localisation">Localisation</label>
                            <input type="text" value="{{ @old('localisation') }}" name="localisation" id="localisation"
                                class="form-control" placeholder="" aria-describedby="helpId">
                            @error('localisation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="text" name="contact" id="" value="{{ @old('contact') }}" class="form-control"
                                placeholder="" aria-describedby="helpId">
                            @error('contact')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ @old('email') }}" id="email" class="form-control"
                                placeholder="" aria-describedby="helpId">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="logo">Logo de l'AC</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo">
                                    <label class="custom-file-label" for="logo">Choisir un logo</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Chosir le logo</span>
                                </div>
                            </div>
                            @error('logo')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection
