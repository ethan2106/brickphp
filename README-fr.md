# 🧱 BrickPHP - Framework MVC Léger

> *"Slim vous donne des briques. BrickPHP vous donne la maison."* 🏠

> Framework MVC PHP 8.1+ moderne avec templates Twig & Alpine.js
> Prêt pour la production, sécurisé et convivial pour les développeurs

[![PHP Version](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php)](https://php.net)
[![PHPStan](https://img.shields.io/badge/PHPStan-Niveau%208-blue?style=flat-square&logo=php)](https://phpstan.org)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-75%20tests-green?style=flat-square&logo=php)](https://phpunit.de)
[![Infection](https://img.shields.io/badge/Infection-MSI%2093%25-brightgreen?style=flat-square)](https://infection.github.io)
[![Twig](https://img.shields.io/badge/Twig-3.14-9B59B6?style=flat-square&logo=twig)](https://twig.symfony.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.14-8BC0D0?style=flat-square&logo=alpine.js)](https://alpinejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](https://opensource.org/licenses/MIT)

---

## 🌍 **Langues / Languages**

| 🇫🇷 Français (Par Défaut) | 🇺🇸 English |
|---------------------------|------------|
| **[📖 README-fr.md](README-fr.md)** | **[📖 README.md](README.md)** |
| **[🤝 CONTRIBUTING-fr.md](CONTRIBUTING-fr.md)** | **[🤝 CONTRIBUTING.md](CONTRIBUTING.md)** |
| **[📋 CHANGELOG-fr.md](CHANGELOG-fr.md)** | **[📋 CHANGELOG.md](CHANGELOG.md)** |
| **[🔒 SECURITY-fr.md](SECURITY-fr.md)** | **[🔒 SECURITY.md](SECURITY.md)** |
| **[🏎️ README-SUPERCAR.md](README-SUPERCAR.md)** | - |

**Langue par défaut : 🇫🇷 Français**

---

## ✨ Fonctionnalités

- 🚀 **PHP 8.1+** avec fonctionnalités modernes (enums, readonly, types stricts)
- 🛡️ **PHPStan Niveau 8** - Sécurité de type maximale, zéro erreur
- ✅ **PHPUnit 10.5** - 12 tests unitaires, 100% réussis
- 🌀 **Twig 3.14** pour un templating puissant
- 🍦 **Alpine.js** pour des interactions réactives (dropdowns, modals, onglets)
- 🎨 **Tailwind CSS 3.4** avec système de build simple
- 🛡️ **Sécurité Intégrée** (CSRF, prévention XSS, protection injection SQL)
- 🔧 **Outils Développeur** (PHPStan Niveau 8, PHPUnit, CS-Fixer, PHPMD)
- 📱 **Design Mobile-First** responsive
- ⚡ **Support AJAX** avec réponses JSON
- 🏗️ **Architecture MVC** avec séparation claire
- 🛣️ **Router Avancé** (RESTful, middleware, routes nommées, groupes)
- 🔐 **Système d'Authentification** prêt à l'emploi
- 🧩 **Composants Réutilisables** (8+ composants Twig)

---

## 📦 Installation

```bash
# Cloner ou copier le projet
git clone https://github.com/your-username/brickphp.git my-project
cd my-project

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install

# Configurer la base de données
cp .env.example .env
# Éditer .env avec vos identifiants de base de données

# Construire les assets
npm run build

# Lancer le serveur de développement
php -S localhost:8000 -t public
```

### ⚡ Démarrage Rapide (Docker)

```bash
docker compose up -d
# Ouvrir https://mvc.local:8445
```

---

## 📁 Structure du Projet

```
my-project/
├── public/                  # Racine web
│   ├── index.php            # Point d'entrée
│   └── assets/              # Assets statiques
│       ├── js/
│       └── css/
│
├── resources/               # Assets source
│   ├── js/
│   │   ├── app.js           # Point d'entrée
│   │   ├── alpine/          # Composants Alpine.js
│   │   └── utils.js         # Utilitaires
│   └── css/
│       └── app.css          # Entrée Tailwind
│
├── src/
│   ├── Config/              # Fichiers de configuration
│   ├── Controller/          # Logique métier
│   ├── Core/                # Noyau du framework (Router)
│   ├── Model/               # Couche d'accès aux données
│   ├── Helper/               # Utilitaires globaux
│   ├── Service/             # Services
│   └── View/                # Templates & composants
│       ├── layout.twig      # Layout principal
│       └── components/      # Composants Twig
│
├── routes/                  # Définitions des routes
├── tests/                   # Tests PHPUnit
├── tailwind.config.js       # Configuration Tailwind
└── package.json
```

---

## 🎯 Architecture JavaScript

BrickPHP utilise **Alpine.js** pour les interactions réactives, gardant les choses simples et légères.

### Philosophie

| Cas d'Usage | Technologie | Exemple |
|-------------|-------------|---------|
| Interactions simples | Alpine.js | Dropdowns, modals, onglets, formulaires |
| Animations | CSS + JS | Transitions, toasts |

### Intégration Alpine.js

Les composants sont construits avec les directives Alpine.js :

```html
<!-- Composant Alpine.js -->
<div x-data="{ open: false }">
    <button @click="open = !open">Basculer</button>
    <div x-show="open" x-transition>
        Contenu ici
    </div>
</div>
```

---

## 🍦 Composants Alpine.js

### Dropdown

```html
<div x-data="{ open: false }">
    <button @click="open = !open">Menu</button>
    <div x-show="open" x-transition class="hidden">
        <a href="#">Option 1</a>
        <a href="#">Option 2</a>
    </div>
</div>
```

### Modal

```html
<!-- Déclencheur -->
<button @click="$dispatch('open-modal', { id: 'my-modal' })">Ouvrir Modal</button>

<!-- Modal -->
<div
    x-data="{ open: false }"
    @open-modal.window="if ($event.detail.id === 'my-modal') open = true"
    x-show="open"
    x-transition
    class="hidden"
>
    <div @click="open = false" class="backdrop"></div>
    <div class="modal-content">
        <h2>Titre</h2>
        <p>Contenu...</p>
        <button @click="open = false">Fermer</button>
    </div>
</div>
```

### Onglets

```html
<div x-data="{ activeTab: 'tab1' }">
    <div class="tabs-list">
        <button @click="activeTab = 'tab1'" :class="{ 'active': activeTab === 'tab1' }">Onglet 1</button>
        <button @click="activeTab = 'tab2'" :class="{ 'active': activeTab === 'tab2' }">Onglet 2</button>
    </div>
    <div x-show="activeTab === 'tab1'" x-transition>Contenu 1</div>
    <div x-show="activeTab === 'tab2'" x-transition class="hidden">Contenu 2</div>
</div>
```

### Notifications Toast

```javascript
// Fonction globale disponible partout
window.toast('Opération réussie !', 'success');
window.toast('Quelque chose s\'est mal passé', 'error');
window.toast('Veuillez patienter...', 'info');
```

---

## 🛠️ Créer des Composants Personnalisés

### Composant Alpine.js

```html
<!-- Dans votre template Twig -->
<div x-data="myComponent()">
    <!-- Votre HTML de composant -->
</div>

<script>
function myComponent() {
    return {
        message: 'Bonjour',
        toggle() {
            this.message = this.message === 'Bonjour' ? 'Monde' : 'Bonjour';
        }
    }
}
</script>
```

---

## 🔧 Système de Build

### Développement

```bash
npm run dev      # Surveiller les changements Tailwind CSS
npm run build    # Construire le CSS de production
```

### Sortie

```
public/assets/
├── css/
│   └── app.css   # CSS Tailwind compilé
└── js/
    └── app.js    # Alpine.js et scripts personnalisés
```

### Helper Twig

```twig
<!-- Dans layout.twig -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
```

---

## 🧩 Composants Twig

```twig
{# Cartes & Layout #}
{{ include('components/card.twig', {title: 'Ma Carte'}) }}
{{ include('components/stat.twig', {label: 'Utilisateurs', value: '1,234'}) }}

{# Formulaires #}
{{ include('components/input.twig', {name: 'email', label: 'Email'}) }}
{{ include('components/button.twig', {text: 'Soumettre', variant: 'success'}) }}

{# Retours #}
{{ include('components/alert.twig', {message: 'Succès !', type: 'success'}) }}
{{ include('components/modal.twig', {id: 'confirm', title: 'Confirmer'}) }}
```

### Composants Disponibles

| Composant | Description |
|-----------|-------------|
| `stat` | Carte de statistique du tableau de bord |
| `card` | Carte générique avec en-tête/pied |
| `button` | Bouton avec variantes |
| `badge` | Badge/étiquette coloré |
| `alert` | Message d'alerte (auto-dismiss) |
| `input` | Champ de saisie de formulaire |
| `table` | Table de données |
| `modal` | Boîte de dialogue modale |

---

## 🛣️ Routage

### Définir les Routes

```php
<?php
// routes/web.php
use App\Controller\HomeController;
use App\Controller\UserController;

$router->get('/', [HomeController::class, 'index'], 'home');
$router->get('/users', [UserController::class, 'index'], 'users.index');
$router->get('/users/{id}', [UserController::class, 'show'], 'users.show');
$router->post('/users', [UserController::class, 'store'], 'users.store');

// Groupes de routes avec middleware
$router->group(['middleware' => ['auth']], function($router) {
    $router->get('/dashboard', [DashboardController::class, 'index']);
    $router->get('/profile', [ProfileController::class, 'show']);
});
```

### Générer les URLs

```php
// En PHP
$url = url('users.show', ['id' => 123]); // /users/123

// Dans les templates
<a href="<?= url('home') ?>">Accueil</a>
```

---

## 🛡️ Sécurité

- **Protection CSRF** - Validation automatique des tokens
- **Prévention XSS** - Échappement HTML avec helper `e()`
- **Injection SQL** - Requêtes préparées partout
- **Sécurité des Sessions** - Cookies httponly, samesite

### CSRF dans les Formulaires

```php
<form method="POST">
    <?php csrf(); ?>
    <!-- champs -->
</form>
```

### CSRF en AJAX

```javascript
fetch('/api/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
});
```

---

## 🔧 Outils de Développement

```bash
# Vérifications Qualité (Tout-en-Un)
composer check:all     # CS-Fixer + PHPStan + PHPMD + PHPUnit (✅ 0 erreurs)

# Commandes Individuelles
composer test          # Tests PHPUnit (75 tests, 131 assertions)
composer phpstan       # Analyse statique (Niveau 8 ✅ 0 erreurs)
composer cs-check      # Vérifier le style de code (PSR-12)
composer cs-fix        # Corriger automatiquement le style de code
composer phpmd         # Détecteur de problèmes (0 erreurs) (85 erreurs ignorées faux positifs, exit, superglobals etc)
composer infection     # Tests de mutation (MSI 93%)
composer quality       # Correction auto + toutes les vérifications

# JavaScript
npm run build          # Construire le CSS de production
npm run dev            # Surveiller les changements CSS
```

### Métriques de Qualité

| Outil | Score | Statut |
|-------|-------|--------|
| **PHPStan** | Niveau 8 | ✅ 0 erreurs |
| **PHPUnit** | 75 tests | ✅ 131 assertions |
| **CS-Fixer** | PSR-12 | ✅ 0 violations |
| **PHPMD** | 81 règles | ✅ 0 erreurs |
| **Infection** | MSI 93% | ✅ 139/148 tuées |
| **Couverture** | 100% | ✅ Tout le code testé |

### Accomplissement Qualité

- 🏆 **PHPStan Niveau 8** - Sécurité de type maximale avec règles strictes
- 🧪 **Tests de Mutation** - 93% MSI (148 mutations, 139 tuées)
- 📐 **Style de Code** - Conforme PSR-12 via PHP-CS-Fixer
- 🔍 **Détection de Problèmes** - 0 avertissements avec jeu de règles personnalisé pour frameworks web
- ✅ **100% Couverture de Tests** - Tout le code source couvert par les tests

---

## 📊 Performance

### Pile Léger

Alpine.js fournit la réactivité sans la surcharge d'un framework complet.

### Taille du Bundle

| Bundle | Taille | Compressé |
|--------|--------|-----------|
| Core (app.js) | 6 KB | 2.4 KB |
| Alpine.js | 15 KB | 5 KB |
| CSS | 36 KB | 6.3 KB |

---

## 🐳 Docker

```yaml
# docker-compose.yml
services:
  php:
    build: ./docker
    volumes:
      - .:/var/www/html

  web:
    image: nginx:alpine
    ports:
      - "8445:443"
    volumes:
      - ./docker/nginx.conf:/etc/nginx/nginx.conf
```

```bash
docker compose up -d
# Ouvrir https://mvc.local:8445
```

---

## 📝 Patterns Alpine.js

Patterns Alpine.js courants dans BrickPHP :

| Pattern | Exemple |
|---------|---------|
| `x-data` | `<div x-data="{ open: false }">` |
| `x-show` | `<div x-show="open" x-transition>` |
| `@click` | `<button @click="open = !open">` |
| `x-model` | `<input x-model="value">` |

---

## 🎯 Référence Rapide

### Emplacements des Fichiers

| Quoi | Où |
|------|----|
| Routes | `routes/web.php` |
| Contrôleurs | `src/Controller/` |
| Vues | `src/View/` |
| Alpine.js | `resources/js/alpine/` |
| CSS | `resources/css/app.css` |

### Commandes

```bash
# Développement
npm run dev          # Surveiller les changements CSS
npm run build        # Construire le CSS de production

# Tests & Qualité
composer test        # PHPUnit (12 tests ✅)
composer phpstan     # Analyse statique (Niveau 8 ✅)
composer cs-fix      # Correction automatique du style
composer phpmd       # Détecter les mauvaises odeurs
composer check       # Lancer toutes les vérifications qualité
```

---

## 🏆 Accomplissement Qualité

BrickPHP a obtenu la certification **PHPStan Niveau 8** - le plus haut niveau d'analyse statique disponible :

- ✅ **Zéro erreur** à la rigueur maximale
- ✅ **Couverture de type complète** sur toutes les méthodes
- ✅ **Sécurité null** garantie via assertions
- ✅ **12 tests unitaires** avec taux de réussite 100%
- ✅ **Code prêt pour la production** qualité

```bash
# Vérifiez vous-même
docker exec brickphp_php vendor/bin/phpstan analyse --memory-limit=1G
# [OK] No errors
```

---

## 📄 Licence

BrickPHP est un logiciel open-source sous licence [MIT](LICENSE).

---

<p align="center">
  <strong>BrickPHP SUPERCAR</strong> — Twig + Alpine.js + Tailwind 🧱
</p>
