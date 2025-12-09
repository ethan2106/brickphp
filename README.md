<<<<<<< HEAD
# 🏎️ BrickPHP SUPERCAR — "La Supercar du PHP MVC"

> *"Slim vous donne des briques. BrickPHP vous donne la maison."* 🏠

---

## 🚗 **Fiche Technique - Supercar MVC**

| **Marque / Modèle** | BrickPHP SUPERCAR |
|---------------------|---------------|
| **Type** | Framework MVC Léger & Moderne |
| **Année** | 2025 |
| **Stack** | PHP 8.1+, Twig 3.22, Alpine.js 3.14, Tailwind CSS 3.4 |
| **Architecture** | MVC Pur avec séparation claire |
| **Sécurité** | CSRF, XSS, SQL Injection, Sessions Sécurisées |

---

## 🔧 **Spécifications Techniques**

### **Moteur PHP 8.1+ Turbo**
- ✅ **Enums** pour types complexes
- ✅ **Readonly** pour immutabilité
- ✅ **Types stricts** partout
- ✅ **Attributs** pour métadonnées

### **Transmission MVC Pure**
- 🏗️ **Controller** : Logique métier
- 💾 **Model** : Accès données PDO
- 🎨 **View** : Templates Twig modulaires
- 🔧 **Service** : Logique réutilisable
- 🛠️ **Helper** : Utilitaires globaux

### **Boîte de Vitesses Router Avancée**
- ⚙️ **Middleware intégré** : Auth, Guest, CSRF
- 📦 **Groupes de routes** avec préfixes
- 🏷️ **Routes nommées** pour génération URLs
- 🔄 **Conversion automatique** paramètres numériques
- 📡 **Support AJAX** avec JSON natif

### **Sécurité de Course**
- 🛡️ **CSRF automatique** sur tous formulaires
- 🚫 **Protection XSS** via helper `e()`
- 🔒 **Requêtes préparées** SQL partout
- 🍪 **Sessions httponly** + samesite

---

## 📊 **Performances de Supercar**

| **Composant** | **Taille** | **Gzippé** | **Commentaire** |
|---------------|------------|------------|-----------------|
| **Core (app.js)** | 6 KB | 2.4 KB | Léger et rapide |
| **Alpine.js** | 15 KB | 5 KB | Réactivité sans framework lourd |
| **CSS Tailwind** | 36 KB | 6.3 KB | Design system complet |
| **PHP Core** | ~50 KB | - | Framework minimaliste |

### **Vitesse & Agilité**
- ⚡ **Mobile-First** responsive
- 🚀 **Build ultra-rapide** avec Tailwind
- 🎯 **Zéro dépendance externe** à télécharger
- 🏃‍♂️ **Démarrage instantané** avec Docker

---

## 🏆 **Équipements Premium**

### **Qualité de Construction**
- 🎨 **PSR-12** impeccable avec CS-Fixer
- 🔍 **PHPStan Niveau 8** - Zéro erreur
- 🧪 **75 tests unitaires** + 131 assertions
- 🧬 **Mutation Testing MSI 93%**
- 📏 **PHPMD 0 erreur** (règles adaptées)

### **Intérieur Confortable**
- 🧩 **8+ Composants Twig** réutilisables
- 🎛️ **Alpine.js intégré** pour interactions
- 🍞 **Toast notifications** built-in
- 📱 **Responsive design** partout
- 🎨 **Dark mode ready** avec Tailwind

### **Technologies de Pointe**
- 🐳 **Docker production-ready**
- 🔄 **Hot reload** en développement
- 📊 **Metrics intégrés** (tests, qualité, perf)
- 🛠️ **CLI tools** complets
- 📚 **Documentation bilingue** FR/EN

---

## ⚡ **Options & Accessoires**

### **Pack AJAX Pro**
- 📡 JSON responses automatiques
- 🔄 Fetch API intégré
- ⚡ Real-time updates
- 🛡️ Error handling intelligent

### **Pack Template Designer**
- 🎨 Layout Twig modulaire
- 🧩 Components système (Card, Stat, Input, Modal, Button, Table)
- 🎭 Variants Tailwind intégrés
- 🔧 Helper functions globales

### **Pack Alpine.js Sport**
- 📦 Dropdowns, Modals, Tabs
- 🔔 Toast notifications
- 🎮 Form interactions
- 🎯 State management léger

---

