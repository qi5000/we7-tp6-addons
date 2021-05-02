<?php

declare(strict_types=1);

namespace app\api\lib;

use EasyWeChat\Kernel\Messages\Image;

/**
 * 小程序消息推送
 */
class Message
{
    // 小程序应用实例
    public static $app;

    /**
     * 构造方法
     * 初始化配置参数
     */
    public function __construct()
    {
        global $_W;
        $config = [
            'app_id' => $_W['account']['key'],
            'secret' => $_W['account']['secret'],
            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                // 'file' => __DIR__ . '/wechat.log',
            ],
        ];
        self::$app = \EasyWeChat\Factory::miniProgram($config);
    }

    /**
     * 消息推送接入验证
     * 开发者服务器接收消息推送
     */
    public static function checkSignature(string $token)
    {
        $nonce     = $_GET["nonce"] ?? '';
        $signature = $_GET["signature"] ?? '';
        $timestamp = $_GET["timestamp"] ?? '';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode('', $tmpArr);
        $tmpStr = trim(sha1($tmpStr));
        if (empty($token)) die('未设置消息推送token令牌');
        if (empty($signature) || empty($tmpStr) || empty($nonce)) die('非法请求！！！');
        if ($tmpStr != $signature) die('签名验证错误');
        isset($_GET['echostr']) ? die($_GET['echostr']) : new self;
    }

    /**
     * 回复文本消息
     *
     * @param string $openid 接收者openid
     * @param string $text   回复的文本内容
     */
    public static function replyText(string $openid, string $text)
    {
        self::$app->customer_service->message($text)->to($openid)->send();
    }

    /**
     * 回复图片消息
     *
     * @param string $openid 接收者openid
     * @param string $image  图片绝对路径
     */
    public static function replyImg(string $openid, string $image)
    {
        // 上传临时素材
        $result = self::$app->media->uploadImage($image);
        $content = new Image($result['media_id']);
        self::$app->customer_service->message($content)->to($openid)->send();
    }
}
