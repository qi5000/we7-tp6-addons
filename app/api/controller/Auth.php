<?php

declare(strict_types=1);

namespace app\api\controller;

use app\BaseController;
use app\api\lib\JwtAuth;

/**
 * JWT鉴权控制器
 * 
 * @author liang 23426945@qq.com
 */
class Auth extends BaseController
{
    /**
     * 校验token是否有效
     */
    protected function initialize()
    {
        // 接收请求头中的Token
        $token = request()->header('token');
        // 初步校验token
        empty($token) && fault('token不能为空');
        // 解析token,返回生成token时的附加数据
        $this->jwt = app(JwtAuth::class)->decode($token)->data;
        // 获取JWt附加数据中的用户id并转为整型
        $this->uid = (int) $this->jwt->uid;
        // 携带的token缓存中的token进行比对(单点登录校验)
        app(JwtAuth::class)->checkToken($this->uid, $token) || fault('登录状态已过期', 401);
    }
}
