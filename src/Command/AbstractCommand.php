<?php


namespace reneroboter\Command;


use League\CLImate\CLImate;

abstract class AbstractCommand
{
    /**
     * @var CLImate $climate
     */
    protected $climate;

    /**
     * CreateCommand constructor.
     * @param CLImate $climate
     */
    public function __construct(CLImate $climate)
    {
        $this->climate = $climate;
    }

    /**
     * @return void
     */
    abstract protected function prepareOptions() : void;

    /**
     * @return array
     */
    abstract protected function processOptions(): array;
}