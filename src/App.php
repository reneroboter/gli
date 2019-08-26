<?php

namespace reneroboter\gli;

use League\CLImate\CLImate;
use ReflectionClass;
use ReflectionException;
use reneroboter\gli\Command\CommandInterface;
use reneroboter\gli\Service\CurlService;

class App
{
    /**
     * @var CLImate $climate
     */
    private $climate;
    /**
     * @var array
     */
    private $config;

    public function __construct(CLImate $climate, $config)
    {
        $this->climate = $climate;
        $this->config = $config;
    }

    public function run(string $command): void
    {
        $namespace = 'reneroboter\gli\Command\\';
        $className = $namespace . ucfirst($command) . 'Command';

        try {
            $reflection = new ReflectionClass($className);
            if ($reflection->isInstantiable()) {
                /** @var CommandInterface $className */
                $commandResult = (new $className($this->climate))->handle();
                if (!$commandResult) {
                    $this->climate->error('Something get wrong ...');
                    exit(1);
                }
                $curlService = new CurlService($this->climate, $this->config);
                $curlService->process($commandResult);
            }
        } catch (ReflectionException $e) {
            $this->climate->error('Error: ' . $e->getMessage());
        }
    }
}