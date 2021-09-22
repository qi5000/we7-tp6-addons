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
    public static function getLists(): array
    {
        $list = ModelStorage::order('type', 'asc')->select();
        $type = ModelStorage::where('in_use', 1)->value('type');
        return compact('type', 'list');
    }

    /**
     * 更新文件存储配置
     *
     * @param int $type 0 本地 1 七牛云 2 阿里云
     */
    public static function update(int $type, array $data): void
    {
        in_array($type, [0, 1, 2]) || fault('type值非法');
        foreach ($data as $value) {
            $value['in_use'] = 0;
            ModelStorage::update($value, ['id' => $value['id']]);
        }
        ModelStorage::where('type', $type)->update(['in_use' => 1]);
    }
}
