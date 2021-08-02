<?php

declare(strict_types=1);

namespace app\common\init;

use app\common\model\Storage as ModelStorage;

class Storage
{
    /**
     * 文件存储初始化
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
