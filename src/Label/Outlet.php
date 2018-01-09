<?php
namespace EPL2\Label;

use EPL2\Point;
use EPL2\TextLines;
use EPL2\LineDrawBlack;
use EPL2\CommandInterface;
use EPL2\CommandCollection;

class Outlet implements CommandInterface
{
    /** @var int El numero de copias que se desea imprimir */
    protected $copies;

    /** @var string */
    protected $sku;

    /** @var int */
    protected $registro;

    /** @var string */
    protected $observacion;

    protected $config = array(
        'border' => array(
            'top' => 0,
            'right' => 780,
            'bottom' => 210,
            'left' => 20,
        ),
        'table' => array(
            'center_left_x' => 320,
            'center_right_x' => 480,
            'width' => 5
        ),
        'font' => array(
            'sku' => 3,
            'registro' => 4,
            'observacion' => 3,
        ),
    );

    protected $commands;

    public function __construct($sku, $registro, $observacion, $copies = 1)
    {
        $this->sku = $sku;

        $this->registro = $registro;

        $this->observacion = $observacion;

        $this->copies = $copies;
    }

    public function getCommand()
    {
        $this->setCommands();

        $return = $this->commands->getCommand();

        // Añade al inicio
        array_unshift($return, 'N');

        $return[] = 'P'. $this->copies. ',1';

        return $return;
    }

    protected function setCommands()
    {
        $this->commands = new CommandCollection;

        $this->addTableLines($this->commands);

        $this->addData($this->commands);
    }

    protected function addTableLines($commands)
    {
        // top
        $this->commands->add(
            new LineDrawBlack(
                new Point(
                    $this->config['border']['left'],
                    $this->config['border']['top']
                ),
                $this->config['table']['width'],
                $this->config['border']['right']
            )
        );

        // bottom
        $this->commands->add(
            new LineDrawBlack(
                new Point(
                    $this->config['border']['left'],
                    $this->config['border']['bottom']
                ),
                $this->config['table']['width'],
                $this->config['border']['right']
            )
        );

        // left
        $this->commands->add(
            new LineDrawBlack(
                new Point(
                    $this->config['border']['left'],
                    $this->config['border']['top']
                ),
                $this->config['table']['width'],
                $this->config['border']['bottom'],
                LineDrawBlack::VERTICAL
            )
        );

        // right
        $this->commands->add(
            new LineDrawBlack(
                new Point(
                    $this->config['border']['right'],
                    $this->config['border']['top']
                ),
                $this->config['table']['width'],
                $this->config['border']['bottom'],
                LineDrawBlack::VERTICAL
            )
        );

        // center left
        $this->commands->add(
            new LineDrawBlack(
                new Point(
                    $this->config['table']['center_left_x'],
                    $this->config['border']['top']
                ),
                $this->config['table']['width'],
                $this->config['border']['bottom'],
                LineDrawBlack::VERTICAL
            )
        );

        // center right
        $this->commands->add(
            new LineDrawBlack(
                new Point(
                    $this->config['table']['center_right_x'],
                    $this->config['border']['top']
                ),
                $this->config['table']['width'],
                $this->config['border']['bottom'],
                LineDrawBlack::VERTICAL
            )
        );
    }

    protected function addData($commands)
    {
        $position = $this->calculatePositionForSku();

        $this->commands->add(
            new TextLines(
                $position,
                $this->config['font']['sku'],
                $this->sku,
                $this->config['table']['center_left_x']
            )
        );

        $position = $this->calculatePositionForRegistro();

        $this->commands->add(
            new TextLines(
                $position,
                $this->config['font']['registro'],
                $this->registro,
                $this->config['table']['center_right_x'] - $this->config['table']['center_left_x']
            )
        );

        $position = $this->calculatePositionForObservacion();

        $this->commands->add(
            new TextLines(
                $position,
                $this->config['font']['observacion'],
                $this->observacion,
                $this->config['border']['right'] - $this->config['table']['center_right_x']
            )
        );
    }

    /**
     * Punto a la izquierta y centrado verticalmente.
     *
     * @return EPL2\Point
     */
    protected function calculatePositionForSku()
    {
        $font_sizes = TextLines::getFontSizes();

        // TODO: no toma en cuenta el multiplicador
        return new Point(
            $this->config['border']['left'] + $this->config['table']['width'] + 10,
            (int) (($this->config['border']['top'] + $this->config['border']['bottom']) / 2 - $font_sizes[$this->config['font']['sku']]['y'] / 2)
        );
    }

    protected function calculatePositionForRegistro()
    {
        $font_sizes = TextLines::getFontSizes();

        return new Point(
            $this->config['table']['center_left_x'] + $this->config['table']['width'] + 10,
            (int) (($this->config['border']['top'] + $this->config['border']['bottom']) / 2 - $font_sizes[$this->config['font']['registro']]['y'] / 2)
        );
    }

    protected function calculatePositionForObservacion()
    {
        $font_sizes = TextLines::getFontSizes();

        return new Point(
            $this->config['table']['center_right_x'] + $this->config['table']['width'] + 10,
            (int) (($this->config['border']['top'] + $this->config['border']['bottom']) / 2 - $font_sizes[$this->config['font']['observacion']]['y'] / 2)
        );
    }
}