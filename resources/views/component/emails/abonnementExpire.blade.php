<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Abonnement Expire</title>
    @include('includes.adminLink.cssLink')

    <style>
        .label{
            color: black;
            font-size: 25px;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        .presentation{
            font-size: 25px;
            margin-top: 25px;
            margin-bottom: 5px
        }
        .pied{
            margin-top:35px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="container-fluid" >

    <div class="container">
        <div class="row">
            <div class="col-4">
                <img src="{{ asset('assets/img/Logoconsultant%201.png')}}" alt="" class="">
            </div>
            <div class="col-4"></div>
            <div class="col-4"></div>
        </div>
        <div class="row">
            <div class="col-12 bg-dark text-center text-white ">
               <h3 class="py-4" > NOTIFICATION D'OFFRE</h3>
            </div>
        </div>
        <div class="row presentation ">
            <div class="col-12">
                Bonjour {{ $data['nom'] }} , Votre abonnement est venu expiration. Vous etes repasser en mode gratuit.
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
               <p class="text-primary text-justify"  style="font-size: 35px " >
                Merci pour votre confiance.
               </p>
            </div>
        </div>

        <div class="row pied ">
            <div class="col-12 text-center">
                @leconsultant - DRWINTECH BENIN - 2022
            </div>
        </div>
    </div>
</body>
</html>

