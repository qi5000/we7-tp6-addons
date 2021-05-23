<?php

namespace app\admin\controller;

use app\BaseController;

/**
 * admin应用 后台管理系统
 */
class Index extends BaseController
{
    public function index()
    {
        return 'welcome to 微擎小程序模块 TP6.0 框架';
    }

    public function test()
    {
        return msg('后台管理系统接口请求成功');
    }
}
