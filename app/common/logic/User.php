<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\model\User as ModelUser;

class User
{
    /**
     * 获取用户openid
     *
     * @param integer $uid 用户id
     */
    public static function getOpenidById(int $uid)
    {
        $user = ModelUser::findOrEmpty($uid);
        $user->isEmpty() && fault('用户不存在');
        return $user->openid;
    }
}
