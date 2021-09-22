<?php

declare(strict_types=1);

namespace app\admin\logic;

use app\common\model\Config as ModelConfig;
use app\common\logic\Config as LogicConfig;

/**
 * 系统配置
 */
class Config extends LogicConfig
{
    /**
     * 更新配置
     *
     * @param array $data
     */
    public static function update(array $data)
    {
        foreach ($data as $key => $value) {
            $config = ModelConfig::where('key', $key)->findOrEmpty();
            $config->isEmpty() || $config->save(['value' => $value]);
        }
    }
}
