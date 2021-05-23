<?php

declare(strict_types=1);

namespace app\index\logic;

use app\index\model\Storage as ModelStorage;

class Storage
{
    /**
     * 获取文件存储配置
     */
    public static function getConfig()
    {
        $data = ModelStorage::order('type', 'asc')->select();
        $array = [];
        for ($i = 0; $i < 4; $i++) {
            $config = $data->where('type', $i)->toArray()[$i];
            array_push($array, $config);
            // 当前使用的存储类型type值
            $config['in_use'] == 1 && array_unshift($array, $config['type']);
        }
        return $array;
    }

    /**
     * 修改七牛云配置
     *
     * @param array $data
     */
    public static function update(array $data)
    {
        $model = ModelStorage::findOrEmpty($data['id']);
        $model->startTrans();
        try {
            $model->update(['in_use' => 0]);
            $data['in_use'] = 1;
            $model->force()->save($data);
            $model->commit();
        } catch (\Exception $e) {
            $model->rollback();
            fault($e->getMessage)();
        }
    }
}
