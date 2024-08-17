@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Abonnement </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Les packs d'Abonnements</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pack.list') }}">Abonnement</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-12">
        <div class="alert px-3 py-2">
            @if(Session::get('msg-success'))
            <div class="alert-success"> <b>{{ Session::get('msg-success') }}</b> </div>
            @endif
        </div>
    </div>
    @foreach ($pack as $item)
        <div class="col-lg-4">
            <div class="card card-secondary">
                <div class="card-header ">
                    <h3 class="card-title">Plan {{ $item->titre }}</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center "> <b class="text-orange text-lg mr-2">{{ $item->prix }}</b>  Fcfa </li>
                    <li class="list-group-item">Voir le titre des offres</li>
                    <li class="list-group-item">Ne peut pas telecharger les offres</li>
                    <li class="list-group-item">Ne peut pas filtrer les offres</li>
                    <li class="list-group-item">Ne peut parametrer son compte</li>
                    <li class="list-group-item">Ne recoit pas des notifications email</li>
                </ul>
                <div class="card-body bg-navy text-center">
                    <a href="{{ route('admin.pack.edit', $item->id) }}" class="card-link">Changer le Prix</a>
                </div>
            </div>
        </div>
    @endforeach
</div>


@endsection

@section('code')

@endsection
