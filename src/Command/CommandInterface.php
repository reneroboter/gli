<?php


namespace reneroboter\gli\Command;


interface CommandInterface
{
    public function handle() : array;
}