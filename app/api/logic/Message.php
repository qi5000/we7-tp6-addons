<?php

declare(strict_types=1);

namespace app\api\logic;

use app\api\lib\Message as LibMessage;

/**
 * 小程序消息推送逻辑层
 */
class Message
{
    /**
     * 小程序消息推送
     * 客户会话回复消息
     */
    public static function reply($token)
    {
        // 服务器接入验证
        LibMessage::checkSignature($token);
        // 用户发送的消息数据包
        $message = json_decode(file_get_contents('php://input'), true);
        // 接收者用户openid
        $openid = $message['FromUserName'];
        // 根据用户发送不同类型的内容回复不同的消息
        switch ($message['MsgType']) {
            case 'miniprogrampage': // 小程序卡片
                // 回复文字
                $text  = '自动回复文字';
                LibMessage::replyText($openid, $text);
                // 自动回复图片
                $image = '绝对路径图片地址';
                // 发送图片消息
                LibMessage::replyImg($openid, $image);
                break;
        }
        LibMessage::$app->server->serve()->send();
    }
}
