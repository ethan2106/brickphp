<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Controller\AuthController;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    public function testAuthControllerCanBeInstantiated(): void
    {
        $controller = new AuthController();

        $this->assertInstanceOf(AuthController::class, $controller);
    }

    // More tests would require mocking BaseController methods, session, etc.
    // For now, basic instantiation test
}
