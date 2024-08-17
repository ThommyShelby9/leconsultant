@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Type AC</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modifier une Donnée </h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.type.list') }}">Type de Directions</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">

    <div class="offset-3 col-lg-6 mt-3">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Modifier une donnée</h3>
            </div>

            <form role="form" method="POST" action="{{ Route('admin.type.save.edit') }}" >
                @csrf
                <input type="hidden" name="id" value="{{ $type->id }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Type de donnée</label>
                        <select name="useFor" id="" class="form-control">
                            @if($type->useFor == "activite")
                                <option value="activite" selected >Domaine d'activite</option>
                                <option value="marche">Type de marché</option>
                            @elseif($type->useFor == "marche")
                                <option value="activite">Domaine d'activite</option>
                                <option value="marche" selected >Type de marché</option>
                            @endif

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Titre</label>
                        <input type="text" class="form-control" name="titre" value="{{ @old('titre',$type->title) }}" placeholder="">
                        @error('titre')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary px-3">Modifier</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('code')

@endsection
