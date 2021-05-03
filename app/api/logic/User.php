<?php

declare(strict_types=1);

namespace app\api\logic;

use app\api\model\User as UserModel;

class User
{
    /**
     * 小程序登录逻辑
     *
     * @param string $code
     */
    public static function login(string $code)
    {
        // 根据 jsCode 获取用户 session 信息
        $res = app('EasyWeChat')->login($code);
        // 判断是否有错误发生
        if (isset($res['errcode'])) fault($res['errmsg'], $res['errcode']);
        // 根据openid查询用户
        $user = UserModel::where('openid', $res['openid'])->findOrEmpty();
        // 启动事务
        $user->startTrans();
        try {
            // 创建、更新用户
            $user->save($res);
            $user->commit();
        } catch (\Exception $e) {
            $user->rollback();
            fault('登录失败');
        }
        $data  = [
            'token'    => md5(strval($user->id)),
            'uid'      => $user->id,
            'userinfo' => $user->toArray(),
        ];
        return $data;
    }
}
