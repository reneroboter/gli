<?php

namespace reneroboter\gli\Service;

use League\CLImate\CLImate;
use reneroboter\gli\Entity\CommandResult;

class CurlService
{
    /**
     * @var CLImate $climate
     */
    protected $climate;

    /**
     * @var array
     */
    protected $config;

    /**
     * CurlService constructor.
     * @param CLImate $climate
     */
    public function __construct(CLImate $climate, array $config)
    {
        $this->climate = $climate;
        $this->config = $config;
    }

    /**
     * @param CommandResult $commandResult
     * @return void
     */
    public function process(CommandResult $commandResult): void
    {
        $url = 'https://api.github.com' . $commandResult->getEndpoint();
        $options = $this->buildOptions($commandResult);
        $curl = curl_init($url);
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        if ($result === false) {
            $this->climate->error(sprintf('Curl error: %s', curl_errno($curl)));
        }

        $handlerResult = $commandResult->getHandler()($result);
        if (is_array($handlerResult)) {
            $this->climate->columns($handlerResult);
        } else {
            $this->climate->out($handlerResult);
        }


        curl_close($curl);

    }

    /**
     * @param CommandResult $commandResult
     * @return array
     */
    protected function buildOptions(CommandResult $commandResult): array
    {
        $options = [
            CURLOPT_USERAGENT => 'gli user-agent',
            CURLOPT_HTTPHEADER => [
                'Authorization: token ' . $this->config['token'],
            ],
            CURLOPT_RETURNTRANSFER => true
        ];

        if ($commandResult->getMethod() === 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = $commandResult->getMethod();
        }
        if ($commandResult->getData()) {
            $options[CURLOPT_POSTFIELDS] = json_encode($commandResult->getData());

        }

        return $options;
    }
}