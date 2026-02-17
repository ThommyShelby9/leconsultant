logoPayplus
Introduction
Activer votre compte développeur
Créer une application
Intégration
Intégration PHP
Intégration Prestashop
Intégration Woocommerce
Intégration Android
Intégration avec redirection
Intégration sans redirection
Intégration avec redirectionDerniere mise à jour : 2019-06-01
 Attention!
Pour vos tests, inscrivez vous plutôt sur la plateforme de test. 

En vous inscrivant sur la plateforme de test, votre compte de test sera crédité de 100.000 Fcfa. Cela vous permettra d’éffectuer en toute aisance les tests d’intégration avant de passer en production.
Envoie de la requête
Méthode : POST
Url : https://app.payplus.africa/pay/v01/redirect/checkout-invoice/create
Headers :

Apikey: votre clé principale génénée lors de la création de l'application
Authorization: contient le mot Bearer suivi d’un espace puis du token généné lors de la création de l'application

            
Payload ( format json )

{
    "commande": {
        "invoice": {
            "items": [
                {
                    "name": "Article 1",
                    "description": "",
                    "quantity": 1,
                    "unit_price": 950,
                    "total_price": 950
                },
                {
                    "name": "Article 2",
                    "description": "",
                    "quantity": 1,
                    "unit_price": 1950,
                    "total_price": 1950
                },
            ],
            "total_amount": 1900,
            "devise": "xof",
            "description": "Description du contenu de la facture"
        },
        "store": {
            "name": "nom de votre boutique/application",
            "website_url": "url de votre site"
        },
        "actions": {
            "cancel_url": "url de d'annulation de vente",
            "return_url": "url de retour apres validation du paiement",
            "callback_url": "url de retour apres validation du paiemente"
        },
        "custom_data": {
            "rubrique_1": "valeur_de_la_rubrique_1",
            "rubrique_2": "valeur_de_la_rubrique_2"
        }
    }
}
                            
Réponse ( format json )

{
    "response_code": "contient 00 si succes. si different de 00 alors echec",
    "token":  "token de la transaction. il faut la conserver sur votre plateforme" ,
    "response_text":  "contient l'url de la page de validation de paiement (page vers laquelle vous devez rediriger le client pour qu'il procède au paiement)" ,
    "description":  "message texte décrivant le résultat de la requête" ,
    "customdata":  "contient les custom_data envoyées lors de l'envoie de la requête"  
}
                            
Vérification du statut de la requête
Méthode : POST
Url : https://app.payplus.africa/pay/v01/redirect/checkout-invoice/confirm/?invoiceToken=
Headers :

Apikey: votre clé principale génénée lors de la création de l'application
Authorization: contient le mot Bearer suivi d’un espace puis du token généné lors de la création de l'application

            
Paramètres de l’url : invoiceToken (contient le token que vous avez recu apres l’envoi de la requete)
Réponse ( format json )

{
    "response_code": "contient 00 si succes. si different de 00 alors echec",
    "token":  "token de la transaction. il faut la conserver sur votre plateforme" ,
    "response_text":  "message texte décrivant le résultat de la requête" ,
    "description":  "indique le statut de la requête. valeurs possibles : pending (transaction en attente de validation), completed (transaction validée), notcompleted (transaction annulée). ce champ est vide si response_code est different de 00" ,
    "customdata":  "contient les custom_data envoyées lors de l'envoie de la requête"  
}
                            