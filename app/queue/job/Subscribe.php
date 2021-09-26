<?php
// +----------------------------------------------------------------------
// | 发布订阅消息队列任务
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

namespace app\queue\job;

use app\queue\service\Subscribe as ServiceSubscribe;

/**
 * 订阅消息
 */
class Subscribe
{
    /**
     * 开奖通知(使用示例)
     */
    public static function drawNotice(int $activity_id)
    {
        $data = [
            'appid'       => 'wx43994',
            'scerct'      => 'dgwassgas',
            'activity_id' => $activity_id,
        ];
        addQueue(ServiceSubscribe::class, 'drawNotice', $data);
    }
}
