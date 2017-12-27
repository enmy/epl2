<?php
namespace EPL2;

/**
 * LO Command - Line Draw Black
 *
 * Use this command to draw black lines, over writing previous information.
 *
 * LOp1,p2,p3,p4
 * p1 = Horizontal start position (X) in dots.
 * p2 = Vertical start position (Y) in dots.
 * p3 = Horizontal length in dots.
 * p4 = Vertical length in dots.
 */
class LineDrawBlack
{
    const HORIZONTAL = true;

    const VERTICAL = false;

    /** @var string El comando */
    protected $command = 'LO';

    /** @var Point La posicion de inicio */
    protected $start_position;

    /** @var int Ancho */
    protected $width;

    /** @var int Largo */
    protected $length;

    /** @var bool Orientacion: horizontal o vertical */
    protected $orientation;

    public function __construct(Point $start_position, $width, $length, $orientation = self::HORIZONTAL)
    {
        $this->start_position = $start_position;

        $this->width = (int) $width;

        $this->length = (int) $length;

        $this->orientation = (bool) $orientation;
    }

    /**
     * @return El comando con sus parametros
     */
    public function __toString()
    {
        return $this->command. $this->start_position. ','. $this->getHorizontalLength(). ','. $this->getVerticalLength();
    }

    /**
     * p3 = Horizontal length in dots.
     */
    protected function getHorizontalLength()
    {
        // Vertical
        if ($this->orientation == self::VERTICAL) {
            return $this->width;
        }

        // Horizontal
        return $this->length;
    }

    /**
     * p4 = Vertical length in dots.
     */
    protected function getVerticalLength()
    {
        // Vertical
        if ($this->orientation == self::VERTICAL) {
            return $this->length;
        }

        // Horizontal
        return $this->width;
    }
}