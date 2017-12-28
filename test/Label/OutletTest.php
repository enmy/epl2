<?php
namespace EPL2\Label;

use PHPUnit\Framework\TestCase;

final class OutletTest extends TestCase
{
    public function test_getCommand()
    {
        $o = new Outlet('SKU', 7594, 'OBSERVACIONES');

        $this->assertArraySubset(
            array(
                'N',
                // lineas horizontales
                'LO20,0,780,5',
                'LO20,210,780,5',
                // lineas verticales
                'LO20,0,5,210',
                'LO780,0,5,210',
                'LO320,0,5,210',
                'LO480,0,5,210',
                // datos
                'A35,94,0,3,1,1,N,"SKU"',
                'A335,93,0,4,1,1,N,"7594"',
                'A495,94,0,3,1,1,N,"OBSERVACIONES"',

                'P1',
            ),
            $o->getCommand()
        );
    }
}