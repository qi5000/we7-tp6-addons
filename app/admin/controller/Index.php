<?php

namespace app\admin\controller;

use liang\MicroEngine;
use app\BaseController;
use app\common\logic\Platform as PlatformLogic;


/**
 * 后台管理系统
 */
class Index extends BaseController
{
    /**
     * 单入口文件渲染
     */
    public function index()
    {
        // 检测扩展是否开启
        if ($this->checkExtension() === false) return;

        // 初始化平台数据(限制多开)
        if (MicroEngine::isMicroEngine() && !PlatformLogic::initData()) {
            global $_W;
            $data = [
                // 当前平台名称
                'account_name' => $_W['account']['name'],
                // 当前模块名称
                'mobule_name' => $_W['current_module']['title'],
            ];
            return view('/limit', compact('data'));
        } else {
            // 后台主页
            $eid        = input('eid', '', 'trim');
            $version_id = input('version_id', '', 'trim');
            return view('/index', compact('eid', 'version_id'));
        }
    }

    /**
     * 微擎版权
     */
    public function copyright()
    {
        global $_W;
        // 处理编辑器报红   
        defined('IMS_VERSION') or define('IMS_VERSION', '1.0.0');
        $data =  [
            'username' => $_W['user']['username'] ?? 'develop',
            'version'  => 'v' . IMS_VERSION . ' 2014-' . date('Y'),
        ];
        return data($data, '微擎版权');
    }

    /**
     * 检测所需扩展是否已经开启
     */
    private function checkExtension()
    {
        $off = true;
        $extension = ['curl'];
        foreach ($extension as $value) {
            if (!extension_loaded($value)) {
                $off = false;
                echo $value . ' 扩展未开启<br>';
            }
        }
        return $off;
    }
}
