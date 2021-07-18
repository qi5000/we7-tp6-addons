<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\logic\Config as LogicConfig;
use liang\MicroEngine;

/**
 * 配置相关
 */
class Config
{
    // +------------------------------------------------------------
    // | 获取配置
    // +------------------------------------------------------------

    /**
     * 客服消息配置
     */
    public function serviceMessage()
    {
        $data = LogicConfig::getBatchByType('service_message');
        $data['reply_img_url'] = MicroEngine::getUrlByRoot($data['reply_img']);
        return data($data, '客服消息配置');
    }

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
