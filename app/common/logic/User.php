<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\model\User as ModelUser;

/**
 * 用户相关
 */
class User
{
    /**
     * 获取openid
     *
     * @param integer $uid 用户id
     */
    public static function getOpenidById(int $uid)
    {
        $user = ModelUser::findOrEmpty($uid);
        $user->isEmpty() && fault('用户不存在');
        return $user->openid;
    }

    /**
     * 获取会话密钥session_key
     *
     * @param integer $uid 用户id
     */
    public static function getSessionKeyById(int $uid)
    {
        $user = ModelUser::findOrEmpty($uid);
        $user->isEmpty() && fault('用户不存在');
        return $user->session_key;
    }
}
