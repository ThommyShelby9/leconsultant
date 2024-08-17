@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Offres</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">AJouter une nouvelle autorité contractante</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.offre.list') }}">Les offres</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-12 mb-4">
        <a href="{{Route('admin.offre.new')}}">
            <button class="btn btn-primary px-3">Publier un appel d'offre</button>
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
            <div class="card-header ">
                <h3 class="card-title">Liste des offres publiées</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Titre</th>
                            <th>Categorie</th>
                            <th>Autorite C.</th>
                            <th>Date Pub.</th>
                            <th>Date Exp.</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offres as $item)
                        <tr>
                            <td>{{$item->reference}}</td>
                            <td>
                                {{ Str::substr($item->titre , 0, 60).' [...]'  }}
                            </td>
                            <td>{{$item->categTitle}}</td>
                            <td>
                                {{ Str::substr($item->autName, 0, 25).' [...]'  }} <br> <b>{{$item->autAbre}}</b>
                            </td>
                            <td>
                                {{ $item->datePublication }}
                            </td>
                            <td> {{$item->dateExpiration}}</td>
                            <td>

                                <a href="{{ Route('admin.offre.see', $item->id) }}">
                                    <button class="btn btn-warning" title="Voir une offre"   >
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>
                                <a href="{{ Route('admin.offre.edit', $item->id) }}">
                                    <button class="btn btn-primary" title="Modifier une offre" >
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </a>

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
