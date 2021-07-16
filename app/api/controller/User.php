<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\User as UserLogic;

class User extends Auth
{
    /**
     * wx.getUserProfile
     * 
     * 用户授权更新用户信息接口
     */
    public function update(array $data)
    {
        halt($this->uid);
        UserLogic::update($this->uid, $data);
        return success('更新成功');
    }
}
