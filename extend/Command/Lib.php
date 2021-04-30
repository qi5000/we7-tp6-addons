<?php

// +---------------------------------------------------------
// | 自定义命令创建基础库类文件
// +---------------------------------------------------------
// | php think lib Alipay
// +---------------------------------------------------------
// | php think lib api@WechatPay
// +---------------------------------------------------------

namespace command;

use think\console\command\Make;

class Lib extends Make
{
    protected $type = "Lib";

    protected function configure()
    {
        parent::configure();
        $this->setName('lib')
            ->setDescription('Create a new lib class');
    }

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'lib.stub';
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\lib';
    }
}
