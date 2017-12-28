<?php
namespace EPL2;

class Point
{
    protected $x;

    protected $y;

    public function __construct($x, $y)
    {
        $this->setPoint($x, $y);
    }

    public function __toString()
    {
        return implode(',', $this->getPoint());
    }

    public function setPoint($x, $y)
    {
        $this->x = (int) $x;

        $this->y = (int) $y;

        return $this;
    }

    public function getPoint()
    {
        return array(
            'x' => $this->x,
            'y' => $this->y,
        );
    }
}