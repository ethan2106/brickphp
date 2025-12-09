# 🤝 Contributing to BrickPHP

Thank you for considering contributing to BrickPHP! We welcome all contributions, from bug reports to feature requests and code changes.

## 📋 Code of Conduct

This project follows a code of conduct to ensure a welcoming environment for all contributors.

## 🚀 How to Contribute

### 1. Fork & Clone

```bash
git clone https://github.com/your-username/brickphp.git
cd brickphp
composer install
npm install
```

### 2. Create a Branch

```bash
git checkout -b feature/your-feature-name
# or
git checkout -b fix/issue-number
```

### 3. Make Changes

- Follow PSR-12 coding standards
- Add tests for new features
- Update documentation as needed
- Ensure all tests pass

### 4. Run Quality Checks

```bash
# Run all checks
composer check

# Individual checks
composer test          # PHPUnit tests
composer phpstan       # Static analysis
composer cs-fix        # Code formatting
```

### 5. Commit & Push

```bash
git add .
git commit -m "feat: add your feature description"
git push origin feature/your-feature-name
```

### 6. Create Pull Request

Open a pull request on GitHub with a clear description of your changes.

## 🐛 Reporting Bugs

When reporting bugs, please include:

- PHP version
- Operating system
- Steps to reproduce
- Expected vs actual behavior
- Any relevant error messages

## 💡 Feature Requests

Feature requests are welcome! Please:

- Check if the feature already exists
- Describe the use case clearly
- Explain why it would be valuable

## 🧪 Testing

### Unit Tests

```bash
composer test
```

### Mutation Testing

```bash
infection --threads=4
```

Aim for high mutation scores (>80%).

## 📝 Documentation

- Update README.md for new features
- Add PHPDoc comments to new methods
- Update examples and usage guides

## 🎨 Code Style

- PSR-12 compliant
- Use type hints and return types
- Follow SOLID principles
- Write self-documenting code

## 🔄 Commit Convention

We use conventional commits:

```
feat: add new feature
fix: bug fix
docs: documentation changes
style: code style changes
refactor: code refactoring
test: add tests
chore: maintenance
```

## 📞 Getting Help

- Open an issue on GitHub
- Join our Discord community
- Check the documentation

## 🙏 Recognition

Contributors will be recognized in:
- CHANGELOG.md
- GitHub contributors list
- Project documentation

Thank you for contributing to BrickPHP! 🧱</content>
<parameter name="filePath">c:\laragon\www\site1\MVC\CONTRIBUTING.md