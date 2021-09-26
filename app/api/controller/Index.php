<?php

namespace app\api\controller;

/**
 * 小程序首页
 */
class Index extends Auth
{
    public function index()
    {
        return success('小程序接口请求成功');
    }
}
