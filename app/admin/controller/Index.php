<?php

namespace app\admin\controller;

use app\BaseController;

/**
 * 后台管理系统入口
 */
class Index extends BaseController
{
    public function index()
    {
        return view('/index');
    }
}
