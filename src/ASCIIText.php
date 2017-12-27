<?php
namespace EPL2;

/**
 * A Command - ASCII Text
 *
 * Prints an ASCII text string.
 *
 * Ap1,p2,p3,p4,p5,p6,p7,“DATA”
 * p1 = Horizontal start position (X) in dots.
 * p2 = Vertical start position (Y) in dots.
 * p3 = Rotation. (0-3)
 * p4 = Font selection. (1-5, A-Z)
 * p5 = Horizontal multiplier, expands the text horizontally. Values: 1, 2, 3, 4, 5, 6, & 8.
 * p6 = Vertical multiplier, expands the text vertically. Values: 1, 2, 3, 4, 5, 6, 7, 8, & 9.
 * p7 = N for normal or R for reverse image
 * “DATA” = Rep re sents a fixed data field.
 */
class ASCIIText
{
    /** @var string El comando */
    protected $command = 'A';

    /** @var Point La posicion de inicio */
    protected $start_position;

    /** @var int Rotacion. Valores del 0 al 3. 0 - Sin Rotacion, 3 - 270 grados */
    protected $rotation = 0;

    /** @var int Tamaño de la letra. Valores del 1 al 5. */
    protected $font;

    /** @var int Expande el texto horizontalmente. Valores del 1 al 8 excluyendo el 7. */
    protected $multiplier_horizontal = 1;

    /** @var int Expande el texto verticalmente. Valores del 1 al 9. */
    protected $multiplier_vertical = 1;

    /** @var bool Revertir imagen */
    protected $reverse = false;

    /** @var string El texto */
    protected $data;

    public function __construct(Point $start_position, $font, $data)
    {
        $this->start_position = $start_position;

        $this->setFont($font);

        $data = (string) $data;

        $this->data = strtoupper($data);
    }

    /**
     * @return El comando con sus parametros
     */
    public function __toString()
    {
        return $this->command. $this->start_position. ','. $this->rotation. ','. $this->font. ','. $this->multiplier_horizontal. ','. $this->multiplier_vertical. ','. $this->getReverse(). ',"'. $this->data. '"';
    }

    public function getReverse()
    {
        if ($this->reverse) {
            return 'R';
        }

        return 'N';
    }

    /**
     * @param int $font
     */
    public function setFont($font)
    {
        $font = (int) $font;

        if ($font < 1 || $font > 5) {
            throw new \Exception('Tamaño de letra "'. $font. '" no aceptado en '. __FILE__. ' linea '. __LINE__);
        }

        $this->font = $font;
    }

    /**
     * @param int $horizontal
     * @param int $vertical
     */
    public function setMultipliers($horizontal, $vertical)
    {
        $horizontal = (int) $horizontal;
        $vertical = (int) $vertical;

        if ($horizontal < 1 || $horizontal > 8 || $horizontal == 7) {
            throw new \Exception('Multiplicador horizontal "'. $horizontal. '" no aceptado en '. __FILE__. ' linea '. __LINE__);
        }

        if ($vertical < 1 || $vertical > 9) {
            throw new \Exception('Multiplicador vertical "'. $vertical. '" no aceptado en '. __FILE__. ' linea '. __LINE__);
        }

        $this->multiplier_horizontal = $horizontal;

        $this->multiplier_vertical = $vertical;
    }

    /**
     * @param int $rotation
     */
    public function setRotation($rotation)
    {
        $rotation = (int) $rotation;

        if ($rotation < 0 || $rotation > 3) {
            throw new \Exception('Rotacion de la letra "'. $rotation. '" no aceptado en '. __FILE__. ' linea '. __LINE__);
        }

        $this->rotation = $rotation;
    }

    /**
     * @param bool $reverse
     */
    public function setReverse($reverse)
    {
        $this->reverse = (bool) $reverse;
    }
}