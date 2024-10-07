<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerte Personnalisée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f2ef;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .header img {
            width: 150px;
        }
        h1 {
            color: #0073b1;
            font-size: 24px;
            margin: 20px 0;
        }
        .lead {
            font-size: 16px;
            color: #333333;
            margin-bottom: 10px;
        }
        ul.list-group {
            list-style-type: none;
            padding-left: 0;
        }
        ul.list-group li {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        p {
            font-size: 14px;
            color: #666666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0073b1;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #005582;
        }
        .footer {
            font-size: 12px;
            color: #666666;
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="https://leconsultant.bj/assets/img/Logoconsultant%201.png" alt="Logo Consultant">
        </div>

        <h1 class="text-center">Votre Alerte Personnalisée</h1>

        <p class="lead">Voici le domaine d'activité qui vous intéresse :</p>
        <ul class="list-group">
            @foreach ($domaine_activite as $domaine)
                <li class="list-group-item">{{ $domaine->title }}</li>
            @endforeach
        </ul>

        <p class="lead">Voici les types de marché qui vous intéressent :</p>
        <ul class="list-group">
            @foreach ($type_marches as $marche)
                <li class="list-group-item">{{ $marche->title }}</li>
            @endforeach
        </ul>

        <p class="lead">Voici les types d'autorité contractante qui vous intéressent :</p>
        <ul class="list-group">
            @foreach ($categories_ac as $categorie)
                <li class="list-group-item">{{ $categorie->name }}</li>
            @endforeach
        </ul>

        <p class="text-center" style="color: #666666;">Merci de rester à l'écoute pour les prochaines offres correspondant à vos critères.</p>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn">Voir plus de détails</a>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} LeConsultant. Tous droits réservés.</p>
        </div>
    </div>

</body>
</html>
