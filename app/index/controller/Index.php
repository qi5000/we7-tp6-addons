<?php

namespace app\index\controller;

use app\common\logic\Alone;
use app\api\logic\Subscribe;

/**
 * index
 */
class Index extends Auth
{
    public function index()
    {
        Subscribe::demo();

        // $nickname = Alone::getAdminName();
        // return view('', compact('nickname'));
    }

    /**
     * 控制台
     */
    public function console()
    {
        return view();
    }
}
