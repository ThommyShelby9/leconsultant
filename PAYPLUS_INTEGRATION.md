# 💳 Guide d'intégration PayPlus - LeConsultant

## 📋 Vue d'ensemble

KKiaPay a été remplacé par PayPlus comme système de paiement pour les abonnements et formations sur LeConsultant.

---

## ✅ Fichiers créés

### 1. Configuration
- `config/payplus.php` - Configuration PayPlus
- Ajout des variables d'environnement dans `.env`

### 2. Base de données
- `database/migrations/2026_02_16_114456_create_payment_transactions_table.php` - Table des transactions
- `app/Models/PaymentTransaction.php` - Modèle des transactions

### 3. Services et Contrôleurs
- `app/Services/PaymentService.php` - Service principal PayPlus
- `app/Http/Controllers/PaymentCallbackController.php` - Gestion des callbacks
- `app/Http/Controllers/user/AbonnementController.php` - Modifié pour utiliser PayPlus

### 4. Routes
- `routes/payment.php` - Routes pour callbacks PayPlus
- Modification de `app/Providers/RouteServiceProvider.php` - Enregistrement des routes

---

## 🔧 Configuration requise

### 1. Exécuter les migrations

```bash
php artisan migrate
```

Cela va créer la table `payment_transactions`.

### 2. Configurer les variables d'environnement

Éditez votre fichier `.env` et renseignez vos clés API PayPlus :

```bash
# Configuration PayPlus
PAYPLUS_BASE_URL=https://app.payplus.africa
PAYPLUS_API_KEY=votre_api_key_ici        # À remplacer
PAYPLUS_API_TOKEN=votre_api_token_jwt_ici # À remplacer
PAYPLUS_STORE_NAME=LeConsultant

# Limites de paiement (en FCFA)
PAYPLUS_MIN_SUBSCRIPTION=1000
PAYPLUS_MAX_SUBSCRIPTION=100000
PAYPLUS_MIN_FORMATION=1000
PAYPLUS_MAX_FORMATION=500000
```

### 3. Obtenir vos clés API PayPlus

