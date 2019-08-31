<?php

namespace reneroboter\gli\Service;

use League\CLImate\CLImate;
use reneroboter\gli\Dto\Request;

class HttpService
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
     * @param array $config
     */
    public function __construct(CLImate $climate, array $config)
    {
        $this->climate = $climate;
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function process(Request $request): void
    {
        // todo use AuthorizationProviderInterface.php ...
        $url = 'https://api.github.com' . $request->getEndpoint();
        $options = $this->buildOptions($request);
        $curl = curl_init($url);
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        if ($result === false) {
            $this->climate->error(sprintf('Curl error: %s', curl_errno($curl)));
        }

        $handlerResult = $request->getHandler()($result);
        if (is_array($handlerResult)) {
            $this->climate->columns($handlerResult);
        } else {
            $this->climate->out($handlerResult);
        }


        curl_close($curl);

    }

    /**
     * @param Request $request
     * @return array
     */
    protected function buildOptions(Request $request): array
    {
        $options = [
            CURLOPT_USERAGENT => 'gli user-agent',
            CURLOPT_HTTPHEADER => [
                'Authorization: token ' . $this->config['token'],
            ],
            CURLOPT_RETURNTRANSFER => true
        ];

        if ($request->getMethod() === 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = $request->getMethod();
        }
        if ($request->getData()) {
            $options[CURLOPT_POSTFIELDS] = json_encode($request->getData());

        }

        return $options;
    }
}