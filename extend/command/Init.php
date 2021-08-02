<?php

namespace command;

use think\console\command\Make;

class Init extends Make
{
    protected $type = "Init";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:logic')
            ->setDescription('Create a new init class');
    }

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'init.stub';
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\init';
    }
}