1. Créez un compte marchand sur [https://app.payplus.africa](https://app.payplus.africa)
2. Allez dans **Paramètres** > **Développeurs** > **Clés API**
3. Copiez :
   - **API Key** (`PAYPLUS_API_KEY`)
   - **API Token JWT** (`PAYPLUS_API_TOKEN`)
4. Ajoutez ces clés dans votre fichier `.env`

### 4. Configurer les URLs de callback

Dans le dashboard PayPlus, ajoutez votre URL de callback :

```
https://votre-domaine.com/payment/callback/{type}/{transaction}
```

⚠️ **Important** : Remplacez `votre-domaine.com` par votre vrai domaine.

---

## 🚀 Utilisation

### Initier un paiement d'abonnement

Dans votre vue, créez un formulaire qui envoie vers la nouvelle route :

```html
<form action="{{ route('subscription.initiate', ['packId' => $pack->id]) }}" method="POST">
    @csrf
    <input type="tel" name="phone" placeholder="Ex: 97000000" required>
    <button type="submit">Souscrire</button>
</form>
```

### Routes disponibles

```php
// Initier un paiement d'abonnement
POST /subscription/initiate/{packId}

// Callback PayPlus (automatique)
POST /payment/callback/{type}/{transaction}

// Vérifier le statut d'une transaction
GET /payment/status/{transaction}

// Test du callback endpoint
GET /payment/callback/test
```

---

## 🔄 Flux de paiement

```
1. Utilisateur clique sur "Souscrire"
   ↓
2. AbonnementController->initiateSubscription()
   ↓
3. PaymentService crée une transaction en BDD (PENDING)
   ↓
4. Appel API PayPlus pour créer une facture
   ↓
5. Redirection vers la page PayPlus
   ↓
6. Utilisateur choisit son opérateur et paie via Mobile Money
   ↓
7. PayPlus envoie un callback à /payment/callback/{type}/{transaction}
   ↓
8. PaymentCallbackController traite le callback
   ↓
9. Si paiement réussi :
   - Transaction marquée comme COMPLETED
   - Abonnement créé et activé
   - Utilisateur redirigé vers /compte?payment=success
```

---

## 📊 Base de données

### Table `payment_transactions`

| Champ | Type | Description |
|-------|------|-------------|
| `id` | UUID | ID unique de la transaction |
| `user_id` | BigInt | ID de l'utilisateur |
| `type` | String | "subscription" ou "formation" |
| `amount` | Decimal | Montant en FCFA |
| `status` | String | PENDING, COMPLETED, FAILED, CANCELLED |
| `reference` | String | Référence externe (S-timestamp-uuid) |
| `payplus_token` | String | Token PayPlus pour vérification |
| `related_id` | BigInt | ID du pack ou formation |
| `customer_phone` | String | Numéro de téléphone |
| `gateway_response` | Text | Réponse JSON de PayPlus |
| `completed_at` | Timestamp | Date de complétion |
| `expires_at` | Timestamp | Date d'expiration (1h après création) |

---

## 🧪 Tests

### 1. Tester l'accessibilité du callback

```bash
curl https://votre-domaine.com/payment/callback/test
```

Réponse attendue :
```json
{
    "success": true,
    "message": "Callback endpoint accessible",
    "timestamp": "2026-02-16 12:00:00"
}
```

### 2. Tester un paiement (Mode Sandbox)

Si PayPlus propose un mode sandbox, activez-le en modifiant :
```bash
PAYPLUS_BASE_URL=https://sandbox.payplus.africa  # URL sandbox
```

### 3. Vérifier une transaction

```bash
curl https://votre-domaine.com/payment/status/{transaction_id}
```

---

## ❗ Problèmes courants

### 1. **Callback non reçu**

**Symptôme** : Paiement effectué mais wallet non crédité

**Causes possibles** :
- URL de callback mal configurée dans PayPlus
- Serveur inaccessible depuis l'extérieur
- Firewall bloquant les requêtes de PayPlus

**Solution** :
1. Vérifier que votre URL est accessible publiquement
2. Tester le endpoint : `/payment/callback/test`
3. Vérifier les logs : `storage/logs/laravel.log`

### 2. **Erreur 401 (Authentification échouée)**

**Cause** : API Key ou Token incorrect

**Solution** :
1. Vérifier les clés dans `.env`
2. S'assurer qu'elles sont bien copiées depuis le dashboard PayPlus
3. Effacer le cache : `php artisan config:clear`

### 3. **Transaction bloquée en PENDING**

**Cause** : Callback non reçu par le serveur

**Solution temporaire** :
Vérifier manuellement la transaction :
```php
php artisan tinker
>>> $transaction = PaymentTransaction::find('uuid-de-la-transaction');
>>> $paymentService = app(PaymentService::class);
>>> $paymentService->checkTransactionStatus($transaction->id);
```

---

## 📝 Prochaines étapes

### À faire par le développeur :

1. ✅ Exécuter les migrations
2. ✅ Configurer les variables `.env` avec les vraies clés PayPlus
3. ⬜ Modifier les vues pour utiliser le nouveau système (voir section suivante)
4. ⬜ Tester le paiement en mode sandbox
5. ⬜ Mettre en production

### Vues à modifier

Les fichiers suivants contiennent encore des références à KKiaPay et doivent être mis à jour :

- `resources/views/welcome.blade.php`
- `resources/views/userView/alerte/create.blade.php`
- `resources/views/userView/account/mesA.blade.php`
- `resources/views/formationItem.blade.php`
- `resources/views/component/packs.blade.php`

**Exemple de remplacement** :

Ancien (KKiaPay) :
```html
<kkiapay-widget
    amount="1490"
    key="2a9363b7c6c78cf76717f8895a561990f39bac73"
    ...
</kkiapay-widget>
```

Nouveau (PayPlus) :
```html
<form action="{{ route('subscription.initiate', ['packId' => $pack->id]) }}" method="POST">
    @csrf
    <div>
        <input type="tel" name="phone" placeholder="Numéro : 97000000" required>
    </div>
    <button type="submit">Souscrire - {{ $pack->montant }} FCFA</button>
</form>
```

---

## 📞 Support

Pour toute question sur PayPlus :
- Documentation : [https://payplus.africa/docs](https://payplus.africa/docs)
- Support PayPlus : support@payplus.africa

---

**Date de migration** : 16 février 2026
**Version** : 1.0
