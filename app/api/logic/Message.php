<?php

declare(strict_types=1);

namespace app\api\logic;

use app\common\lib\easywechat\MiniProgram;
use app\common\logic\Config as ConfigLogic;

/**
 * 客服消息逻辑层
 */
class Message
{
    /**
     * 文本消息
     */
    public static function text(array $message)
    {
        $program = app(MiniProgram::class);
        $program->replyText("恭喜，消息推送接入成功 ^_^\n\n欢迎使用微擎小程序TP6.0框架 !");
    }

    /**
     * 消息卡片
     */
    public static function card(array $message)
    {
        $program = app(MiniProgram::class);

        // 回复文字
        $text  = '长按识别下方二维码添加客服微信';
        $program->replyText($text);

        // 回复图片
        $image = ConfigLogic::getValueByKey('reply_img');
        $program->replyImg($image);

        // 消息日志
        // event('message', $message);
    }
}
