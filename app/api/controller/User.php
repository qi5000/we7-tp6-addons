<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\User as UserLogic;

class User extends JwtAuth
{
    /**
     * wx.getUserProfile
     * 
     * 用户授权更新用户信息接口
     */
    public function update(array $data)
    {
        $uid = $this->getJwtData('uid');
        UserLogic::update($uid, $data);
        msg('更新成功');
    }
}
