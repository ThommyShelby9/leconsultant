<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerte Personnalisée</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
<div class="container" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
<img src="https://leconsultant.bj/assets/img/Logoconsultant%201.png" alt="Image Description" class="img-fluid mb-4">

        <h1 class="text-center" style="color: #007bff;">Votre Alerte Personnalisée</h1>

        <p class="lead">Voici les types de marché qui vous intéressent :</p>
        <ul class="list-group mb-4">
            @foreach ($type_marches as $marche)
                <li class="list-group-item">{{ $marche->title }}</li>
            @endforeach
        </ul>

        <p class="lead">Voici les types d'autorité contractante qui vous intéressent :</p>
        <ul class="list-group mb-4">
            @foreach ($categories_ac as $categorie)
                <li class="list-group-item">{{ $categorie->name }}</li>
            @endforeach
        </ul>

        <p class="text-center" style="color: #6c757d;">Merci de rester à l'écoute pour les prochaines offres correspondant à vos critères.</p>
        
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Voir plus de détails</a>
        </div>

        <p class="text-center mt-4" style="color: #6c757d;">© {{ date('Y') }} LeConsultant. Tous droits réservés.</p>
    </div>
</body>
</html>
