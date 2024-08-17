@extends('layout.adminLayout.template')

@section('titre-site')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>

<title>Leconsultant| Dashboard</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Tableaux de bord</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{  route('admin.home')}}">Acceuil</a></li>
            <li class="breadcrumb-item active">Tabelau de bord</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$client}}</h3>

                <p>Clients</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('admin.client.list') }}" class="small-box-footer">Voir la liste <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $offre }}<!--sup style="font-size: 20px">%</sup--></h3>

                <p>Offres publiées</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('admin.offre.list') }}" class="small-box-footer">Voir la liste <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $formation }}</h3>

                <p>Formations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('admin.formation.list') }}" class="small-box-footer">Voir la liste <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $colab }}</h3>
                <p>Collaborateurs</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('admin.colab.list') }}" class="small-box-footer">Voir la liste <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-6">
        <canvas id="myChart" width="400" height=""></canvas>
    </div>

    <div class="col-lg-6">
        <canvas id="myChart2" width="400" height=""></canvas>
    </div>

    <!--div class="col-lg-6">
        <div class="card card-navy">
            <div class="card-header border-0">
                <h3 class="card-title">Les Transactions</h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Another Product
                            </td>
                            <td>$29 USD</td>
                            <td>
                                <small class="text-warning mr-1">
                                    <i class="fas fa-arrow-down"></i>
                                    0.5%
                                </small>
                                123,234 Sold
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Amazing Product
                            </td>
                            <td>$1,230 USD</td>
                            <td>
                                <small class="text-danger mr-1">
                                    <i class="fas fa-arrow-down"></i>
                                    3%
                                </small>
                                198 Sold
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Perfect Item
                                <span class="badge bg-danger">NEW</span>
                            </td>
                            <td>$199 USD</td>
                            <td>
                                <small class="text-success mr-1">
                                    <i class="fas fa-arrow-up"></i>
                                    63%
                                </small>
                                87 Sold
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Perfect Item
                                <span class="badge bg-danger">NEW</span>
                            </td>
                            <td>$199 USD</td>
                            <td>
                                <small class="text-success mr-1">
                                    <i class="fas fa-arrow-up"></i>
                                    63%
                                </small>
                                87 Sold
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Historique des collabos</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Popularity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="badge badge-danger">Delivered</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div>
        </div>
    </div-->

</div>
@endsection

@section('code')


<script>

    var json_data = <?php echo $stat1; ?>; //Prendre la var du controller
    var json_data2 = <?php echo $stat2; ?>; //Prendre la var du controller

    var result = [];
    var les_titres = [];
    var les_donnees = [];

    var result2 = [];
    var les_titres2 = [];
    var les_donnees2 = [];


    for(var i in json_data){

        result.push([i, json_data [i]]); //console.log(result[i][1]['titre']);
        les_titres.push(result[i][1]['titre'] );
        les_donnees.push(result[i][1]['nombre'] );

    }

    for(var i in json_data2){

        result2.push([i, json_data2 [i]]); console.log(result2[i][1]['typeActor']);
        if ( result2[i][1]['typeActor'] == 1){
            les_titres2.push("Personne Physique" );
        }else{
            les_titres2.push("Personne Morale" );
        }
        
        les_donnees2.push(result2[i][1]['nombre'] );

    }

    

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar'  ,
        data: {
            labels: les_titres,
            datasets: [{
                label: "# Nbre d'Abonnements",
                data: les_donnees,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 127, 39, 0.2)',
                    'rgba(136, 0, 21, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(136, 0, 21, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx2 = document.getElementById('myChart2').getContext('2d');
    const myChart2 = new Chart(ctx2, {
        type:'pie'  ,
        data: {
            labels: les_titres2,
            datasets: [{
                label: "",
                data: les_donnees2,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 127, 39, 0.2)',
                    'rgba(136, 0, 21, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(136, 0, 21, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
@endsection
