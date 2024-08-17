@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Collaborateurs</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Liste des collaborateurs</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.colab.list') }}">Collaborateur</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ Route('admin.colab.new') }}">
            <button class="btn btn-primary px-3">Ajouter un collaborateur</button>
        </a>
    </div>
    <div class="col-12 mt-4">
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
                <h3 class="card-title">Tous les administrateurs</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Pseudo</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                                @switch($item->role)
                                    @case(1)
                                        <span class="badge bg-primary px-3">Tous les droits</span>
                                        @break
                                    @case(2)
                                        <span class="badge bg-warning px-3">Redacteur</span>
                                        @break
                                    @case(3)
                                        <span class="badge bg-indigo px-3">Gerer le site</span>
                                        @break
                                    @case(4)
                                        <span class="badge bg-orange px-3">Gerer les formations</span>
                                        @break
                                    @default

                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.colab.edit',$item->id) }}">
                                    <button title="Modifier" class="btn btn-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </a>
                                @if($item->isActif == true)
                                    <a href="{{ route('admin.colab.block',$item->id) }}" onclick="return confirm('Voulez vous-vraiment bloquer ce collaborateur ?')">
                                        <button title="Bannir" class="btn btn-danger">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </a>
                                @elseif($item->isActif == false)
                                    <a href="{{ route('admin.colab.unblock',$item->id) }}" onclick="return confirm('Voulez vous-vraiment débloquer ce collaborateur ?')">
                                        <button title="Debloquer" class="btn btn-success">
                                            <i class="fa-solid fa-lock-open"></i>
                                        </button>
                                    </a>
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
