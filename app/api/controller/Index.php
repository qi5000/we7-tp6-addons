<?php

namespace app\api\controller;

/**
 * 首页数据
 */
class Index extends Auth
{
    public function index()
    {
        return success('欢迎使用微擎小程序TP6.0框架 ^_^');
    }
}
