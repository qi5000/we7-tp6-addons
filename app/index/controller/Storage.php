<?php

declare(strict_types=1);

namespace app\index\controller;

use app\index\logic\Storage as LogicStorage;

class Storage extends Base
{
    /**
     * 文件存储配置页
     */
    public function index()
    {
        list($storageType, $local, $kodo, $oss, $cos) = LogicStorage::getConfig();
        $localPath = \think\facade\Filesystem::getDiskConfig('w7', 'root');
        return view('config/storage', compact('localPath', 'storageType', 'local', 'kodo', 'oss', 'cos'));
    }

    /**
     * 更新文件存储配置项
     */
    public function update(array $data)
    {
        LogicStorage::update($data);
        return result('修改成功');
    }
}
