<?php


namespace reneroboter\gli\Command;


use League\CLImate\CLImate;
use reneroboter\gli\Entity\CommandResult;

class DeleteCommand implements CommandInterface
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

    public function handle(): CommandResult
    {
        $this->addOptions();
        $processedOptions = $this->processOptions();

        $commandResult = new CommandResult();
        $commandResult->setMethod('DELETE');
        $commandResult->setEndpoint('/repos/' . $processedOptions['owner'] . '/' . $processedOptions['repo']);
        $commandResult->setHandler(function ($data) {
            return 'Works ...';
        });
        return $commandResult;
    }

    protected function addOptions(): void
    {
        $this->climate->arguments->add([
            'repo' => [
                'prefix' => 'r',
                'longPrefix' => 'repo',
                'description' => 'Repository',
                'required' => true,
            ],
            'owner' => [
                'prefix' => 'o',
                'longPrefix' => 'owner',
                'description' => 'The repository owner',
                'required' => true,
            ],
            'help' => [
                'longPrefix' => 'help',
                'description' => 'Prints a usage statement',
                'noValue' => true,
            ],
        ]);
    }

    /**
     * @return array
     */
    protected function processOptions(): array
    {
        if ($this->climate->arguments->defined('help')) {
            $this->climate->usage();
            exit(1);
        }

        if (!$this->climate->arguments->defined('repo') || !$this->climate->arguments->defined('owner')) {
            $this->climate->usage();
            exit(1);
        }

        $this->climate->arguments->parse();

        return [
            'repo' => $this->climate->arguments->get('repo'),
            'owner' => $this->climate->arguments->get('owner')
        ];
    }
}