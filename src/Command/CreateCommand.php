<?php

namespace reneroboter\gli\Command;

use reneroboter\Command\AbstractCommand;
use reneroboter\gli\Dto\Request;
use reneroboter\Provider\GitProviderInterface;

class CreateCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @param GitProviderInterface $gitProvider
     * @return Request
     */
    public function handle(GitProviderInterface $gitProvider): Request
    {
        $this->prepareOptions();
        $processedOptions = $this->processOptions();
        return $gitProvider->create($processedOptions);
    }

    /**
     * @return void
     */
    protected function prepareOptions(): void
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
            ],
            'homepage' => [
                'prefix' => 'h',
                'longPrefix' => 'homepage',
                'description' => 'Homepage',
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
            exit(1);
        }

        if (!$this->climate->arguments->defined('name')) {
            $this->climate->usage();
            exit(1);
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