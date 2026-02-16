# 🐛 Debug PayPlus - Problème de bypass de paiement

## 📋 Problème identifié

**Symptôme :**
- Une erreur s'affiche brièvement ("rapidement") puis disparaît
- L'utilisateur peut accéder au site sans avoir payé

**Cause racine :**
1. L'utilisateur paie sur PayPlus
2. PayPlus le redirige immédiatement vers `/compte?payment=success`
3. Le **callback PayPlus** (qui active l'abonnement) arrive de manière **asynchrone** quelques secondes après
4. L'utilisateur arrive donc sur `/compte` **AVANT** que son abonnement soit activé
5. Il peut ainsi accéder au site sans abonnement valide

---

## ✅ Solutions implémentées

### 1. **Page d'attente intermédiaire**

Au lieu de rediriger directement vers `/compte`, PayPlus redirige maintenant vers :
```
/payment/waiting/{transaction_id}
```

Cette page :
- Affiche un spinner de chargement
- Vérifie automatiquement le statut de la transaction toutes les 5 secondes
- Redirige vers `/compte` une fois le paiement confirmé
- Gère les cas d'échec et de timeout

**Fichiers modifiés :**
- `config/payplus.php` - Ligne 43 : `return_url` modifié
- `app/Services/PaymentService.php` - Ligne 127 : utilisation de `route('payment.waiting')`
- `routes/payment.php` - Ajout de la route `/payment/waiting/{transaction}`
- `app/Http/Controllers/PaymentCallbackController.php` - Ajout méthode `waitingPage()`
- `resources/views/payment/waiting.blade.php` - **NOUVELLE VUE**

---

### 2. **Logs détaillés ajoutés partout**

Des logs avec émojis pour faciliter le débogage dans tous les fichiers clés :

#### **AbonnementController.php**
```
🎫 User initiating subscription
💵 Pack details
✅ Payment initiation successful
❌ Payment initiation failed
❌ Exception in subscription initiation
```

#### **PaymentService.php**
```
🔄 Processing payment callback
📦 Transaction found
💰 Payment marked as completed by PayPlus
✅ Payment completed and saved to DB
⚠️ Payment NOT completed
❌ Payment marked as failed
❌ Callback processing error
```

#### **PaymentCallbackController.php**
```
🔔 PayPlus callback received
✅ Callback processed successfully
🎯 Transaction completed, activating service
⚠️ Transaction not completed after callback
❌ Callback processing failed
🚀 Starting subscription activation
📅 Subscription dates calculated
✅ Subscription activated successfully
❌ Subscription activation failed
📄 User on waiting page
❌ Transaction not found in waiting page
```

#### **CompteController.php**
```
👤 User accessing account page
📋 User subscription status
```

---

## 🧪 Comment tester

### 1. **Lire les logs en temps réel**

Ouvrez un terminal et exécutez :

```bash
cd leconsultant
tail -f storage/logs/laravel.log
```

### 2. **Effectuer un paiement de test**

1. Connectez-vous au site
2. Allez sur la page d'abonnements
3. Choisissez un pack et cliquez sur "Souscrire"
4. Entrez votre numéro de téléphone
5. Suivez le processus PayPlus

### 3. **Observer les logs**

Vous devriez voir dans l'ordre :

```
[INFO] 🎫 User initiating subscription
[INFO] 💵 Pack details
[INFO] 📦 Transaction created
[INFO] ✅ Payment initiation successful
[INFO] 📄 User on waiting page
[INFO] 🔔 PayPlus callback received
[INFO] 🔄 Processing payment callback
[INFO] 💰 Payment marked as completed by PayPlus
[INFO] ✅ Payment completed and saved to DB
[INFO] 🎯 Transaction completed, activating service
[INFO] 🚀 Starting subscription activation
[INFO] 📅 Subscription dates calculated
[INFO] ✅ Subscription activated successfully
[INFO] 👤 User accessing account page
[INFO] 📋 User subscription status: has_active_subscription = YES
```

---

## 🔍 Points de vérification

### ✅ **Le callback arrive-t-il ?**

Cherchez dans les logs :
```bash
grep "🔔 PayPlus callback received" storage/logs/laravel.log
```

Si vous ne voyez RIEN → Le callback n'arrive pas sur le serveur
- Vérifiez que l'URL est accessible depuis l'extérieur
- Vérifiez le firewall
- Testez : `curl https://votre-domaine.com/payment/callback/test`

### ✅ **Le paiement est-il marqué comme complété ?**

Cherchez :
```bash
grep "💰 Payment marked as completed" storage/logs/laravel.log
```

Si vous voyez "⚠️ Payment NOT completed" → PayPlus envoie un statut différent de "completed"
- Vérifiez la réponse complète dans les logs

### ✅ **L'abonnement est-il activé ?**

Cherchez :
```bash
grep "✅ Subscription activated successfully" storage/logs/laravel.log
```

Si vous voyez "❌ Subscription activation failed" → Erreur lors de la création en BDD
- Vérifiez les colonnes de la table `abonnements`
- Vérifiez les erreurs dans les logs

### ✅ **L'utilisateur a-t-il un abonnement actif ?**

Vérifiez dans la base de données :
```sql
SELECT * FROM abonnements
WHERE idUser = [USER_ID]
ORDER BY id DESC
LIMIT 1;
```

---

## 🚨 Scénarios de debug

### Scénario 1 : "Le callback n'arrive jamais"

**Symptômes :**
- Pas de log "🔔 PayPlus callback received"
- Transaction reste en PENDING
- Page d'attente timeout après 5 minutes

**Solutions :**
1. Vérifier que le serveur est accessible depuis l'extérieur
2. Tester l'endpoint : `curl https://votre-domaine.com/payment/callback/test`
3. Vérifier la configuration DNS/SSL
4. Vérifier les règles de firewall

### Scénario 2 : "Le callback arrive mais le paiement n'est pas marqué comme complété"

**Symptômes :**
- Log "🔔 PayPlus callback received"
- Log "⚠️ Payment NOT completed"
- Transaction passe à FAILED

**Solutions :**
1. Vérifier la réponse PayPlus dans les logs (champ `description`)
2. PayPlus envoie peut-être un autre statut que "completed"
3. Consulter la documentation PayPlus pour les statuts possibles

### Scénario 3 : "Le paiement est complété mais l'abonnement n'est pas activé"

**Symptômes :**
- Log "✅ Payment completed and saved to DB"
- Log "❌ Subscription activation failed"
- Utilisateur n'a pas d'abonnement actif

**Solutions :**
1. Vérifier les erreurs dans les logs (message d'erreur complet)
2. Vérifier la structure de la table `abonnements`
3. Vérifier que les colonnes correspondent au code

### Scénario 4 : "L'utilisateur peut toujours accéder sans payer"

**Symptômes :**
- Paiement complété
- Abonnement activé
- Mais l'utilisateur accède au site sans restrictions

**Solutions :**
1. Vérifier s'il y a un middleware qui vérifie l'abonnement
2. Chercher dans le code : `grep -r "abonnement" leconsultant/app/Http/Middleware/`
3. Vérifier les routes protégées dans `routes/web.php`

---

## 📊 Commandes utiles

### Voir les logs en temps réel
```bash
tail -f storage/logs/laravel.log
```

### Voir uniquement les logs PayPlus
```bash
tail -f storage/logs/laravel.log | grep -E "🎫|💵|🔔|🔄|💰|✅|❌|🚀|📅|👤|📋"
```

### Compter les transactions en attente
```bash
php artisan tinker
>>> PaymentTransaction::where('status', 'PENDING')->count()
```

### Voir une transaction spécifique
```bash
php artisan tinker
>>> $transaction = PaymentTransaction::find('uuid-ici')
>>> $transaction->status
>>> json_decode($transaction->gateway_response, true)
```

### Vérifier manuellement le statut auprès de PayPlus
```bash
php artisan tinker
>>> $paymentService = app(\App\Services\PaymentService::class)
>>> $paymentService->checkTransactionStatus('uuid-ici')
```

### Voir les abonnements d'un utilisateur
```bash
php artisan tinker
>>> DB::table('abonnements')->where('idUser', 123)->orderBy('id', 'desc')->get()
```

---

## 🎯 Prochaines étapes

1. ✅ Tester le flux complet avec les nouveaux logs
2. ⬜ Identifier où exactement le problème se situe
3. ⬜ Ajouter un middleware pour vérifier l'abonnement actif avant d'accéder aux pages protégées
4. ⬜ Ajouter une commande artisan pour vérifier les transactions en attente (comme dans la doc WhatsPay)

---

## 📞 Support

Si le problème persiste après avoir suivi ce guide :
1. Copiez les logs pertinents
2. Notez à quelle étape le processus s'arrête
3. Vérifiez les messages d'erreur exacts

---

**Date de création :** 16 février 2026
**Dernière mise à jour :** 16 février 2026
