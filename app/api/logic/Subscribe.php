<?php

declare(strict_types=1);

namespace app\api\logic;

use app\common\logic\Subscribe as LogicSubscribe;

/**
 * 订阅场景定义
 */
class Subscribe extends LogicSubscribe
{
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
}
