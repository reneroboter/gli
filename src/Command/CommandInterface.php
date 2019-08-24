<?php


namespace reneroboter\gli\Command;


use reneroboter\gli\Entity\CommandResult;

interface CommandInterface
{
    public function handle(): CommandResult;
}