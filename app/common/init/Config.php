<?php

declare(strict_types=1);

namespace app\common\init;

use app\common\logic\Initialize;
use app\common\model\Config as ModelConfig;

class Config
{
    /**
     * 初始化
     *
     * @param array $data
     */
    public static function init(array $data)
    {
        foreach ($data as $value) {
            // 根据配置键查询配置
            $data = ModelConfig::key($value['key'])->findOrEmpty();
            // 配置项不存在就添加一个配置项
            $data->isEmpty() && $data->save(self::changeValue($value));
        }
    }

    /**
     * 改变配置值
     *
     * @param array $value
     */
    private static function changeValue(array $value): array
    {
        if (empty($value['image'])) return $value;
        // 初始化图片地址
        $value['value'] = Initialize::image($value['value'], $value['image']);
        // 选取需要写入系统配置表字段
        return $value;
    }
}
