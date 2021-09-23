<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\logic\Config as LogicConfig;

/**
 * 订阅消息
 */
class Subscribe extends Auth
{
    // +-----------------------------------------------
    // | 调起订阅消息场景(返回订阅消息模板ID集合)
    // +-----------------------------------------------

    /**
     * 示例(参与活动)
     */
    public function demo()
    {
        // 订阅消息模板ID集合
        $config = LogicConfig::getBatchByKeys(['test']);
        // 过滤掉没有配置订阅消息数据、去除数组键名
        $config = array_values(array_filter($config));
        // 返回订阅消息模板ID集合数组
        return data($config, '参与活动订阅消息模板ID');
    }
}
