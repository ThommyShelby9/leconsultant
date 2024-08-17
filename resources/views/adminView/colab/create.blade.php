@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Collaborateurs</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Creer un nouveau collaborateur</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.colab.list') }}">Collaborateur</a></li>
            <li class="breadcrumb-item active">Créer un nouveau</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="offset-lg-3 col-lg-6">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Ajouter un Administrateur</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ Route('admin.colab.save') }}" >
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pseudo</label>
                        <input type="text" name="pseudo" id="" class="form-control" placeholder="Ex: Toni Ablawa" value="{{ @old('pseudo') }}" >
                        @error('pseudo')
                        <span class="text-danger">{{ $message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Role de l'admnistrateur</label>
                        <select name="role" id="role" class="form-control">
                            <option value="1">Tous les droits</option>
                            <option value="2">Rédacteur</option>
                            <option value="3">Gère le site web</option>
                            <option value="4">Gère les formations</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" id="" placeholder="Ex: bake@gmail.com">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Mot de passe</label>
                        <input type="password" name="mdp" class="form-control" id="" placeholder="*******">
                        @error('mdp')
                        <span class="text-danger">{{ $message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Confirmer Mot de passe</label>
                        <input type="password" name="mdp1" class="form-control" id="" placeholder="*******">
                        @error('mdp1')
                        <span class="text-danger">{{ $message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('code')

@endsection
