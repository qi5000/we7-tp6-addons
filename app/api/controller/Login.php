<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\User as UserLogic;

class Login
{
    /**
     * 小程序登录
     *
     * @param string $code jsCode
     */
    public function index(string $code)
    {
        $data = UserLogic::login($code);
        return data($data, '登录成功');
    }

    /**
     * 模拟登陆 开发环境使用
     *
     * @param integer $uid 用户id
     */
    public function simulate(int $uid)
    {
        $data = UserLogic::simulate($uid);
        return data($data, '模拟登陆成功');
    }
}
