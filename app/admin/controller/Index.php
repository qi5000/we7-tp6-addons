<?php

namespace app\admin\controller;

use app\BaseController;

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
