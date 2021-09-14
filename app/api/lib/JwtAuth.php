<?php

declare(strict_types=1);

namespace app\api\lib;

use Firebase\JWT\JWT;

/**
 * JWT 功能封装
 * 
 * composer require firebase/php-jwt
 */
class JwtAuth
{
    /**
     * 初始化配置
     */
    public function __construct()
    {
        $this->iss    = config('jwt.iss');     //签发者 可选
        $this->aud    = config('jwt.aud');     //接收该JWT的一方，可选
        $this->exp    = config('jwt.exp');     //过期时间,864000秒 = 10天
        $this->key    = config('jwt.key');     //访问秘钥
        $this->prefix = config('jwt.prefix');  //缓存前缀
    }

    // +------------------------------------------------------------------
    // | 生成、解析Token
    // +------------------------------------------------------------------

    /**
     * 创建token
     *
     * @param array $data
     * @return string
     */
    public function encode(array $data)
    {
        $time = time(); //当前时间
        $token = [
            'iss'  => $this->iss,           //签发者 可选
            'aud'  => $this->aud,           //接收该JWT的一方，可选
            'iat'  => $time,                //签发时间
            'nbf'  => $time,                //(Not Before)：某个时间点后才能访问,比如设置time+30，表示当前时间30秒后才能使用
            'exp'  => $time + $this->exp,   //过期时间
            'data' => $data,                //附加数据
        ];
        return JWT::encode($token, $this->key); //输出Token
    }

    /**
     * 解析token
     *
     * @param string $token
     */
    public function decode(string $token)
    {
        try {
            JWT::$leeway = 0; //当前时间减去60，把时间留点余地
            return JWT::decode($token, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应
        } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            fault('签名不正确');
        } catch (\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            fault('登录未生效');
        } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
            fault('登录过期');
        } catch (\Exception $e) {  //其他错误
            fault($e->getMessage());
        }
    }

    // +------------------------------------------------------------------
    // | 缓存相关
    // +------------------------------------------------------------------

    /**
     * 用户token存入缓存
     *
     * @param integer $id   用户id
     * @param string $token 服务器端生成的token
     */
    public function cache(int $id, string $token)
    {
        // 缓存token
        cache($this->prefix . $id, $token);
    }

    /**
     * 检测token是否有效
     *
     * @param integer $id    用户id
     * @param string  $token 前端发送的token
     */
    public function checkToken(int $id, string $token)
    {
        // 缓存token
        $cacheToken = cache($this->prefix . $id);
        // true 有效 false 过期
        return $token === $cacheToken;
    }
}
