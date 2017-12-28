<?php
namespace EPL2;

interface CommandInterface
{
    /**
     * @return string|array El comando en formato string con sus parametros. Si son varios, retorna un array.
     */
    public function getCommand();
}