<?php

namespace app\admin\controller;

use app\BaseController;

/**
 * admin应用 前后端分离后台管理系统
 */
class Index extends BaseController
{
    public function index()
    {
        return msg('welcome to 微擎小程序TP6.0框架后台管理系统接口');
    }
}
