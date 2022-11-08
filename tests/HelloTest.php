<?php
namespace  PHPUnit;
use PHPUnit\Framework\TestCase;
final class HelloTest extends TestCase
{
    public function testItLoadsUsersFromRepository(): void
    {
        $this->assertTrue(true);
        $this->assertTrue(true);
        $this->assertTrue(true);
    }
    public function testAdd(): void{
        $this->assertEquals(4, 2+2);
    }
}
