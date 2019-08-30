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
        $this->addOptions();
        $processedOptions = $this->processOptions();
        $endpoint = $this->buildEndpoint($processedOptions);
        $commandResult = new CommandResult();
        $commandResult->setMethod('GET');
        $commandResult->setEndpoint($endpoint);

        $commandResult->setHandler(function (string $data) {
            $repositories = [];
            foreach (json_decode($data, true) as $repository) {
                $visibility = $repository['private'] ? '-' : '+';
                $repositories[] = ' (' . $visibility . ') ('. $repository['owner']['login'] .') ' . $repository['name'];
            }
            return $repositories;
        });
        return $commandResult;
    }

    protected function addOptions(): void
    {
        $this->climate->arguments->add([
            'visibility' => [
                'prefix' => 'v',
                'longPrefix' => 'visibility',
                'description' => 'Visibility (public/private)',
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

        if (!$this->climate->arguments->defined('visibility')) {
            $this->climate->usage();
            exit(1);
        }

        $this->climate->arguments->parse();

        return [
            'visibility' => $this->climate->arguments->get('visibility')
        ];
    }

    /**
     * @param array $processedOptions
     * @return string
     */
    protected function buildEndpoint(array $processedOptions): string
    {
        $endpoint = '/user/repos?per_page=100';
        if (isset($processedOptions['visibility'])) {
            $endpoint .= '&visibility=' . $processedOptions['visibility'];
        }
        return $endpoint;
    }
}