## 🏁 **Essai sur Circuit - Verdict**

### **"La référence du MVC léger en PHP"**

**Points Forts :**
- ✅ **Fiable pour la prod** - Tests MSI 93%
- ✅ **Rapide à prendre en main** - Setup 5 minutes
- ✅ **Zéro compromis** - Qualité maximale
- ✅ **Stack cohérente** - Tout s'emboîte parfaitement
- ✅ **Évolutif** - Architecture propre

**Idéal pour :**
- 🚀 **Startups** qui veulent aller vite
- 🏢 **Entreprises** qui veulent de la qualité
- 👨‍💻 **Développeurs** qui aiment le PHP moderne
- 📱 **Apps web** responsive et interactives

**Concurrent :** Laravel mais en plus léger, Symfony mais plus simple.

---

## 📞 **Prix & Garantie**

- **Prix :** Open Source (MIT License) - GRATUIT
- **Garantie :** Tests complets, communauté active
- **Maintenance :** Mises à jour régulières
- **Support :** Documentation complète + exemples

---

## 🎯 **Conclusion**

**BrickPHP SUPERCAR** n'est pas qu'un framework - c'est **la supercar du développement PHP** :

- 🏎️ **Performante** comme une Ferrari
- 🛡️ **Fiable** comme une Mercedes
- 🎨 **Élégante** comme une Porsche
- 💰 **Accessible** comme une Honda

*"Construisez des maisons, pas des cabanes. Avec des briques solides."* 🧱

---

<p align="center">
  <strong>BrickPHP SUPERCAR</strong> — La Supercar du PHP MVC 🏎️
</p>

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
- **Prévention XSS** - Échappement HTML avec `e()`
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
composer phpmd         # Détecteur de problèmes (0 erreurs)
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
- 🔍 **Détection de Problèmes** - 0 avertissements avec jeu de règles personnalisé
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
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: brickphp_php
    restart: unless-stopped
    volumes:
      - .:/var/www/html
    networks:
      - brickphp_internal
    deploy:
      resources:
        limits:
          memory: 1G
        reservations:
          memory: 256M
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"

  web:
    image: nginx:alpine
    container_name: brickphp_web
    restart: unless-stopped
    ports:
      - "8085:80"
      - "8446:443"
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
composer test        # PHPUnit (75 tests ✅)
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
- ✅ **75 tests unitaires** avec taux de réussite 100%
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

---

## ✨ Features

- 🚀 **PHP 8.1+** with modern features (enums, readonly, strict types)
- 🛡️ **PHPStan Level 8** - Maximum type safety, zero errors
- ✅ **PHPUnit 10.5** - 12 unit tests, 100% passing
- 🌀 **Twig 3.14** for powerful templating
- 🍦 **Alpine.js** for reactive interactions (dropdowns, modals, tabs)
- 🎨 **Tailwind CSS 3.4** with simple build system
- 🛡️ **Built-in Security** (CSRF, XSS prevention, SQL injection protection)
- 🔧 **Developer Tools** (PHPStan Level 8, PHPUnit, CS-Fixer, PHPMD)
- 📱 **Mobile-First** responsive design
- ⚡ **AJAX Support** with JSON responses
- 🏗️ **MVC Architecture** with clean separation
- 🛣️ **Advanced Router** (RESTful, middleware, named routes, groups)
- 🔐 **Authentication System** ready to use
- 🧩 **Reusable Components** (8+ Twig components)

---

## 📦 Installation

```bash
# Clone or copy the project
git clone https://github.com/your-username/brickphp.git my-project
cd my-project

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Setup database
cp .env.example .env
# Edit .env with your database credentials

# Build assets
npm run build

# Run development server
php -S localhost:8000 -t public
```

### ⚡ Quick Start (Docker)

```bash
docker compose up -d
# Open https://mvc.local:8445
```

---

## 📁 Project Structure

```
my-project/
├── public/                  # Web root
│   ├── index.php            # Entry point
│   └── assets/              # Static assets
│       ├── js/
│       └── css/
│
├── resources/               # Source assets
│   ├── js/
│   │   ├── app.js           # Entry point
│   │   ├── alpine/          # Alpine.js components
│   │   └── utils.js         # Utilities
│   └── css/
│       └── app.css          # Tailwind entry
│
├── src/
│   ├── Config/              # Configuration files
│   ├── Controller/          # Business logic
│   ├── Core/                # Framework core (Router)
│   ├── Model/               # Data access layer
│   ├── Helper/               # Global utilities
│   ├── Service/             # Services
│   └── View/                # Templates & components
│       ├── layout.twig      # Main layout
│       └── components/      # Twig components
│
├── routes/                  # Route definitions
├── tests/                   # PHPUnit tests
├── tailwind.config.js       # Tailwind configuration
└── package.json
```

