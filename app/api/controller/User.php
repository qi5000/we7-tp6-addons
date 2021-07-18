<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\User as UserLogic;

class User extends Auth
{
    /**
     * 个人中心
     */
    public function getMine()
    {
        $data = UserLogic::getMine($this->uid);
        return data($data, '个人中心');
    }

    /**
     * wx.getUserProfile
     * 
     * 用户授权更新用户信息接口
     */
    public function update(array $data)
    {
        UserLogic::update($this->uid, $data);
        return data($data, '更新成功');
    }
}
