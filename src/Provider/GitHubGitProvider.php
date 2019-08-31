<?php


namespace reneroboter\Provider;


use reneroboter\gli\Dto\Request;

class GitHubGitProvider implements GitProviderInterface
{
    /**
     * @param array $input
     * @return Request
     */
    public function create(array $input): Request
    {
        $data = [
            'name' => $input['name'],
            'description' => $input['description'],
            'homepage' => $input['homepage'],
            'private' => $input['private'],
        ];
        $configuration = [
            'data' => $data,
            'method' => 'GET',
            'endpint' => ''
        ];
        return $this->buildRequestObject($configuration);
    }

    /**
     * @param array $input
     * @return Request
     */
    public function delete(array $input): Request
    {
        $endpoint = sprintf('/repos/%s/%s', $input['owner'], $input['repo']);
        $data = [
            'owner' => $input['owner'],
            'repo' => $input['repo'],
        ];
        $configuration = [
            'data' => $data,
            'method' => 'DELETE',
            'endpoint' => $endpoint
        ];
        return $this->buildRequestObject($configuration);
    }

    /**
     * @param array $input
     * @return Request
     */
    public function list(array $input): Request
    {
        $endpoint = '/user/repos?per_page=100';
        if (isset($input['visibility'])) {
            $endpoint .= '&visibility=' . $input['visibility'];
        }

        $configuration = [
            'method' => 'GET',
            'endpoint' => $endpoint
        ];
        return $this->buildRequestObject($configuration);
    }

    /**
     * @param array $configuration
     * @return Request
     */
    protected function buildRequestObject(array $configuration)
    {
        $request = new Request();
        if (isset($configuration['data'])) {
            $request->setData($configuration['data']);
        }
        $request->setMethod($configuration['method']);
        $request->setEndpoint($configuration['endpoint']);
        return $request;
    }
}