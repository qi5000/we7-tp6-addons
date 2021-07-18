<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\logic\Config as LogicConfig;

/**
 * 配置相关
 */
class Config
{
    // +------------------------------------------------------------
    // | 获取配置
    // +------------------------------------------------------------

    /**
     * 商户号配置
     */
    public function merchant()
    {
        $data = LogicConfig::getBatchByType('merchant');
        return data($data, '商户号配置');
    }

    // +------------------------------------------------------------
    // | 更新配置
    // +------------------------------------------------------------

    /**
     * 修改配置
     *
     * @param array $data
     */
    public function update(array $data)
    {
        LogicConfig::update($data);
        return success('修改成功');
    }
}
