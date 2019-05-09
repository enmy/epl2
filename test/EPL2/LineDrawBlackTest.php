<?php
namespace EPL2;

use PHPUnit\Framework\TestCase;

final class LineDrawBlackTest extends TestCase
{
    public function test_toString()
    {
        $line = new LineDrawBlack(new Point(20,0), 5, 770);

        $this->assertEquals(
            'LO20,0,770,5',
            (string) $line
        );

        $line = new LineDrawBlack(new Point(200,0), 5, 7700);

        $this->assertEquals(
            'LO200,0,7700,5',
            (string) $line
        );
    }

    public function test_linea_vertical()
    {
        $line = new LineDrawBlack(new Point(320,10), 2, 210, LineDrawBlack::VERTICAL);

        $this->assertEquals(
            'LO320,10,2,210',
            (string) $line
        );
    }
}