---

## 🎯 JavaScript Architecture

BrickPHP uses **Alpine.js** for reactive interactions, keeping things simple and lightweight.

### Philosophy

| Use Case | Technology | Example |
|----------|------------|---------|
| Simple interactions | Alpine.js | Dropdowns, modals, tabs, forms |
| Animations | CSS + JS | Transitions, toasts |

### Alpine.js Integration

Components are built with Alpine.js directives:

```html
<!-- Alpine.js component -->
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" x-transition>
        Content here
    </div>
</div>
```

---

## 🍦 Alpine.js Components

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
<!-- Trigger -->
<button @click="$dispatch('open-modal', { id: 'my-modal' })">Open Modal</button>

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
        <h2>Title</h2>
        <p>Content...</p>
        <button @click="open = false">Close</button>
    </div>
</div>
```

### Tabs

```html
<div x-data="{ activeTab: 'tab1' }">
    <div class="tabs-list">
        <button @click="activeTab = 'tab1'" :class="{ 'active': activeTab === 'tab1' }">Tab 1</button>
        <button @click="activeTab = 'tab2'" :class="{ 'active': activeTab === 'tab2' }">Tab 2</button>
    </div>
    <div x-show="activeTab === 'tab1'" x-transition>Content 1</div>
    <div x-show="activeTab === 'tab2'" x-transition class="hidden">Content 2</div>
</div>
```

### Toast Notifications

```javascript
// Global function available everywhere
window.toast('Operation successful!', 'success');
window.toast('Something went wrong', 'error');
window.toast('Please wait...', 'info');
```

---

## 🛠️ Creating Custom Components

### Alpine.js Component

```html
<!-- In your Twig template -->
<div x-data="myComponent()">
    <!-- Your component HTML -->
</div>

<script>
function myComponent() {
    return {
        message: 'Hello',
        toggle() {
            this.message = this.message === 'Hello' ? 'World' : 'Hello';
        }
    }
}
</script>
```

---

## 🔧 Build System

### Development

```bash
npm run dev      # Watch Tailwind CSS changes
npm run build    # Build production CSS
```

### Output

```
public/assets/
├── css/
│   └── app.css   # Compiled Tailwind CSS
└── js/
    └── app.js    # Alpine.js and custom scripts
