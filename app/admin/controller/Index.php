<?php

namespace app\admin\controller;

use app\BaseController;
use app\common\logic\Platform as PlatformLogic;
use liang\MicroEngine;

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
        }
        // 后台主页
        return view('/index');
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
}
