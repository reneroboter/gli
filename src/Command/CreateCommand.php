<?php

namespace reneroboter\gli\Command;

use League\CLImate\CLImate;
use reneroboter\gli\Entity\CommandResult;

class CreateCommand implements CommandInterface
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
        $this->addOptions();
        $data = $this->processOptions();
        $commandResult->setData($data);
        $commandResult->setMethod('GET');
        $commandResult->setEndpoint('/user/repos');
        $commandResult->setHandler(function ($data) {
            $createdRepository = json_decode($data, true);
            $result = 'Created successfully '
                . $createdRepository['html_url']
                . PHP_EOL
                . 'git remote add origin '
                . $createdRepository['ssh_url']
                . PHP_EOL
                . 'git push -u origin master'
                . PHP_EOL;
            return $result;
        });
        return $commandResult;
    }

    /**
     * @return void
     */
    protected function addOptions(): void
    {
        $this->climate->arguments->add([
            'name' => [
                'prefix' => 'n',
                'longPrefix' => 'name',
                'description' => 'Name',
                'required' => true,
            ],
            'description' => [
                'prefix' => 'd',
                'longPrefix' => 'description',
                'description' => 'Description',
                'noValue' => true,
            ],
            'homepage' => [
                'prefix' => 'h',
                'longPrefix' => 'homepage',
                'description' => 'Homepage',
                'noValue' => true,
            ],
            'private' => [
                'prefix' => 'p',
                'longPrefix' => 'private',
                'description' => 'Private',
                'noValue' => true,
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
        $request = [];
        if ($this->climate->arguments->defined('help')) {
            $this->climate->usage();
            exit(0);
        }

        if (!$this->climate->arguments->defined('name')) {
            $this->climate->error('The following arguments are required: [-n name, --name name]');
            exit(0);
        }

        $this->climate->arguments->parse();

        $request['name'] = $this->climate->arguments->get('name');

        if ($this->climate->arguments->defined('description')) {
            $request['description'] = $this->climate->arguments->get('description');
        }

        if ($this->climate->arguments->defined('homepage')) {
            $request['homepage'] = $this->climate->arguments->get('homepage');
        }

        if ($this->climate->arguments->defined('private')) {
            $request['private'] = $this->climate->arguments->get('private');
        }
        return $request;
    }
}