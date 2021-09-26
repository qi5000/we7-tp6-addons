<?php

declare(strict_types=1);

namespace app\admin\logic;

use app\common\model\Storage as ModelStorage;

/**
 * 文件存储
 */
class Storage
{
    /**
     * 获取文件存储配置
     */
    public static function getLists()
    {
        $list = ModelStorage::order('type', 'asc')->select();
        $type = ModelStorage::where('in_use', 1)->value('type');
        return compact('type', 'list');
    }

    /**
     * 更新文件存储配置
     *
     * @param int $type 0 本地 1 七牛云 2 阿里云 3 腾讯云
     */
    public static function update(int $type, array $data)
    {
        in_array($type, [0, 1, 2, 3]) || fault('type值非法');
        $model = ModelStorage::findOrEmpty($data['id']);
        // 启动事务
        $model->startTrans();
        $model->isEmpty() && fault('数据不存在');
        try {
            ModelStorage::where('type', '<>', $type)->update(['in_use' => 0]);
            $data['in_use'] = 1;
            $model->save($data);
            $model->commit();
        } catch (\Exception $e) {
            $model->rollback();
            fault('修改失败');
        }
    }
}
