<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\logic\Config as LogicConfig;

/**
 * 小程序接口
 * 获取系统配置
 */
class Config
{
    /**
     * 查看所有配置
     */
    public function getConfigAll()
    {
        $data = LogicConfig::getConfigAll();
        return data($data, '查看所有配置');
    }

    /**
     * 根据配置键获取单个配置
     *
     * @param string $key
     */
    public function getConfigByKey(string $key)
    {
        list($note, $value) = LogicConfig::getConfigByKey($key);
        return data(['value' => $value], $note);
    }

    /**
     * 根据多个配置键获取多个配置
     *
     * @param array $keys
     */
    public function getBatchByKeys(array $keys)
    {
        $data = LogicConfig::getBatchByKeys($keys);
        return data($data, '获取成功');
    }

    /**
     * 获取一组配置
     *
     * @param string $type
     */
    public function getBatchByType(string $type)
    {
        $text = [
            'service_message' => '客服消息',
        ];
        $data = LogicConfig::getBatchByType($type);
        return data($data, $text[$type] ?? '获取成功');
    }
}
