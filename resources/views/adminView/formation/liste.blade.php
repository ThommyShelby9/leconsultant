@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Formation</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Voir les formations</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.formation.list') }}">Les formations</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-12 mb-4">
        <a href="{{Route('admin.formation.new')}}">
            <button class="btn btn-primary px-3">Publier une formation</button>
        </a>
    </div>
    <div class="col-lg-12 mt-3">
        @if(Session::get('msg-success'))
        <div class="alert">
            <div class="alert alert-success" role="alert">
                <strong>{{ Session::get('msg-success') }}</strong>
            </div>
        </div>
        @endif

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
                            <th>Niveau</th>
                            <th>Titre</th>
                            <th>prix</th>
                            <th>Durée</th>
                            <th>1ère Séance</th>
                            <th>Date Exp.</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($formations as $item)
                        <tr>
                            <td>{{ $item->niveau }}</td>
                            <td>{{ $item->titre }}</td>
                            <td>{{ $item->prix. " fcfa" }}</td>
                            <td>{{ $item->dureeNbre." ".$item->dureeMode }}</td>
                            <td>{{ $item->firstDate." à ".$item->firstTime}}</td>
                            <td>{{ $item->dateExpiration }}</td>

                            <td>
                                <a href="{{ Route('admin.formation.participant', $item->id ) }}">
                                    <button title="Voir les participants"  class="btn btn-success">
                                        <i class="fa-solid fa-handshake"></i>
                                    </button>
                                </a>

                                <a href="{{ Route('admin.formation.see', $item->id ) }}">
                                    <button title="Details" class="btn btn-warning">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>

                                <a href="{{ Route('admin.formation.edit', $item->id ) }}">
                                    <button title="Modifier" class="btn btn-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                 </a>
                                <!--button class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button-->
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
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
