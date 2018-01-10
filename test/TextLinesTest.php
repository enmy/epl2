<?php
namespace EPL2;

use PHPUnit\Framework\TestCase;

final class TextLinesTest extends TestCase
{
    public function test_getCommand()
    {
        $lines = new TextLines(new Point(20, 10), 1, 'TEST TEST', 32);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(30, 10), 1, 'TEST TEST', 32);

        $this->assertArraySubset(
            array(
                'A30,10,0,1,1,1,N,"TEST"',
                'A30,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );
    }

    public function test_otros_parametros()
    {
        $lines = new TextLines(new Point(300, 10), 1, 'TEST TEST', 32);

        $lines->setRotation(1)
            ->setMultipliers(2, 3)
            ->setReverse(true);

        $this->assertArraySubset(
            array(
                'A300,10,1,1,2,3,R,"TEST"',
                'A300,22,1,1,2,3,R,"TEST"',
            ),
            $lines->getCommand()
        );
    }

    public function test_otros_tamanos_de_fuente()
    {
        $lines = new TextLines(new Point(30, 10), 2, 'TEST TEST', 48);

        $this->assertArraySubset(
            array(
                'A30,10,0,2,1,1,N,"TEST"',
                'A30,28,0,2,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(30, 10), 3, 'TEST TEST', 56);

        $this->assertArraySubset(
            array(
                'A30,10,0,3,1,1,N,"TEST"',
                'A30,31,0,3,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(30, 10), 4, 'TEST TEST', 64);

        $this->assertArraySubset(
            array(
                'A30,10,0,4,1,1,N,"TEST"',
                'A30,34,0,4,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(30, 10), 5, 'TEST TEST', 144);

        $this->assertArraySubset(
            array(
                'A30,10,0,5,1,1,N,"TEST"',
                'A30,64,0,5,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );
    }

    public function test_data_en_minusculas()
    {
        $lines = new TextLines(new Point(20, 10), 1, 'test test', 32);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );
    }

    public function test_texto_muy_largo()
    {
        $lines = new TextLines(new Point(20, 10), 1, 'test loong', 32);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"LOON"',
                'A20,34,0,1,1,1,N,"G"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(20, 10), 1, 'loong loong', 32);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"LOON"',
                'A20,22,0,1,1,1,N,"G"',
                'A20,34,0,1,1,1,N,"LOON"',
                'A20,46,0,1,1,1,N,"G"',
            ),
            $lines->getCommand()
        );
    }

    public function test_texto_con_el_caracter_que_se_usa_en_splitData()
    {
        $lines = new TextLines(new Point(20, 10), 1, "TEST TE\n", 32);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                "A20,22,0,1,1,1,N,\"TE\n\"",
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(20, 10), 1, "TEST TES\n", 32);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                "A20,22,0,1,1,1,N,\"TES\n\"",
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(20, 10), 1, "TES\n TEST", 32);

        $this->assertArraySubset(
            array(
                "A20,10,0,1,1,1,N,\"TES\n\"",
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );
    }

    public function test_varios_largos_maximos()
    {
        $lines = new TextLines(new Point(20, 10), 1, 'TEST TEST', 33);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(20, 10), 1, 'TEST TEST', 34);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(20, 10), 1, 'TEST TEST', 71);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $lines->getCommand()
        );

        $lines = new TextLines(new Point(20, 10), 1, 'TEST TEST', 72);

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST TEST"',
            ),
            $lines->getCommand()
        );
    }

    public function test_largo_maximo_menor_que_tamano_de_letra()
    {
        $this->expectException('Exception');

        $lines = new TextLines(new Point(20, 10), 1, 'TEST TEST', 7);
    }

    public function test_getHeight()
    {
        $font = 1;

        $lines = new TextLines(new Point(20, 10), $font, 'TEST TEST', 32);

        $font_sizes = TextLines::getFontSizes();

        $this->assertEquals(
            $font_sizes[$font]['y']*2,
            $lines->getHeight()
        );

        $font = 3;

        $lines = new TextLines(new Point(20, 10), $font, 'TEST TEST', 32);

        $this->assertEquals(
            $font_sizes[$font]['y']*4,
            $lines->getHeight()
        );
    }
}