<?php


namespace reneroboter\gli\Command;


use League\CLImate\CLImate;
use reneroboter\gli\Entity\CommandResult;

class ListCommand implements CommandInterface
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
     * @return CommandResult
     */
    public function handle(): CommandResult
    {
        $commandResult = new CommandResult();
        $commandResult->setMethod('GET');
        $commandResult->setEndpoint('/user/repos');
        $commandResult->setHandler(function ($data) {
            $repositories = [];
            foreach (json_decode($data, true) as $repository) {
                $access = $repository['private'] ? 'private' : 'public';
                $repositories[] = $repository['name'] . ' ('. $access . ')';
            }
            return $repositories;
        });
        return $commandResult;
    }
}