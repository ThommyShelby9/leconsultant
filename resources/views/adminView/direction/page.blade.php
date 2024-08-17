@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Diections AC </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Créer une Direction/Service d'une A.C</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.direction.list') }}">Directions / Services</a></li>
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-6 mt-4">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Ajouter une Direction/Service à cette A.C</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ Route('admin.direction.new.save') }}" method="POST">
                @csrf
                <input type="hidden" name="type_page" value="nodirect" >

                <div class="card-body">
                    @foreach ($info as $item)
                    <div class="form-group">
                        <label for="">Autorité contractante concernée</label>
                        <input type="hidden" name="idAuto" value="{{ $item->id  }}">
                        <input type="text" class="form-control" id="" value="{{ $item->name }}" readonly>
                    </div>
                    @endforeach


                    <div class="form-group">
                        <label for="nom">Nom de la Direction / Service</label>
                        <input type="text" class="form-control" name="nom" placeholder="Ex: Direction des ....">
                        @error('nom')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="abrev">Abreviation</label>
                        <input type="text" name="abrev" class="form-control" id="abrev" placeholder="Ex: DSI">
                        @error('abrev')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-6 mt-4">

        @if(Session::get('msg-success'))
        <div class="alert">
            <div class="alert alert-success" role="alert">
                <strong>{{ Session::get('msg-success') }}</strong>
            </div>
        </div>
        @endif

        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Liste des Directions/Services de cette A.C</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom Direction</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($directions as $item)
                        <tr>

                            <td>{{ $item->abreviation }}</td>
                            <td>{{ $item->name }}</td>
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
