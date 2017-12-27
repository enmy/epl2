<?php
namespace EPL2;

class Point
{
    protected $x;

    protected $y;

    public function __construct($x, $y)
    {
        $this->x = (int) $x;

        $this->y = (int) $y;
    }

    public function __toString()
    {
        return "{$this->x},{$this->y}";
    }
}