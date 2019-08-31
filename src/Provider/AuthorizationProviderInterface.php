<?php


namespace reneroboter\Provider;


interface AuthorizationProviderInterface
{
    public function authorization(array $input): array;

    public function url(array $input): string;
}