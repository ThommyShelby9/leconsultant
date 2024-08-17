@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Offres</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modifier un appel d'offre</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.offre.list') }}">Les offres</a></li>
            <li class="breadcrumb-item active">Voir</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-md-12">
        <section class="content">
            @foreach ($offre as $item)
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Projects Detail</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-primary">
                                        <i class="fa-solid fa-file-lines mr-3"></i>
                                        {{ $item->titre }}
                                    </h3>
                                    <!--p class="text-muted">Raw denim you probably haven't heard of them jean shorts Austin.
                                        Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater
                                        eu banh mi, qui irure terr.</p-->
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Catégorie</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{  $item->categTitle }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Autorité contractante
                                                concernée</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ $item->autName }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Directions/Serices</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ $item->autName }}<span>
                                                </span></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-muted">
                                        <p class="text-sm">Date de publication :
                                          <b class="d-block"> {{ $item->datePublication }} </b>
                                        </p>
                                        <p class="text-sm">Date d'expiration de l'offre :
                                          <b class="d-block">{{ $item->dateExpiration }} </b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-muted">
                                        <p class="text-sm">Date d'ouverture de l'offre :
                                          <b class="d-block">{{ $item->dateOuverture }} </b>
                                        </p>
                                        <p class="text-sm">Heure d'ouverture de l'offre :
                                          <b class="d-block">{{ $item->heureOuverture }} </b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-muted">
                                        <p class="text-sm">Fichier numérique de l'offre : <br>
                                            @if(file_exists($item->fichier))
                                            <a class="d-block" href="{{ asset($item->fichier) }}">Telecharger le fichier</a>
                                            @else
                                            <span><b>Le fichier n'existe pas</b> </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-muted">
                                        <p class="text-sm">Actions :
                                          <b class="d-block">
                                            <a href="{{ Route('admin.offre.edit', $item->id) }}" class="btn btn-md btn-primary">Modifier</a>
                                            <!--a href="#" class="btn btn-md btn-danger">Supprimer</a-->
                                          </b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @endforeach


        </section>

    </div>
</div>
@endsection

@section('code')

@endsection
