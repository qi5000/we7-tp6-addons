<?php

namespace app\index\controller;

use app\common\logic\Alone;

/**
 * index
 */
class Index extends Auth
{
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
