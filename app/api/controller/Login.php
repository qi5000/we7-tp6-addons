<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\User as UserLogic;

class Login
{
    /**
     * 小程序登录接口
     */
    public function index(string $code)
    {
        $data = UserLogic::login($code);
        return data($data, '登录成功');
    }
}
