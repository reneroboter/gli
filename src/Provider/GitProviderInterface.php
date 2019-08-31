<?php


namespace reneroboter\Provider;


use reneroboter\gli\Dto\Request;

interface GitProviderInterface
{
    public function create(array $input): Request;

    public function delete(array $input): Request;

    public function list(array $input): Request;
}