<?php

namespace reneroboter\gli;

use League\CLImate\CLImate;
use ReflectionException;
use reneroboter\gli\Command\CommandInterface;
use reneroboter\gli\Service\HttpService;

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

    public function __construct(CLImate $climate, array $config)
    {
        $this->climate = $climate;
        $this->config = $config;
    }

    public function run(string $command): void
    {
        $namespace = 'reneroboter\gli\Command\\';
        $className = $namespace . ucfirst($command) . 'Command';

        // todo prepare git provider and pass it to $className() ...

        try {
            /** @var CommandInterface $className */
            $reflection = new \ReflectionClass($className);
            if ($reflection->isInstantiable()) {
                $request = (new $className($this->climate))->handle();
                if (!$request) {
                    $this->climate->error('Something get wrong ...');
                    exit(1);
                }
                $httpService = new HttpService($this->climate, $this->config);
                $httpService->process($request);
            }
        } catch (ReflectionException $e) {
            $this->climate->error('Error: ' . $e->getMessage());
        }
    }
}