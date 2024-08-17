@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Collaborateurs</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modifier un collaborateur</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.colab.list') }}">Collaborateur</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="offset-lg-3 col-lg-6">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Modifier un Administrateur</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ Route('admin.colab.edit.save') }}" >
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pseudo</label>
                        <input type="text" name="pseudo" id="" class="form-control" placeholder="Ex: Toni Ablawa" value="{{ @old('pseudo', $admin->name) }}" >
                        @error('pseudo')
                        <span class="text-danger">{{ $message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Role de l'admnistrateur</label>
                        <select name="role" id="role" class="form-control">
                            @switch($admin->role)
                                @case(1)
                                    <option value="1" selected >Tous les droits</option>
                                    <option value="2">Rédacteur</option>
                                    <option value="3">Gère le site web</option>
                                    <option value="4">Gère les formations</option>
                                    @break
                                @case(2)
                                    <option value="1">Tous les droits</option>
                                    <option value="2" selected >Rédacteur</option>
                                    <option value="3">Gère le site web</option>
                                    <option value="4">Gère les formations</option>
                                    @break
                                @case(3)
                                    <option value="1">Tous les droits</option>
                                    <option value="2">Rédacteur</option>
                                    <option value="3" selected>Gère le site web</option>
                                    <option value="4">Gère les formations</option>
                                    @break
                                @case(4)
                                <option value="1">Tous les droits</option>
                                <option value="2">Rédacteur</option>
                                <option value="3">Gère le site web</option>
                                <option value="4" selected>Gère les formations</option>
                                    @break
                            @endswitch

                        </select>
                    </div>
                    <input type="hidden" name="id" value="{{$admin->id }}" >
                    <!--div class="form-group">
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
                    </div-->

                    <button type="submit" class="btn btn-primary px-4">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('code')

@endsection
