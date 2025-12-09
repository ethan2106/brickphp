# Security Guide - BrickPHP SUPERCAR

## Introduction

Security is at the heart of BrickPHP SUPERCAR. This guide details the built-in security features and best practices.

## CSRF Protection (Cross-Site Request Forgery)

### Form Usage

```twig
<form method="POST" action="/users">
    {{ csrf_field() }}
    <input type="text" name="username">
    <button type="submit">Submit</button>
</form>
```

### AJAX Usage

```javascript
// In your layout
<meta name="csrf-token" content="{{ csrf_token() }}">

// In your JavaScript
fetch('/api/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
});
```

### CSRF Middleware

```php
// routes/web.php
$router->post('/submit', 'FormController@submit')
    ->middleware(CsrfMiddleware::class);
```

## XSS Protection (Cross-Site Scripting)

### Automatic Escaping

BrickPHP automatically escapes all output in Twig templates:

```twig
{# Safe by default #}
<p>{{ user.comment }}</p>

{# If you really need raw HTML (BE CAREFUL) #}
<p>{{ user.html_content|raw }}</p>
```

### In Controllers

```php
// Data is automatically escaped
$comment = $request->post('comment');
// $comment is already XSS-safe
```

### Manual Validation

```php
use BrickPHP\Security\Validator;

$safe = Validator::sanitize($userInput);
$clean = Validator::clean($dirtyHtml);
```

## SQL Injection Protection

### Prepared Statements

**ALWAYS** use prepared statements:

```php
// ❌ DANGER - SQL Injection possible
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = " . $id;

// ✅ GOOD - Prepared statement
$id = $request->query('id');
$user = $this->db->fetchOne(
    "SELECT * FROM users WHERE id = :id",
    [':id' => $id]
);
```

### Secure ORM Methods

```php
// All these methods use prepared statements
$user = $userModel->find($id);
$users = $userModel->where(['status' => 'active']);
$userModel->create(['name' => $name]);
$userModel->update($id, ['email' => $email]);
$userModel->delete($id);
```

## Input Validation

### Validation Rules

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
    
    // $data is now validated
}
```

### Available Rules

- `required` : Required field
- `email` : Valid email
- `numeric` : Numeric value
- `alpha` : Letters only
- `alphanumeric` : Letters and numbers
- `url` : Valid URL
- `min:X` : Minimum length
- `max:X` : Maximum length

## Security Headers

BrickPHP automatically adds security headers to all responses:

```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Content-Security-Policy: default-src 'self'
```

## Secure Sessions

Sessions are configured with strict security settings:

```php
// Automatic configuration
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_secure', '1');  // On HTTPS
ini_set('session.cookie_samesite', 'Strict');
```

## Passwords

### Secure Hashing

```php
// Create hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verify password
if (password_verify($inputPassword, $storedHash)) {
    // Password correct
}
```

### In Models

```php
// User model automatically hashes passwords
$userId = $userModel->createUser([
    'email' => 'user@example.com',
    'password' => 'plaintext-password', // Will be hashed automatically
]);

// Verification
if ($userModel->verifyPassword($user, $inputPassword)) {
    // Authentication successful
}
```

## Environment Variables

**NEVER** commit the `.env` file:

```bash
# .gitignore already contains
.env
.env.local
```

Use `.env.example` as template:

```env
# .env.example
APP_NAME=BrickPHP
APP_ENV=production
APP_DEBUG=false
DB_PASSWORD=changeme
```

## Directory Traversal Prevention

Paths are automatically sanitized:

```php
// Malicious request: /user/../../../etc/passwd
$request = new Request('GET', '/user/../../../etc/passwd');
$path = $request->getPath();
// Result: /user/etc/passwd (../ removed)
```

## Security Checklist

### Development

- [ ] Use `declare(strict_types=1)` in all files
- [ ] Validate all user input
- [ ] Use prepared statements
- [ ] Add CSRF protection to forms
- [ ] Never display detailed errors in production
- [ ] Hash all passwords
- [ ] Use HTTPS in production

### Production

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] HTTPS enabled
- [ ] Sensitive files outside `public/`
- [ ] Correct file permissions (755/644)
- [ ] Database: user with minimal privileges
- [ ] Error logs configured
- [ ] Firewall configured

## Vulnerability Reporting

If you discover a security vulnerability:

1. **DO NOT** create a public issue
2. Send email to security@brickphp.dev
3. Include detailed description
4. Include reproduction steps

We commit to responding within 48 hours.

## Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Cheatsheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
- [Symfony Security Best Practices](https://symfony.com/doc/current/security.html)
