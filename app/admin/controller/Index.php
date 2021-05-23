<?php

namespace app\admin\controller;

use app\BaseController;
use app\common\lib\easywechat\Payment;
use app\common\lib\easywechat\MiniProgram;

/**
 * admin 应用
 * 后台管理系统
 */
class Index extends BaseController
{
    public function index()
    {
        halt(app(Payment::class)->app);
        halt(app(MiniProgram::class)->app);
        halt(MiniProgram::replyApi());
        return '后台管理系统主页';
    }
}
