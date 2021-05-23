<?php

namespace app\api\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return msg('小程序接口请求成功');
    }
}
