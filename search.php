<?php
require 'vendor/autoload.php'; // Charger automatiquement les dépendances installées par Composer

use SerpApi\GoogleSearch;

$query = [
    "engine" => "google",
    "q" => "Coffee",
    "location" => "Benin",  // Vous pouvez définir la localisation si nécessaire
    "hl" => "fr",           // Langue française
    "gl" => "fr",           // Région France
    "tbm" => "nws"          // Type de recherche pour les news
];

// Remplacez 'YOUR_SERPAPI_KEY' par votre clé API SerpAPI
$search = new GoogleSearchResults('27a351758a8c62270b7dad656c728ee0c2d9ecc855b28e1eeb574008de2d4a4e');
$result = $search->get_json($query);

// Affichage des résultats organiques
if (isset($result['organic_results'])) {
    foreach ($result['organic_results'] as $news) {
        echo "Titre: " . $news['title'] . "\n";
        echo "Lien: " . $news['link'] . "\n";
        echo "Source: " . $news['source'] . "\n";
        echo "--------------------------\n";
    }
} else {
    echo "Aucun résultat trouvé.\n";
}
?>
