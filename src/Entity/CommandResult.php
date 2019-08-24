<?php

namespace reneroboter\gli\Entity;

class CommandResult
{
    /**
     * @var array|null
     */
    private $data;
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var callable
     */
    private $handler;

    /**
     * @var string
     */
    private $result;

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }


    /**
     * @return callable
     */
    public function getHandler(): callable
    {
        return $this->handler;
    }

    /**
     * @param callable $handler
     */
    public function setHandler(callable $handler): void
    {
        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }

}