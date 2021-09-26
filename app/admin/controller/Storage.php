<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\logic\Storage as LogicStorage;

/**
 * 文件存储
 */
class Storage
{
    /**
     * 获取文件存储配置
     */
    public function getLists()
    {
        $data = LogicStorage::getLists();
        return data($data, '文件存储配置');
    }

    /**
     * 更新文件存储配置
     *
     * @param integer $type 0 本地 1 七牛云 2 阿里云
     * @param array   $data 文件存储配置
     */
    public function update(int $type, array $data)
    {
        $data = LogicStorage::update($type, $data);
        return success('修改成功');
    }
}
