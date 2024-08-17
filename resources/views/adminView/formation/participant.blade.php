@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Formation</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Les participants à cette formation</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.formation.list') }}">Les formations</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.formation.see', $formation->id) }}">Voir en details</a></li>
            <li class="breadcrumb-item active">Les participants</li>
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
                    <h3 class="card-title">Les participants à cette formation</h3>

                    <div class="card-tools">
                        <a href="{{ Route('admin.formation.see', $formation->id ) }}">
                            <button title="Details Formation" type="button" class="btn btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </a>

                        <a href="{{ Route('admin.formation.edit', $formation->id ) }}">
                            <button title="Modifier Formation" type="button" class="btn btn-warning">
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
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nombre de place</span>
                                            <span class="info-box-number text-center text-muted mb-0">
                                                <span class="badge badge-success text-lg px-4">{{$formation->nbrePlace}}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Premiere séance est pour :</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{$formation->firstDate." à ".$formation->firstTime}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Date d'expiration des places :</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{$formation->dateExpiration}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Prix de la formation
                                                ( <span class="text-success">Payé</span> )</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{$formation->prix." Fcfa "}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nombre de Place de Prise
                                                ( <span class="text-success">Payé</span> )</span>
                                            <span class="info-box-number text-center text-muted mb-0">
                                                <span class="badge badge-success text-lg px-4">{{ $nbreTicket }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nombre de Place restante
                                                intéressée</span>
                                            <span class="info-box-number text-center text-muted mb-0">
                                                <span class="badge border border-success text-lg px-4">{{$formation->nbrePlace - $nbreTicket }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card card-navy">
                                <div class="card-header">
                                    <h3 class="card-title">Voir la liste des toutes les formations</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nom & Prenoms</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Date d'achat</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($participants as $item)
                                            <tr>
                                                <td>{{ $item->nom." ".$item->prenoms }}</td>
                                                <td>{{ $item->telephone }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->dateTicket }}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
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
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },
        });
    });

</script>
@endsection

