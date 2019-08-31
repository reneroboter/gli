<?php


namespace reneroboter\gli\Command;


use reneroboter\gli\Dto\Request;
use reneroboter\Provider\GitProviderInterface;

interface CommandInterface
{
    public function handle(GitProviderInterface $gitProvider): Request;
}