<?php

declare(strict_types=1);

namespace app\common\logic;

use think\facade\Log;
use think\helper\Str;
use app\common\lib\easywechat\MiniProgram;

/**
 * 订阅消息公共逻辑
 */
class Subscribe
{
    /**
     * 发送订阅消息统一方法
     *
     * @param string $tplId
     * @param string $openid
     * @param string $page
     * @param array  $data
     */
    protected static function send(string $tplId, string $openid, string $page, array $data)
    {
        try {
            // 模板ID、openid 为空时会抛出异常
            $result = app(MiniProgram::class)->subscribeMessage($tplId, $openid, $page, $data);
        } catch (\Throwable $th) {
            $result = [
                'msg'    => '系统异常',
                'errmsg' => $th->getMessage(),
            ];
        }
        // 写入日志文件
        self::log($result, $page);
    }

    // +----------------------------------------------------------------------
    // | 订阅消息参数值内容限制处理
    // +----------------------------------------------------------------------

    /**
     * thing.DATA
     * 
     * 20个以内字符 可汉字、数字、字母或符号组合
     */
    protected static function thing(string $value, int $length = 20)
    {
        if (Str::length($value) > $length) {
            $value = Str::substr($value, 0, $length - 3) . '...';
        }
        return $value;
    }

    // +----------------------------------------------------------------------
    // | 功能方法
    // +----------------------------------------------------------------------

    /**
     * 获取小程序页面路径和模板ID
     *
     * @param string $scene 小程序页面路径配置键
     * @param string $key   系统配置key
     * @param array  $param 页面路径参数
     */
    protected static function getPathAndTpl(string $scene, string $key, array $param = [])
    {
        $page = config('page.' . $scene);
        $param && self::queryString($page, $param);
        return [$page, Config::getByKey($key)];
    }

    /**
     * 将额外的参数以查询字符串的形式拼接到页面路径中
     *
     * @param string $page
     * @param array  $param
     */
    protected static function queryString(string &$page, array $param)
    {
        $link = '';
        foreach ($param as $key => $value) {
            $link .= $key . '=' . $value . '&';
        }
        return rtrim($link, '&');
    }

    /**
     * 订阅消息发送记录日志
     *
     * @param array $data
     */
    protected static function log(array $data, $page)
    {
        $data['page'] = $page;
        Log::record(json_encode($data, JSON_UNESCAPED_UNICODE), 'subscribe');
    }
}
