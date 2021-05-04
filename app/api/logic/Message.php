<?php

declare(strict_types=1);

namespace app\api\logic;

/**
 * 客服消息逻辑层
 */
class Message
{
    /**
     * 小程序消息推送
     * 客服会话自动回复消息
     */
    public static function reply()
    {
        // 用户发送的消息数据包
        $message = json_decode(file_get_contents('php://input'), true);
        // 接收者用户openid
        $openid = $message['FromUserName'];
        // 根据用户发送不同类型的内容回复不同的消息
        switch ($message['MsgType']) {
            case 'miniprogrampage': // 小程序卡片
                // 回复文字
                $text  = '自动回复文字';
                app('EasyWeChat')->replyText($openid, $text);
                // 自动回复图片
                $image = '绝对路径图片地址';
                // 发送图片消息
                app('EasyWeChat')->replyImg($openid, $image);
                break;
        }
        app('EasyWeChat')->miniProgram->server->serve()->send();
    }
}
