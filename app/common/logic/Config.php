<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\model\Config as ConfigModel;

/**
 * 系统配置
 * 公共逻辑层
 */
class Config
{
    // +------------------------------------------------
    // | 查询系统配置
    // +------------------------------------------------

    /**
     * 根据键名查询配置项
     *
     * @param string $key 键名
     */
    public static function getByKey(string $key)
    {
        $data = ConfigModel::key($key)->findOrEmpty();
        if ($data->isEmpty()) fault('该配置项不存在');
        return $data->value;
    }

    /**
     * 根据配置组名称查询配置项
     *
     * @param string $type 配置组名称
     */
    public static function getByType(string $type)
    {
        $data = ConfigModel::type($type)->select();
        if ($data->isEmpty()) fault('该配置组不存在');
        return $data->column('value', 'key');
    }
}
