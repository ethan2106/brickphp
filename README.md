# 🏎️ BrickPHP SUPERCAR

Framework MVC PHP 8.1+ Ultra-Performant et Sécurisé

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Tests](https://img.shields.io/badge/Tests-75%2B-brightgreen)](tests/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-blue)](phpstan.neon)
[![Code Style](https://img.shields.io/badge/Code%20Style-PSR--12-orange)](https://www.php-fig.org/psr/psr-12/)

[English](#english) | [Français](#français)

---

## Français

### 🚀 Introduction

**BrickPHP SUPERCAR** est un framework MVC moderne et léger pour PHP 8.1+, conçu pour la performance et la sécurité. Il combine les meilleures pratiques du développement web avec des outils de qualité de code de niveau entreprise.

### ✨ Fonctionnalités Principales

#### Architecture MVC
- **Controllers** : Gestion claire de la logique métier
- **Models** : Couche d'abstraction de base de données avec PDO
- **Views** : Moteur de templates Twig intégré

#### Frontend Moderne
- **Twig** : Moteur de templates sécurisé et performant
- **Alpine.js** : Framework JavaScript réactif et léger
- **Tailwind CSS** : Framework CSS utilitaire

#### Sécurité Intégrée
- ✅ **Protection CSRF** : Tokens automatiques pour tous les formulaires
- ✅ **Prévention XSS** : Échappement automatique des sorties
- ✅ **Protection SQL Injection** : Requêtes préparées par défaut
- ✅ **Headers de Sécurité** : X-Frame-Options, CSP, etc.
- ✅ **Sessions Sécurisées** : Configuration renforcée
- ✅ **Validation d'Entrée** : Système de validation robuste

#### Routing RESTful
- Routes GET, POST, PUT, DELETE, PATCH
- Paramètres dynamiques
- Routes nommées
- Middleware
- Routes de ressources RESTful

#### Base de Données
- **PDO** avec support multi-drivers
- Requêtes préparées (sécurité SQL)
- Query Builder simplifié
- Transactions
- Méthodes CRUD intégrées

#### Outils de Qualité
- **PHPUnit** : 75+ tests unitaires et fonctionnels
- **PHPStan Level 8** : Analyse statique maximale
- **Infection** : Tests de mutation (MSI 93%+)
- **PSR-12** : Style de code standardisé
- **PHPMD** : Détection de code smell
- **Docker** : Environnement conteneurisé

### 📦 Installation

#### Prérequis
- PHP 8.1 ou supérieur
- Composer
- MySQL/MariaDB (ou autre base PDO)
- Docker (optionnel)

#### Installation avec Composer

```bash
# Cloner le repository
git clone https://github.com/ethan2106/brickphp.git
cd brickphp

# Installer les dépendances
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Configurer votre base de données dans .env
nano .env
```

#### Installation avec Docker

```bash
# Démarrer les containers
docker-compose up -d

# L'application sera disponible sur http://localhost:8000
# PHPMyAdmin sur http://localhost:8080
```

### 🎯 Démarrage Rapide

#### 1. Configuration

Éditez le fichier `.env` :

```env
APP_NAME=MonApp
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_HOST=localhost
DB_DATABASE=brickphp
DB_USERNAME=root
DB_PASSWORD=secret
```

#### 2. Créer un Controller

```php
<?php
// app/Controllers/UserController.php

namespace App\Controllers;

use BrickPHP\Core\Controller;
use BrickPHP\Http\Request;
use BrickPHP\Http\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->render('users/index.twig', [
            'users' => ['John', 'Jane', 'Bob'],
        ]);
    }
    
    public function show(Request $request, string $id): Response
    {
        return $this->json(['user_id' => $id]);
    }
}
```

#### 3. Définir les Routes

```php
<?php
// routes/web.php

use BrickPHP\Core\Application;

$router = Application::getInstance()->getRouter();

// Routes simples
$router->get('/', 'HomeController@index', 'home');

// Routes RESTful
$router->resource('users', 'UserController');

// Routes avec middleware
$router->get('/admin', 'AdminController@index')
    ->middleware(['auth', 'admin']);
```

#### 4. Créer un Model

```php
<?php
// app/Models/User.php

namespace App\Models;

use BrickPHP\Core\Model;

class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    
    public function findByEmail(string $email): ?array
    {
        return $this->where(['email' => $email])[0] ?? null;
    }
}
```

#### 5. Créer une Vue

```twig
{# app/Views/users/index.twig #}

{% extends "layout.twig" %}

{% block content %}
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Liste des Utilisateurs</h1>
    
    <ul>
        {% for user in users %}
            <li class="p-2">{{ user }}</li>
        {% endfor %}
    </ul>
</div>
{% endblock %}
```

### 🔒 Guide de Sécurité

#### Protection CSRF

```twig
<form method="POST" action="/users">
    {{ csrf_field() }}
    <input type="text" name="username">
    <button type="submit">Envoyer</button>
</form>
```

#### Validation des Données

```php
public function store(Request $request): Response
{
    $data = $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'age' => 'numeric',
    ]);
    
    // Les données sont maintenant validées et sécurisées
}
```

#### Requêtes Sécurisées

```php
// ❌ DANGER - Injection SQL possible
$sql = "SELECT * FROM users WHERE id = " . $id;

// ✅ BON - Requête préparée
$user = $this->db->fetchOne(
    "SELECT * FROM users WHERE id = :id",
    [':id' => $id]
);
```

### 🧪 Tests

```bash
# Exécuter tous les tests
composer test

# Avec couverture de code
composer test-coverage

# Analyse statique PHPStan
composer phpstan

# Tests de mutation Infection
composer infection

# Vérifier le style de code
composer cs-check

# Corriger le style de code
composer cs-fix

# Analyser avec PHPMD
composer phpmd

# Exécuter tous les outils de qualité
composer quality
```

### 📊 Métriques de Qualité

- **75+ Tests** : Couverture complète unitaire et fonctionnelle
- **PHPStan Level 8** : Analyse statique maximale
- **Infection MSI 93%+** : Score de mutation élevé
- **PSR-12** : Code standardisé
- **Types Stricts** : Tous les fichiers utilisent `declare(strict_types=1)`

### 📚 Documentation

- [Guide d'Installation](docs/fr/installation.md)
- [Guide de Sécurité](docs/fr/security.md)
- [Routing](docs/fr/routing.md)
- [Database](docs/fr/database.md)
- [Views & Templates](docs/fr/views.md)
- [Testing](docs/fr/testing.md)

### 🤝 Contribution

Les contributions sont les bienvenues ! Veuillez suivre ces étapes :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

### 📄 Licence

MIT License - voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## English

### 🚀 Introduction

**BrickPHP SUPERCAR** is a modern, lightweight MVC framework for PHP 8.1+, designed for performance and security. It combines web development best practices with enterprise-level code quality tools.

### ✨ Key Features

#### MVC Architecture
- **Controllers**: Clean business logic management
- **Models**: Database abstraction layer with PDO
- **Views**: Integrated Twig template engine

#### Modern Frontend
- **Twig**: Secure and performant template engine
- **Alpine.js**: Lightweight reactive JavaScript framework
- **Tailwind CSS**: Utility-first CSS framework

#### Built-in Security
- ✅ **CSRF Protection**: Automatic tokens for all forms
- ✅ **XSS Prevention**: Automatic output escaping
- ✅ **SQL Injection Protection**: Prepared statements by default
- ✅ **Security Headers**: X-Frame-Options, CSP, etc.
- ✅ **Secure Sessions**: Hardened configuration
- ✅ **Input Validation**: Robust validation system

#### RESTful Routing
- GET, POST, PUT, DELETE, PATCH routes
- Dynamic parameters
- Named routes
- Middleware support
- RESTful resource routes

#### Database Layer
- **PDO** with multi-driver support
- Prepared statements (SQL security)
- Simplified Query Builder
- Transactions
- Built-in CRUD methods

#### Quality Tools
- **PHPUnit**: 75+ unit and functional tests
- **PHPStan Level 8**: Maximum static analysis
- **Infection**: Mutation testing (MSI 93%+)
- **PSR-12**: Standardized code style
- **PHPMD**: Code smell detection
- **Docker**: Containerized environment

### 📦 Installation

#### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL/MariaDB (or other PDO database)
- Docker (optional)

#### Installation with Composer

```bash
# Clone repository
git clone https://github.com/ethan2106/brickphp.git
cd brickphp

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Configure your database in .env
nano .env
```

#### Installation with Docker

```bash
# Start containers
docker-compose up -d

# Application available at http://localhost:8000
# PHPMyAdmin at http://localhost:8080
```

### 🎯 Quick Start

#### 1. Configuration

Edit the `.env` file:

```env
APP_NAME=MyApp
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_HOST=localhost
DB_DATABASE=brickphp
DB_USERNAME=root
DB_PASSWORD=secret
```

#### 2. Create a Controller

```php
<?php
// app/Controllers/UserController.php

namespace App\Controllers;

use BrickPHP\Core\Controller;
use BrickPHP\Http\Request;
use BrickPHP\Http\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->render('users/index.twig', [
            'users' => ['John', 'Jane', 'Bob'],
        ]);
    }
    
    public function show(Request $request, string $id): Response
    {
        return $this->json(['user_id' => $id]);
    }
}
```

#### 3. Define Routes

```php
<?php
// routes/web.php

use BrickPHP\Core\Application;

$router = Application::getInstance()->getRouter();

// Simple routes
$router->get('/', 'HomeController@index', 'home');

// RESTful routes
$router->resource('users', 'UserController');

// Routes with middleware
$router->get('/admin', 'AdminController@index')
    ->middleware(['auth', 'admin']);
```

#### 4. Create a Model

```php
<?php
// app/Models/User.php

namespace App\Models;

use BrickPHP\Core\Model;

class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    
    public function findByEmail(string $email): ?array
    {
        return $this->where(['email' => $email])[0] ?? null;
    }
}
```

#### 5. Create a View

```twig
{# app/Views/users/index.twig #}

{% extends "layout.twig" %}

{% block content %}
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">User List</h1>
    
    <ul>
        {% for user in users %}
            <li class="p-2">{{ user }}</li>
        {% endfor %}
    </ul>
</div>
{% endblock %}
```

### 🔒 Security Guide

#### CSRF Protection

```twig
<form method="POST" action="/users">
    {{ csrf_field() }}
    <input type="text" name="username">
    <button type="submit">Submit</button>
</form>
```

#### Data Validation

```php
public function store(Request $request): Response
{
    $data = $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8',
        'age' => 'numeric',
    ]);
    
    // Data is now validated and secured
}
```

#### Secure Queries

```php
// ❌ DANGER - SQL Injection possible
$sql = "SELECT * FROM users WHERE id = " . $id;

// ✅ GOOD - Prepared statement
$user = $this->db->fetchOne(
    "SELECT * FROM users WHERE id = :id",
    [':id' => $id]
);
```

### 🧪 Testing

```bash
# Run all tests
composer test

# With code coverage
composer test-coverage

# PHPStan static analysis
composer phpstan

# Infection mutation testing
composer infection

# Check code style
composer cs-check

# Fix code style
composer cs-fix

# Analyze with PHPMD
composer phpmd

# Run all quality tools
composer quality
```

### 📊 Quality Metrics

- **75+ Tests**: Complete unit and functional coverage
- **PHPStan Level 8**: Maximum static analysis
- **Infection MSI 93%+**: High mutation score
- **PSR-12**: Standardized code
- **Strict Types**: All files use `declare(strict_types=1)`

### 📚 Documentation

- [Installation Guide](docs/en/installation.md)
- [Security Guide](docs/en/security.md)
- [Routing](docs/en/routing.md)
- [Database](docs/en/database.md)
- [Views & Templates](docs/en/views.md)
- [Testing](docs/en/testing.md)

### 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the project
2. Create a branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### 📄 License

MIT License - see [LICENSE](LICENSE) file for details.

---

## 🏆 Why BrickPHP SUPERCAR?

- **🚀 Fast**: Optimized for performance
- **🔒 Secure**: Security built-in from the ground up
- **🧪 Tested**: Comprehensive test suite
- **📦 Modern**: Latest PHP 8.1+ features
- **🛠️ Quality**: Enterprise-level code standards
- **📖 Documented**: Complete bilingual documentation
- **🐳 Docker Ready**: Containerized development environment

---

Made with ❤️ by the BrickPHP Team
