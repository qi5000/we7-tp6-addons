<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\User as UserLogic;

class User
{
    /**
     * 用户授权
     * 更新用户信息
     */
    public function update(array $data)
    {
        UserLogic::update(1, $data);
        msg('更新成功');
    }
}
