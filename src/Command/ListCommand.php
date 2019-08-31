<?php


namespace reneroboter\gli\Command;


use reneroboter\Command\AbstractCommand;
use reneroboter\gli\Dto\Request;
use reneroboter\Provider\GitProviderInterface;

class ListCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @param GitProviderInterface $gitProvider
     * @return Request
     */
    public function handle(GitProviderInterface $gitProvider): Request
    {
        $this->prepareOptions();
        $processedOptions = $this->processOptions();
        return $gitProvider->list($processedOptions);
    }

    /**
     * @return void
     */
    protected function prepareOptions(): void
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
}