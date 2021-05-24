<?php

declare(strict_types=1);

namespace app\index\controller;

class Config extends Auth
{
    /**
     * 基本配置
     */
    public function basic()
    {
        return view();
    }

    /**
     * 系统配置表 通用更新方法
     */
    public function update(array $data)
    {
    }
}
