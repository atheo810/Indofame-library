<?php

namespace Atheo\Indoframe\Core\Console;

abstract class Command
{
    protected $signature = '';

    abstract public function handle($arguments);

    public function getSignature()
    {
        return $this->signature;
    }

    protected function writeln($message)
    {
        echo $message . PHP_EOL;
    }
}
