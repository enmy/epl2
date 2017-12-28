<?php
namespace EPL2;

class TextLines extends ASCIIText
{
    protected $max_length;

    /** @var array Puntos que ocupa cada formato de letra. x - ancho, y - alto */
    protected $font_size = array(
        1 => array(
            'x' => 8,
            'y' => 12,
        ),
        2 => array(
            'x' => 12,
            'y' => 18,
        ),
        3 => array(
            'x' => 14,
            'y' => 21,
        ),
        4 => array(
            'x' => 16,
            'y' => 24,
        ),
        5 => array(
            'x' => 36,
            'y' => 54,
        ),
    );

    /**
     * @see EPL2\ASCIIText
     * @param int $max_length Longitud máxima en puntos de la impresora.
     */
    public function __construct(Point $start_position, $font, $data, $max_length)
    {
        parent::__construct($start_position, $font, $data);

        $this->setMaxLength($max_length);
    }

    public function getCommand()
    {
        $texts = $this->splitData();

        $return = array();
        $gap = $this->font_size[$this->font]['y'];

        $start_position = $this->start_position->getPoint();
        $last_position_y = $start_position['y'];

        foreach ($texts as $text) {

            $command = $this->buildASCIIText(
                new Point($start_position['x'], $last_position_y),
                $text
            );

            $return[] = (string) $command;

            $last_position_y += $gap;
        }

        return $return;
    }

    /**
     * Divide el string $data dependiendo de $max_length
     *
     * @return array
     */
    protected function splitData()
    {
        $break = '\n';

        $wrapped = wordwrap($this->data, $this->maxCharactersPerLine(), $break, true);

        return explode($break, $wrapped);
    }

    protected function maxCharactersPerLine()
    {
        return (int) ($this->max_length / $this->font_size[$this->font]['x']);
    }

    protected function setMaxLength($max_length)
    {
        $max_length = (int) $max_length;

        if ($max_length <= 0) {
            throw new \Exception('Largo maximo "'. $max_length. '" debe ser mayor a cero (0) en '. __FILE__. ' linea '. __LINE__);
        }

        if ($max_length < $this->font_size[$this->font]['x']) {
            throw new \Exception('Largo maximo "'. $max_length. '" debe ser mayor a "'. $this->font_size[$this->font]['x']. '" en '. __FILE__. ' linea '. __LINE__);
        }

        $this->max_length = $max_length;
    }

    protected function buildASCIIText(Point $start_position, $data)
    {
        $build = new ASCIIText($start_position, $this->font, $data);

        $build->setRotation($this->rotation);

        $build->setMultipliers($this->multiplier_horizontal, $this->multiplier_vertical);

        $build->setReverse($this->reverse);

        return $build;
    }
}