<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 客服会话待发送记录
 */
class MessagePush extends MicroEngine
{
    // 设置json类型字段
    protected $json = ['content'];
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;
}
