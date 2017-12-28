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

    public function test_setPoint()
    {
        $point = new Point(5, 4);

        $point->setPoint(9, 6);

        $this->assertEquals(
            '9,6',
            (string) $point
        );
    }

    public function test_getPoint()
    {
        $point = new Point(5, 4);

        $this->assertArraySubset(
            array(
                'x' => 5,
                'y' => 4,
            ),
            $point->getPoint()
        );
    }
}