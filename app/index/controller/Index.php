<?php

namespace app\index\controller;

use app\common\logic\Alone;

/**
 * 混编后台管理系统
 */
class Index extends Auth
{
    /**
     * 主页
     */
    public function index()
    {
        $nickname = Alone::getAdminName();
        return view('', compact('nickname'));
    }

    /**
     * 控制台
     */
    public function console()
    {
        return view();
    }
}
