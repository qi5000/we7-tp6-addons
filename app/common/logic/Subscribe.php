<?php

declare(strict_types=1);

namespace app\common\logic;

use think\facade\Log;
use think\helper\Str;
use app\common\lib\easywechat\MiniProgram;

/**
 * 订阅消息
 */
class Subscribe
{
    // +----------------------------------------------------------------------
    // | 订阅消息使用场景
    // +----------------------------------------------------------------------

    /**
     * 使用示例
     *
     * @param string $openid 接收者openid
     * @param array  $param  页面路径参数数组
     */
    public static function demo(string $openid, array $param = [])
    {
        // 页面路径场景
        $pageScene = 'index';
        // 模板系统配置键
        $configKey = 'test';

        ############## 订阅消息数据格式 ##############
        $thing3 = '联系方式';
        $thing1 = '微擎小程序TP框架 ' . date('H:i:s');
        $data = [
            'thing3' => ['value' => self::thing($thing3)],
            'thing1' => ['value' => self::thing($thing1)],
        ];
        ############## 订阅消息数据格式 / ##############

        // 发送订阅消息
        return self::send($pageScene, $configKey, $param, $openid, $data);
    }

    // +----------------------------------------------------------------------
    // | 发送订阅消息
    // +----------------------------------------------------------------------

    /**
     * 发送订阅消息统一方法
     *
     * @param string $pageScene 页面路径场景(config/page.php数组索引)
     * @param string $configKey 订阅消息模板id系统配置键
     * @param array  $param     页面路径参数
     * @param string $openid    接收者用户openid
     * @param array  $data      订阅消息数据格式
     */
    protected static function send(string $pageScene, string $configKey, array $param, string $openid, array $data)
    {
        // 获取小程序页面路径和模板ID
        self::getPathAndTpl($page, $tplId, $pageScene, $configKey, $param);
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
        return $result;
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
     * @param string &$page  页面路径(如果有参数将携带参数)
     * @param string &$tplId 模板id
     * @param string $scene  页面路径
     * @param string $key    系统配置键
     * @param array  $param  页面路径参数
     */
    private static function getPathAndTpl(&$page, &$tplId, string $scene, string $key, array $param = [])
    {
        $page = config('page.' . $scene);
        empty($page) && fault($scene . ' 页面路径没有定义,请在config/page.php中定义');
        $param && self::queryString($page, $param);
        $tplId = Config::getValueByKey($key);
    }

    /**
     * 将参数拼接到页面路径
     *
     * @param string &$page 页面路径
     * @param array  $param 额外参数
     */
    private static function queryString(string &$page, array $param)
    {
        $link = queryString($param);
        $page = $link ? $page . '?' . $link : $page;
    }

    /**
     * 订阅消息发送记录日志
     *
     * @param array  $data 发送订阅消息结果
     * @param string $page 页面路径(包含参数)
     */
    private static function log(array $data, string $page)
    {
        $data['page'] = $page;
        Log::write(encode($data), 'subscribe');
    }

    // +----------------------------------------------------------------------
    // | 订阅消息消息队列任务逻辑示例
    // +----------------------------------------------------------------------

    /**
     * 任务执行逻辑示例 
     *
     * @param integer $activity_id
     */
    public static function drawNotice(int $activity_id)
    {
        fault('活动id: ' . $activity_id);
    }
}
