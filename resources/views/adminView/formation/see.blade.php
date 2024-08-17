@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Formation</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modifier un appel d'offre</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.formation.list') }}">Les formations</a></li>
            <li class="breadcrumb-item active">Voir en détails</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-md-12">
        <section class="content">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Projects Detail</h3>

                    <div class="card-tools">
                        <a href="{{ Route('admin.formation.participant', $formation->id ) }}">
                            <button title="Voir les particpants à cette formation" class="btn btn-success">
                                <i class="fa-solid fa-handshake"></i>
                            </button>
                        </a>

                        <a href="{{ Route('admin.formation.edit', $formation->id ) }}">
                            <button title="Modifier cette formation" type="button" class="btn btn-warning">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </a>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <h3 class="text-primary"><i class="fas fa-paint-brush mr-4"></i> {{$formation->titre }}</h3>
                            <!--p class="text-muted">Raw denim you probably haven't heard of them jean shorts Austin.
                                Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater
                                eu banh mi, qui irure terr.</p-->
                            <br>

                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="text-muted">
                                        <p class="text-md">Niveau
                                            <b class="d-block">
                                                {{$formation->niveau}}
                                            </b>
                                        </p>
                                        <p class="text-md">Durée de la formation
                                            <b class="d-block">{{$formation->dureeNbre." ".$formation->dureeMode}}</b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="text-muted">
                                        <p class="text-md">Premiere séance est pour :
                                            <b class="d-block">
                                                {{$formation->firstDate." à ".$formation->firstTime}}</b>
                                        </p>
                                        <p class="text-md">Nombre de Place
                                            <b class="d-block"> {{$formation->nbrePlace}}</b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="text-muted">
                                        <p class="text-md">COnférencier
                                            <b class="d-block"> {{$formation->confName}}</b>
                                            {{$formation->confPost}}
                                        </p>
                                        <p class="text-md">Date d'expiration des tickets
                                            <b class="d-block"> {{$formation->dateExpiration}}</b>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nbre de Personne
                                                intéressée</span>
                                            <span class="info-box-number text-center text-muted mb-0">2300</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nombre de Place de Prise
                                                ( <span class="text-success">Payé</span> )</span>
                                            <span class="info-box-number text-center text-muted mb-0">2000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nombre de Place de Prise
                                                ( <span class="text-success">Payé</span> )</span>
                                            <span class="info-box-number text-center text-muted mb-0">2000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-navy">
                                    <div class="card-header d-flex p-0">
                                        <h3 class="card-title p-3"></h3>
                                        <ul class="nav nav-pills ml-auto p-2">
                                            <li class="nav-item"><a class="nav-link active" href="#tab_1"
                                                    data-toggle="tab">Description</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Contenu de
                                                    la formation</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="tab_1">
                                                <div class="row">
                                                    <div class="col-lg-12">{{$formation->description}}</div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="tab_2">
                                                <div class="row">
                                                    <div class="col-lg-12"><?php echo html_entity_decode( $formation->contenu )  ?></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>


        </section>

    </div>
</div>
@endsection

@section('code')

@endsection
