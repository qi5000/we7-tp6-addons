<?php

// +---------------------------------------------------------
// | 自定义命令创建逻辑层类文件
// +---------------------------------------------------------
// | php think logic User
// +---------------------------------------------------------
// | php think logic api@User
// +---------------------------------------------------------

namespace command;

use think\console\command\Make;

class Logic extends Make
{
    protected $type = "Logic";

    protected function configure()
    {
        parent::configure();
        $this->setName('logic')
            ->setDescription('Create a new logic class');
    }

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'logic.stub';
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\logic';
    }
}
