<?php
namespace EPL2;

use PHPUnit\Framework\TestCase;

final class CommandCollectionTest extends TestCase
{
    public function test_getCommand_empty()
    {
        $c = new CommandCollection;

        $this->assertTrue(
            empty(
                $c->getCommand()
            )
        );
    }

    public function test_getCommand()
    {
        $c = new CommandCollection;

        $c->add(new LineDrawBlack(new Point(20,0), 5, 770));

        $this->assertArraySubset(
            array(
                'LO20,0,770,5',
            ),
            $c->getCommand()
        );
    }

    public function test_getCommand_para_TextLines()
    {
        $c = new CommandCollection;

        $c->add(new TextLines(new Point(20, 10), 1, 'TEST TEST', 32));

        $this->assertArraySubset(
            array(
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $c->getCommand()
        );
    }

    public function test_getCommand_para_varios_tipos_de_comandos()
    {
        $c = new CommandCollection;

        $c->add(new LineDrawBlack(new Point(20,0), 5, 770));
        $c->add(new ASCIIText(new Point(30, 100), 4, 'SKU'));
        $c->add(new TextLines(new Point(20, 10), 1, 'TEST TEST', 32));

        $this->assertArraySubset(
            array(
                'LO20,0,770,5',
                'A30,100,0,4,1,1,N,"SKU"',
                'A20,10,0,1,1,1,N,"TEST"',
                'A20,22,0,1,1,1,N,"TEST"',
            ),
            $c->getCommand()
        );
    }
}