```

### Twig Helper

```twig
<!-- In layout.twig -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
```

---

## 🧩 Twig Components

```twig
{# Cards & Layout #}
{{ include('components/card.twig', {title: 'My Card'}) }}
{{ include('components/stat.twig', {label: 'Users', value: '1,234'}) }}

{# Forms #}
{{ include('components/input.twig', {name: 'email', label: 'Email'}) }}
{{ include('components/button.twig', {text: 'Submit', variant: 'success'}) }}

{# Feedback #}
{{ include('components/alert.twig', {message: 'Success!', type: 'success'}) }}
{{ include('components/modal.twig', {id: 'confirm', title: 'Confirm'}) }}
```

### Available Components

| Component | Description |
|-----------|-------------|
| `stat` | Dashboard stat card |
| `card` | Generic card with header/footer |
| `button` | Button with variants |
| `badge` | Colored badge/tag |
| `alert` | Alert message (auto-dismiss) |
| `input` | Form input field |
| `table` | Data table |
| `modal` | Modal dialog |

---

## 🛣️ Routing

### Define Routes

```php
<?php
// routes/web.php
use App\Controller\HomeController;
use App\Controller\UserController;

$router->get('/', [HomeController::class, 'index'], 'home');
$router->get('/users', [UserController::class, 'index'], 'users.index');
$router->get('/users/{id}', [UserController::class, 'show'], 'users.show');
$router->post('/users', [UserController::class, 'store'], 'users.store');

// Route groups with middleware
$router->group(['middleware' => ['auth']], function($router) {
    $router->get('/dashboard', [DashboardController::class, 'index']);
    $router->get('/profile', [ProfileController::class, 'show']);
});
```

### Generate URLs

```php
// In PHP
$url = url('users.show', ['id' => 123]); // /users/123

// In templates
<a href="<?= url('home') ?>">Home</a>
```

---

## 🛡️ Security

- **CSRF Protection** - Automatic token validation
- **XSS Prevention** - HTML escaping with `e()` helper
- **SQL Injection** - Prepared statements everywhere
- **Session Security** - httponly, samesite cookies

### CSRF in Forms

```php
<form method="POST">
    <?php csrf(); ?>
    <!-- fields -->
</form>
```

### CSRF in AJAX

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

## 🔧 Development Tools

```bash
# Quality Checks (All-in-One)
composer check:all     # CS-Fixer + PHPStan + PHPMD + PHPUnit (✅ 0 errors)

# Individual Commands
composer test          # PHPUnit tests (75 tests, 131 assertions)
composer phpstan       # Static analysis (Level 8 ✅ 0 errors)
composer cs-check      # Check code style (PSR-12)
composer cs-fix        # Auto-fix code style
composer phpmd         # Mess Detector (0 errors) (85 errors ignored false positive, exit, superglobals ect)
composer infection     # Mutation testing (MSI 93%)
composer quality       # Auto-fix + all checks

# JavaScript
npm run build          # Build production CSS
npm run dev            # Watch CSS changes
```

### Quality Metrics

| Tool | Score | Status |
|------|-------|--------|
| **PHPStan** | Level 8 | ✅ 0 errors |
| **PHPUnit** | 75 tests | ✅ 131 assertions |
| **CS-Fixer** | PSR-12 | ✅ 0 violations |
| **PHPMD** | 81 rules | ✅ 0 errors |
| **Infection** | MSI 93% | ✅ 139/148 killed |
| **Coverage** | 100% | ✅ All code tested |

### Quality Achievement

- 🏆 **PHPStan Level 8** - Maximum type safety with strict rules
- 🧪 **Mutation Testing** - 93% MSI (148 mutations, 139 killed)
- 📐 **Code Style** - PSR-12 compliant via PHP-CS-Fixer
- 🔍 **Mess Detection** - 0 warnings with custom ruleset for web frameworks
- ✅ **100% Test Coverage** - All source code covered by tests

---

## 📊 Performance

### Lightweight Stack

Alpine.js provides reactivity without the overhead of a full framework.

### Bundle Size

| Bundle | Size | Gzipped |
|--------|------|---------|
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
# Open https://mvc.local:8445
```

---

## 📝 Alpine.js Patterns

Common Alpine.js patterns in BrickPHP:

| Pattern | Example |
|---------|---------|
| `x-data` | `<div x-data="{ open: false }">` |
| `x-show` | `<div x-show="open" x-transition>` |
| `@click` | `<button @click="open = !open">` |
| `x-model` | `<input x-model="value">` |

---

## 🎯 Quick Reference

### File Locations

| What | Where |
|------|-------|
| Routes | `routes/web.php` |
| Controllers | `src/Controller/` |
| Views | `src/View/` |
| Alpine.js | `resources/js/alpine/` |
| CSS | `resources/css/app.css` |

### Commands

```bash
# Development
npm run dev          # Watch CSS changes
npm run build        # Build production CSS

# Testing & Quality
composer test        # PHPUnit (12 tests ✅)
composer phpstan     # Static analysis (Level 8 ✅)
composer cs-fix      # Auto-fix code style
composer phpmd       # Detect code smells
composer check       # Run all quality checks
```

---

## 🏆 Quality Achievement

BrickPHP has achieved **PHPStan Level 8** certification - the highest level of static analysis available:

- ✅ **Zero errors** at maximum strictness
- ✅ **Full type coverage** on all methods
- ✅ **Null safety** guaranteed via assertions
- ✅ **12 unit tests** with 100% pass rate
- ✅ **Production-ready** code quality

```bash
# Verify yourself
docker exec brickphp_php vendor/bin/phpstan analyse --memory-limit=1G
# [OK] No errors
```

---

## 📄 License

BrickPHP is open-sourced software licensed under the [MIT license](LICENSE).

---

<p align="center">
  <strong>BrickPHP SUPERCAR</strong> — Twig + Alpine.js + Tailwind 🧱
</p>
=======
# brickphp
🏎️ BrickPHP SUPERCAR - Lightweight MVC Framework for PHP 8.1+ 
>>>>>>> ac89ba4533530ff453e52c387e7caf116fc00f31
