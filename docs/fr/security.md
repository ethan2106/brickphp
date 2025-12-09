# Guide de Sécurité - BrickPHP SUPERCAR

## Introduction

La sécurité est au cœur de BrickPHP SUPERCAR. Ce guide détaille les fonctionnalités de sécurité intégrées et les meilleures pratiques.

## Protection CSRF (Cross-Site Request Forgery)

### Utilisation dans les formulaires

```twig
<form method="POST" action="/users">
    {{ csrf_field() }}
    <input type="text" name="username">
    <button type="submit">Envoyer</button>
</form>
```

### Utilisation avec AJAX

```javascript
// Dans votre layout
<meta name="csrf-token" content="{{ csrf_token() }}">

// Dans votre JavaScript
fetch('/api/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
});
```

### Middleware CSRF

```php
// routes/web.php
$router->post('/submit', 'FormController@submit')
    ->middleware(CsrfMiddleware::class);
```

## Protection XSS (Cross-Site Scripting)

### Échappement automatique

BrickPHP échappe automatiquement toutes les sorties dans les templates Twig :

```twig
{# Sécurisé par défaut #}
<p>{{ user.comment }}</p>

{# Si vous avez vraiment besoin de HTML brut (ATTENTION) #}
<p>{{ user.html_content|raw }}</p>
```

### Dans les Controllers

```php
// Les données sont automatiquement échappées
$comment = $request->post('comment');
// $comment est déjà sécurisé contre XSS
```

### Validation manuelle

```php
use BrickPHP\Security\Validator;

$safe = Validator::sanitize($userInput);
$clean = Validator::clean($dirtyHtml);
```

## Protection SQL Injection

### Requêtes préparées

**TOUJOURS** utiliser des requêtes préparées :

```php
// ❌ DANGER - Injection SQL possible
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = " . $id;

// ✅ BON - Requête préparée
$id = $request->query('id');
$user = $this->db->fetchOne(
    "SELECT * FROM users WHERE id = :id",
    [':id' => $id]
);
```

### Méthodes ORM sécurisées

```php
// Toutes ces méthodes utilisent des requêtes préparées
$user = $userModel->find($id);
$users = $userModel->where(['status' => 'active']);
$userModel->create(['name' => $name]);
$userModel->update($id, ['email' => $email]);
$userModel->delete($id);
```

## Validation des Entrées

### Règles de validation

```php
public function store(Request $request): Response
{
    $data = $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'age' => 'numeric',
        'username' => 'required|alphanumeric',
        'website' => 'url',
    ]);
    
    // $data est maintenant validé
}
```

### Règles disponibles

- `required` : Champ obligatoire
- `email` : Email valide
- `numeric` : Valeur numérique
- `alpha` : Lettres uniquement
- `alphanumeric` : Lettres et chiffres
- `url` : URL valide
- `min:X` : Longueur minimale
- `max:X` : Longueur maximale

## Headers de Sécurité

BrickPHP ajoute automatiquement des headers de sécurité à toutes les réponses :

```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Content-Security-Policy: default-src 'self'
```

## Sessions Sécurisées

Les sessions sont configurées avec des paramètres de sécurité stricts :

```php
// Configuration automatique
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_secure', '1');  // En HTTPS
ini_set('session.cookie_samesite', 'Strict');
```

## Mots de Passe

### Hashage sécurisé

```php
// Créer un hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Vérifier un mot de passe
if (password_verify($inputPassword, $storedHash)) {
    // Mot de passe correct
}
```

### Dans les Models

```php
// Le modèle User hash automatiquement les mots de passe
$userId = $userModel->createUser([
    'email' => 'user@example.com',
    'password' => 'plaintext-password', // Sera hashé automatiquement
]);

// Vérification
if ($userModel->verifyPassword($user, $inputPassword)) {
    // Authentification réussie
}
```

## Variables d'Environnement

**JAMAIS** commiter le fichier `.env` :

```bash
# .gitignore contient déjà
.env
.env.local
```

Utiliser `.env.example` comme template :

```env
# .env.example
APP_NAME=BrickPHP
APP_ENV=production
APP_DEBUG=false
DB_PASSWORD=changeme
```

## Prévention Directory Traversal

Les chemins sont automatiquement nettoyés :

```php
// Requête malveillante: /user/../../../etc/passwd
$request = new Request('GET', '/user/../../../etc/passwd');
$path = $request->getPath();
// Résultat: /user/etc/passwd (../ supprimés)
```

## Checklist de Sécurité

### Développement

- [ ] Utiliser `declare(strict_types=1)` dans tous les fichiers
- [ ] Valider toutes les entrées utilisateur
- [ ] Utiliser des requêtes préparées
- [ ] Ajouter la protection CSRF aux formulaires
- [ ] Ne jamais afficher d'erreurs détaillées en production
- [ ] Hasher tous les mots de passe
- [ ] Utiliser HTTPS en production

### Production

- [ ] `APP_DEBUG=false` dans `.env`
- [ ] `APP_ENV=production` dans `.env`
- [ ] HTTPS activé
- [ ] Fichiers sensibles hors de `public/`
- [ ] Permissions fichiers correctes (755/644)
- [ ] Base de données : utilisateur avec droits minimaux
- [ ] Logs d'erreurs configurés
- [ ] Firewall configuré

## Signalement de Vulnérabilités

Si vous découvrez une vulnérabilité de sécurité :

1. **NE PAS** créer une issue publique
2. Envoyer un email à security@brickphp.dev
3. Inclure une description détaillée
4. Inclure des étapes de reproduction

Nous nous engageons à répondre dans les 48 heures.

## Ressources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Cheatsheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
- [Symfony Security Best Practices](https://symfony.com/doc/current/security.html)
