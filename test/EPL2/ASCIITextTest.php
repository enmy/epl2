<?php
namespace EPL2;

use PHPUnit\Framework\TestCase;

final class ASCIITextTest extends TestCase
{
    public function test_toString()
    {
        $a = new ASCIIText(new Point(30, 100), 4, 'SKU');

        $this->assertEquals(
            'A30,100,0,4,1,1,N,"SKU"',
            (string) $a
        );

        $a = new ASCIIText(new Point(30, 110), 3, 'OBSERVACIONES');

        $this->assertEquals(
            'A30,110,0,3,1,1,N,"OBSERVACIONES"',
            (string) $a
        );
    }

    public function test_otros_parametros()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $a->setRotation(1)
            ->setMultipliers(2, 3)
            ->setReverse(true);

        $this->assertEquals(
            'A300,10,1,5,2,3,R,"TEST"',
            (string) $a
        );
    }

    public function test_excepcion_setRotation()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setRotation(4);
    }

    public function test_excepcion2_setRotation()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setRotation(-1);
    }

    public function test_excepcion_setMultipliers_horizontal()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setMultipliers(0, 1);
    }

    public function test_excepcion2_setMultipliers_horizontal()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setMultipliers(9, 1);
    }

    public function test_excepcion3_setMultipliers_horizontal()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setMultipliers(7, 1);
    }

    public function test_excepcion_setMultipliers_vertical()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setMultipliers(1, 0);
    }

    public function test_excepcion2_setMultipliers_vertical()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setMultipliers(1, 10);
    }

    public function test_excepcion_setFont()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setFont(0);
    }

    public function test_excepcion2_setFont()
    {
        $a = new ASCIIText(new Point(300, 10), 5, 'test');

        $this->expectException('Exception');

        $a->setFont(6);
    }
}