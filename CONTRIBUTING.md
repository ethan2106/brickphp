# Contributing to BrickPHP SUPERCAR

Thank you for considering contributing to BrickPHP SUPERCAR! We appreciate your interest in improving this framework.

## How to Contribute

### Reporting Bugs

If you find a bug, please create an issue with:
- A clear title and description
- Steps to reproduce
- Expected vs actual behavior
- PHP version and environment details

### Suggesting Features

Feature requests are welcome! Please provide:
- Clear description of the feature
- Use cases and examples
- Why it would benefit the framework

### Code Contributions

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Write code following our standards**
   - Use strict types: `declare(strict_types=1);`
   - Follow PSR-12 code style
   - Add PHPDoc comments
   - Write tests for new features

4. **Run quality checks**
   ```bash
   composer cs-fix      # Fix code style
   composer phpstan     # Static analysis
   composer test        # Run tests
   ```

5. **Commit your changes**
   ```bash
   git commit -m "Add feature: description"
   ```

6. **Push and create Pull Request**
   ```bash
   git push origin feature/your-feature-name
   ```

## Code Standards

### PHP Style
- Follow PSR-12
- Use strict types
- Type hint everything
- Use meaningful variable names

### Testing
- Write unit tests for new features
- Maintain test coverage above 75%
- Use descriptive test names

### Security
- Never commit secrets
- Validate all user input
- Use prepared statements
- Implement CSRF protection

### Documentation
- Update README if needed
- Add inline comments for complex logic
- Update API documentation

## Development Setup

```bash
# Clone repository
git clone https://github.com/ethan2106/brickphp.git
cd brickphp

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Run tests
composer test
```

## Questions?

Feel free to open an issue for any questions or discussions.

Thank you for contributing! 🎉
