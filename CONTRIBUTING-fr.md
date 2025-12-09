# 🤝 Contribuer à BrickPHP

Merci d'envisager de contribuer à BrickPHP ! Nous accueillons toutes les contributions, des rapports de bugs aux demandes de fonctionnalités et modifications du code.

## 📋 Code de Conduite

Ce projet suit un code de conduite pour assurer un environnement accueillant pour tous les contributeurs.

## 🚀 Comment Contribuer

### 1. Fork & Clone

```bash
git clone https://github.com/your-username/brickphp.git
cd brickphp
composer install
npm install
```

### 2. Créer une Branche

```bash
git checkout -b feature/votre-nom-de-fonctionnalite
# ou
git checkout -b fix/numero-issue
```

### 3. Faire des Modifications

- Suivre les standards de codage PSR-12
- Ajouter des tests pour les nouvelles fonctionnalités
- Mettre à jour la documentation si nécessaire
- S'assurer que tous les tests passent

### 4. Exécuter les Vérifications Qualité

```bash
# Exécuter toutes les vérifications
composer check

# Vérifications individuelles
composer test          # Tests PHPUnit
composer phpstan       # Analyse statique
composer cs-fix        # Formatage du code
```

### 5. Commit & Push

```bash
git add .
git commit -m "✨ Ajout de la fonctionnalité X"
git push origin feature/votre-fonctionnalite
```

### 6. Créer une Pull Request

1. Aller sur GitHub et créer une Pull Request
2. Décrire clairement les changements
3. Référencer les issues liées
4. Attendre la revue du code

## 🧪 Tests & Qualité

### Exécution des Tests

```bash
# Tests unitaires
composer test

# Tests avec couverture
composer test-coverage

# Tests de mutation (qualité avancée)
composer infection
```

### Standards de Qualité

- **PHPStan Level 8** : Analyse statique maximale
- **PHPUnit** : Tests unitaires et fonctionnels
- **PSR-12** : Standards de codage PHP
- **PHPMD** : Détection des mauvaises odeurs
- **Infection** : Tests de mutation (MSI 93% minimum)

## 📝 Conventions de Commit

Nous utilisons des commits conventionnels :

```bash
✨ feat: nouvelle fonctionnalité
🐛 fix: correction de bug
📚 docs: changements de documentation
🎨 style: changements de style (formatage, etc.)
♻️ refactor: refactorisation du code
🧪 test: ajout ou modification de tests
🔧 chore: changements de configuration
```

## 🐛 Rapport de Bugs

Pour rapporter un bug :

1. **Vérifier** qu'il n'existe pas déjà
2. **Créer une issue** avec le template approprié
3. **Inclure** :
   - Description claire du problème
   - Étapes pour reproduire
   - Comportement attendu vs actuel
   - Environnement (PHP, OS, etc.)

## 💡 Demandes de Fonctionnalités

Pour proposer une nouvelle fonctionnalité :

1. **Discuter** d'abord dans une issue GitHub
2. **Décrire** le cas d'usage et les bénéfices
3. **Attendre** l'approbation avant de coder

## 📚 Documentation

### Mise à Jour de la Doc

- README.md pour les changements majeurs
- Commentaires PHPDoc pour le code
- README-SUPERCAR.md pour la présentation marketing

### Traductions

La documentation est maintenue en **français** (langue par défaut) et **anglais**.

## 🎯 Bonnes Pratiques

### Code
- Utiliser des types stricts (`declare(strict_types=1)`)
- Écrire des tests avant le code (TDD)
- Respecter SOLID et les principes de conception
- Documenter les fonctions complexes

### Git
- Commits atomiques et descriptifs
- Branches feature/fix bien nommées
- Pull Requests avec description détaillée
- Revue de code obligatoire

### Communication
- Respecter le code de conduite
- Être constructif dans les revues
- Aider les nouveaux contributeurs

## 🏆 Reconnaissance

Tous les contributeurs sont crédités dans :
- Le fichier CHANGELOG.md
- La section "Contributors" du README
- Les releases GitHub

## 📞 Support

Besoin d'aide ?
- 📧 **Email** : contact@brickphp.dev
- 💬 **Discussions** : GitHub Discussions
- 🐛 **Issues** : Pour bugs et demandes

---

**Merci de contribuer à BrickPHP ! Votre aide est précieuse pour la communauté. 🚀**
