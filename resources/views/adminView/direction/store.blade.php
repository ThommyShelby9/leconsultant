@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Diections AC </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Liste des Directions/Services</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.direction.list') }}">Directions / Services</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ Route('admin.direction.create') }}">
            <button class="btn btn-primary">Ajouter une Direction / Service</button>
        </a>
    </div>
    <div class="col-lg-12 mt-4">
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
                <h3 class="card-title">Liste de toutes les autorités contractantes</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Categorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($directions as $item)
                        <tr>
                            <td>
                                {{ $item->name }} <br>
                                <b>{{ $item->abreviation }}</b>
                            </td>
                            <td>
                                {{ $item->name_aut }} <br>
                                <b>{{ $item->abrev_aut }}</b>
                             </td>
                            <td> {{ $item->title }}</td>
                            <td class="text-center" >

                                <a href="{{ Route('admin.direction.edit' , $item->id ) }}">
                                    <button class="btn btn-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </a>

                                <button class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
        });
    });

</script>

@endsection
