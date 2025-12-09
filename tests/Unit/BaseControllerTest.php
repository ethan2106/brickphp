<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Controller\BaseController;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class BaseControllerTest extends TestCase
{
    public function testBaseControllerIsAbstract(): void
    {
        $reflection = new ReflectionClass(BaseController::class);
        $this->assertTrue($reflection->isAbstract());
    }

    // More tests would require mocking superglobals or creating a concrete subclass
}
