# 🔒 Security Policy

## Supported Versions

We actively support the following versions with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 1.1.x   | :white_check_mark: |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability in BrickPHP, please help us by reporting it responsibly.

### How to Report

**Please do NOT report security vulnerabilities through public GitHub issues.**

Instead, please report security vulnerabilities by emailing:
- **Email**: security@brickphp.dev (create this email or use your personal email)
- **Subject**: [SECURITY] Vulnerability Report - BrickPHP

### What to Include

Please include the following information in your report:

1. **Description**: A clear description of the vulnerability
2. **Steps to Reproduce**: Detailed steps to reproduce the issue
3. **Impact**: Potential impact and severity of the vulnerability
4. **Affected Versions**: Which versions are affected
5. **Mitigation**: Any suggested fixes or workarounds

### Our Process

1. **Acknowledgment**: We will acknowledge receipt of your report within 48 hours
2. **Investigation**: We will investigate the issue and determine its severity
3. **Fix Development**: We will develop and test a fix
4. **Disclosure**: We will coordinate disclosure with you
5. **Release**: We will release the fix and security advisory

### Guidelines

- Please allow reasonable time for us to respond and fix the issue
- Please avoid accessing or modifying user data
- Please keep the vulnerability confidential until we have released a fix
- We will credit you (if desired) in our security advisory

## Security Best Practices

When using BrickPHP, follow these security best practices:

### CSRF Protection
BrickPHP includes built-in CSRF protection. Always use it for state-changing operations:

```php
// In your forms
<?php csrf(); ?>

// In your controllers
$this->validateCsrf();
```

### Authentication
Use the built-in authentication middleware:

```php
// Protect routes
Router::middleware('auth')->get('/dashboard', [DashboardController::class, 'index']);
```

### Input Validation
Always validate and sanitize user input:

```php
public function store() {
    $data = $this->validate([
        'email' => 'required|email',
        'name' => 'required|string|max:255'
    ]);

    // Process validated data
}
```

### Database Security
- Use prepared statements (BrickPHP's BaseModel does this automatically)
- Never concatenate user input into SQL queries
- Use the built-in database abstraction layer

## Contact

For security-related questions or concerns:
- **Email**: security@brickphp.dev
- **GitHub**: [Create a private security advisory](https://github.com/your-username/brickphp/security/advisories/new)

Thank you for helping keep BrickPHP and its users secure! 🛡️