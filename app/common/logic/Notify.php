<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\lib\easywechat\Payment;

/**
 * 微信支付回调处理
 */
class Notify
{
    /**
     * 回调入口
     */
    public static function main()
    {
        self::getUniacid();
        $app = app(Payment::class)->app;
        $response = $app->handlePaidNotify(function ($message, $fail) {
            // file_put_contents(__DIR__ . '/1_message.log', var_export($message, true) . PHP_EOL, FILE_APPEND);
            // 你的逻辑
            return true;
            // 或者错误消息
            $fail('Order not exists.');
        });
        $response->send(); // Laravel 里请使用：return $response;
    }

    /**
     * 将附加数据中的微擎平台相关数据保存到全局变量$_W中
     */
    private static function getUniacid()
    {
        $xml    = file_get_contents('php://input');
        // file_put_contents(__DIR__ . '/1_xml.log', var_export($xml, true) . PHP_EOL, FILE_APPEND);
        $obj    = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $arr   = json_decode(json_encode($obj), true);
        if (isset($arr['attach'])) {
            $attach = queryStringToArray($arr['attach']);
            if (isset($attach['uniacid'])) {
                global $_W;
                $_W['uniacid'] = $attach['uniacid'];
                $_W['account']['key'] = $attach['appid'];
                $_W['account']['secret'] = $attach['secret'];
                // file_put_contents(__DIR__ . '/1_w.log', var_export($_W, true) . PHP_EOL, FILE_APPEND);
            }
        }
    }
}
