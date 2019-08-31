<?php


namespace reneroboter\gli\Command;


use reneroboter\Command\AbstractCommand;
use reneroboter\gli\Dto\Request;
use reneroboter\Provider\GitProviderInterface;

class DeleteCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @param GitProviderInterface $gitProvider
     * @return Request
     */
    public function handle(GitProviderInterface $gitProvider): Request
    {
        $this->prepareOptions();
        $processedOptions = $this->processOptions();
        return $gitProvider->delete($processedOptions);
    }

    /**
     * @return void
     */
    protected function prepareOptions(): void
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