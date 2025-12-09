<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testArrayHasKey(): void
    {
        $array = ['name' => 'BrickPHP', 'type' => 'boilerplate'];

        $this->assertArrayHasKey('name', $array);
        $this->assertEquals('BrickPHP', $array['name']);
    }
}
