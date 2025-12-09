# 🔒 Politique de Sécurité

## Versions Supportées

Nous supportons activement les versions suivantes avec les mises à jour de sécurité :

| Version | Supportée          |
| ------- | ------------------ |
| SUPERCAR | :white_check_mark: |
| 2.1.x   | :white_check_mark: |
| 2.0.x   | :white_check_mark: |
| < 2.0   | :x:                |

## Signaler une Vulnérabilité

Si vous découvrez une vulnérabilité de sécurité dans BrickPHP, aidez-nous en la signalant de manière responsable.

### Comment Signaler

**Veuillez NE PAS signaler les vulnérabilités de sécurité via les issues publiques GitHub.**

Signalez plutôt les vulnérabilités de sécurité par email :
- **Email** : security@brickphp.dev (créez cet email ou utilisez votre email personnel)
- **Sujet** : [SECURITY] Rapport de Vulnérabilité - BrickPHP

### Que Inclure

Veuillez inclure les informations suivantes dans votre rapport :

1. **Description** : Une description claire de la vulnérabilité
2. **Étapes de Reproduction** : Étapes détaillées pour reproduire le problème
3. **Impact** : Impact potentiel et sévérité de la vulnérabilité
4. **Versions Affectées** : Quelles versions sont affectées
5. **Atténuation** : Toutes corrections ou contournements suggérés

### Notre Processus

1. **Accusé de Réception** : Nous accuserons réception de votre rapport dans les 48 heures
2. **Investigation** : Nous enquêterons sur le problème et déterminerons sa sévérité
3. **Développement du Correctif** : Nous développerons et testerons un correctif
4. **Divulgation** : Nous coordonnerons la divulgation avec vous
5. **Publication** : Nous publierons le correctif et l'avis de sécurité

### Directives

- Veuillez accorder un délai raisonnable pour que nous répondions et corrigions le problème
- Veuillez éviter d'accéder ou de modifier les données utilisateur
- Veuillez garder la vulnérabilité confidentielle jusqu'à ce que nous ayons publié un correctif
- Nous vous créditerons (si souhaité) dans notre avis de sécurité

## Bonnes Pratiques de Sécurité

### Développement
- Utilisez toujours `declare(strict_types=1)`
- Validez toutes les entrées utilisateur
- Échappez la sortie avec `e()` ou Twig auto-échappement
- Utilisez des requêtes préparées pour toutes les interactions DB

### Configuration
- Ne stockez jamais les clés secrètes dans le code
- Utilisez des variables d'environnement pour la configuration sensible
- Activez HTTPS en production
- Utilisez des certificats SSL valides

### Sessions & Authentification
- Régénérez l'ID de session après connexion
- Utilisez des tokens CSRF sur tous les formulaires
- Implémentez une expiration de session appropriée
- Utilisez des mots de passe forts avec bcrypt

### Headers de Sécurité
```php
// Dans votre configuration serveur
Header: X-Frame-Options: DENY
Header: X-Content-Type-Options: nosniff
Header: X-XSS-Protection: 1; mode=block
Header: Strict-Transport-Security: max-age=31536000
```

### Mises à Jour
- Gardez PHP à jour (version 8.1+ recommandée)
- Mettez à jour régulièrement les dépendances
- Surveillez les avis de sécurité des dépendances
- Testez les mises à jour en environnement de développement

## Contact

Pour toute question de sécurité :
- **Email** : security@brickphp.dev
- **PGP Key** : Disponible sur demande
- **Response Time** : < 48 heures

---

**BrickPHP s'engage à maintenir un environnement sécurisé pour tous les utilisateurs.** 🛡️
