<?php
namespace EPL2;

use PHPUnit\Framework\TestCase;

final class PointTest extends TestCase
{
    public function test_toString()
    {
        $point = new Point(5, 4);

        $this->assertEquals(
            '5,4',
            (string) $point
        );

        $point = new Point(4, 5);

        $this->assertEquals(
            '4,5',
            (string) $point
        );
    }
}