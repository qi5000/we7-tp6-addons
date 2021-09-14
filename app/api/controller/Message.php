<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\logic\MessageRecord as MessageRecordLogic;

/**
 * 客服会话
 */
class Message extends Auth
{
    /**
     * 获取客服二维码
     */
    public function service()
    {
        MessageRecordLogic::service($this->uid);
        return success('操作成功');
    }
}
