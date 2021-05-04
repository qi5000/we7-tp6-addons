<?php

declare(strict_types=1);

namespace app\api\controller;

/**
 * JWT验证基础控制器
 */
class JwtAuth extends Base
{
    /**
     * 校验token是否有效
     */
    protected function initialize()
    {
        // 接收Token
        $token = request()->header('token');
        // 解析token,返回生成token时的附加数据
        $this->jwt = app('jwt')->decode($token)->data;
        // 携带的token缓存中的token进行比对
        app('jwt')->checkToken($this->jwt->uid, $token) || fault('登录过期', 401);
    }

    /**
     * 获取jwt中的附加数据中的某一项
     *
     * @param string $name
     */
    public function getJwtData(string $name)
    {
        try {
            $value = $this->jwt->$name;
        } catch (\Exception $e) {
            fault($e->getMessage(), 999);
        }
        return $value;
    }
}
