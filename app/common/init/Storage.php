<?php

declare(strict_types=1);

namespace app\common\init;

use app\common\model\Storage as ModelStorage;

/**
 * 文件存储
 */
class Storage
{
    /**
     * 初始化配置
     *
     * @param array $data
     */
    public static function init(array $data)
    {
        foreach ($data as $value) {
            $model = ModelStorage::where('type', $value['type'])->findOrEmpty();
            $model->isEmpty() && $model->save($value);
        }
    }
}
