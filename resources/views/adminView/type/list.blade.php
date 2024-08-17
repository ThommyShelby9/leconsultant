@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Type AC</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Autres </h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.type.list') }}">Type de Directions</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-12 mt-4">
        @if(Session::get('msg-success'))
        <div class="alert">
            <div class="alert alert-success" role="alert">
                <strong>{{ Session::get('msg-success') }}</strong>
            </div>
        </div>
        @endif
    </div>
    <div class="col-lg-5">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Enregistrer une donnée</h3>
            </div>

            <form role="form" method="POST" action="{{ Route('admin.type.save') }}" >

                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Type de donnée</label>
                        <select name="useFor" id="" class="form-control">
                            <option value="activite">Domaine d'activite</option>
                            <option value="marche">Type de marché</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Titre</label>
                        <input type="text" class="form-control" name="titre" value="{{ @old('titre') }}" placeholder="">
                        @error('titre')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>

            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Toutes les données</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Pour</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $item)
                        <tr>
                            <td>{{$item->title}}</td>
                            <td>
                                @switch($item->useFor)
                                @case('activite')
                                <span class="badge bg-warning px-3">Domaine d'activité</span>
                                @break
                                @case('marche')
                                <span class="badge bg-info px-3">Type d'offre</span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ Route('admin.type.edit',$item->id) }}">
                                    <button title="Modifier un type" class="btn btn-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </a>

                                @if($item->isDel == false)
                                <button title="Supprimer un type" class="btn btn-danger">
                                    <i class="fa-solid fa-ban"></i>
                                </button>
                                @elseif($item->isDel == true)
                                <button class="btn btn-success">
                                    <i class="fa-solid fa-lock-open"></i>
                                </button>
                                @endif
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
