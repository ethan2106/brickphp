<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

/**
 * Tests pour tuer mutants du pathToPattern() et matchRoute()
 */
class RouterPatternTest extends TestCase
{
    protected function setUp(): void
    {
        Router::resetInstance();
    }

    protected function tearDown(): void
    {
        Router::resetInstance();
        parent::tearDown();
    }

    public function testPathToPatternWithConstraints(): void
    {
        $router = Router::getInstance();

        // Test avec contraintes multiples
        $pattern = $router->pathToPattern('/users/{id}/{slug}', [
            'id' => '\d+',
            'slug' => '[a-z0-9-]+',
        ]);

        // Le pattern doit contenir les contraintes
        $this->assertStringContainsString('\d+', $pattern);
        $this->assertStringContainsString('[a-z0-9-]+', $pattern);

        // Doit commencer par #^/ et finir par /?$#
        $this->assertStringStartsWith('#^/', $pattern);
        $this->assertStringEndsWith('/?$#', $pattern);
    }

    public function testMatchRouteWithValidParameters(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/users/{id}/{slug}', [
            'id' => '\d+',
            'slug' => '[a-z0-9-]+',
        ]);

        // Match valide
        $params = $router->matchRoute($pattern, '/users/123/mon-article');

        $this->assertIsArray($params);
        $this->assertEquals(123, $params['id']); // Doit être int
        $this->assertEquals('mon-article', $params['slug']);
    }

    public function testMatchRouteWithInvalidParameters(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/users/{id}/{slug}', [
            'id' => '\d+',
            'slug' => '[a-z0-9-]+',
        ]);

        // Match invalide (id n'est pas numérique)
        $params = $router->matchRoute($pattern, '/users/abc/invalid');

        $this->assertFalse($params);
    }

    public function testPathToPatternWithoutConstraints(): void
    {
        $router = Router::getInstance();

        // Sans contraintes, devrait utiliser [^/]+ par défaut
        $pattern = $router->pathToPattern('/posts/{slug}');

        $this->assertStringContainsString('[^/]+', $pattern);
    }

    public function testPathToPatternTrimsSlashes(): void
    {
        $router = Router::getInstance();

        // Test que trim() est utilisé (mutant UnwrapTrim)
        $pattern1 = $router->pathToPattern('/users/{id}');
        $pattern2 = $router->pathToPattern('users/{id}');

        // Les deux doivent produire le même pattern
        $this->assertEquals($pattern1, $pattern2);
    }

    public function testPathToPatternRegexAnchors(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/users/{id}', ['id' => '\d+']);

        // Doit avoir ^ au début et $ à la fin (mutants PregMatchRemoveCaret/Dollar)
        $this->assertStringStartsWith('#^/', $pattern);
        $this->assertStringEndsWith('/?$#', $pattern);

        // Tester que sans ^, ça match n'importe où (mauvais)
        $badPattern = str_replace('#^/', '#/', $pattern);
        $this->assertNotEquals($pattern, $badPattern);
    }

    public function testPathToPatternHandlesEmptySegments(): void
    {
        $router = Router::getInstance();

        // Double slash → segments vides doivent être ignorés
        $pattern = $router->pathToPattern('///users///{id}', ['id' => '\d+']);

        // Ne doit pas avoir de /// dans le pattern
        $this->assertStringNotContainsString('///', $pattern);
        $this->assertStringContainsString('\d+', $pattern);
    }

    public function testMatchRouteConvertsNumericToInt(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/items/{id}', ['id' => '\d+']);

        $params = $router->matchRoute($pattern, '/items/999');

        $this->assertIsInt($params['id']);
        $this->assertEquals(999, $params['id']);
    }

    public function testMatchRouteKeepsStringsAsStrings(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/posts/{slug}', ['slug' => '[a-z-]+']);

        $params = $router->matchRoute($pattern, '/posts/hello-world');

        $this->assertIsString($params['slug']);
        $this->assertEquals('hello-world', $params['slug']);
    }

    public function testPathToPatternQuotesLiteralSegments(): void
    {
        $router = Router::getInstance();

        // Segments littéraux doivent être échappés pour regex
        $pattern = $router->pathToPattern('/api/v1.0/users/{id}', ['id' => '\d+']);

        // Le point doit être échappé
        $this->assertStringContainsString('v1\.0', $pattern);
    }

    public function testMatchRouteWithOptionalTrailingSlash(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/about');

        // Les deux doivent matcher
        $params1 = $router->matchRoute($pattern, '/about');
        $params2 = $router->matchRoute($pattern, '/about/');

        $this->assertIsArray($params1);
        $this->assertIsArray($params2);
    }

    public function testMatchRouteReturnsOnlyNamedCaptures(): void
    {
        $router = Router::getInstance();

        $pattern = $router->pathToPattern('/users/{id}', ['id' => '\d+']);

        $params = $router->matchRoute($pattern, '/users/42');

        // Ne doit contenir que 'id', pas de captures numériques [0], [1], etc.
        $this->assertArrayHasKey('id', $params);
        $this->assertArrayNotHasKey(0, $params);
        $this->assertCount(1, $params);
    }

    public function testConstraintIsUsedInsteadOfDefault(): void
    {
        $router = Router::getInstance();

        // Avec contrainte
        $patternWithConstraint = $router->pathToPattern('/users/{id}', ['id' => '\d{3}']);
        $this->assertStringContainsString('\d{3}', $patternWithConstraint);

        // Sans contrainte
        $patternWithoutConstraint = $router->pathToPattern('/users/{id}');
        $this->assertStringContainsString('[^/]+', $patternWithoutConstraint);
        $this->assertStringNotContainsString('\d{3}', $patternWithoutConstraint);
    }
}
