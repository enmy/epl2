<?php
namespace EPL2;

class CommandCollection implements CommandInterface, \IteratorAggregate, \Countable
{
    protected $commands = array();

    public function getCommand()
    {
        $return = array();

        foreach ($this->commands as $command) {
            // $command_result puede ser string o array
            $command_result = $command->getCommand();

            if (is_array($command_result)) {
                foreach ($command_result as $command_aux) {
                    $return[] = $command_aux;
                }
            } else {
                $return[] = $command_result;
            }
        }

        return $return;
    }

    public function add(CommandInterface $command)
    {
        $this->commands[] = $command;
    }

    public function count()
    {
        return count($this->commands);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->commands);
    }
}