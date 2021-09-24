<?php

namespace app\queue\job;

use liang\MicroEngine;
use app\queue\service\Subscribe as ServiceSubscribe;

/**
 * 发布订阅消息相关消息队列任务
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
        $job = getJob(ServiceSubscribe::class, 'drawNotice');
        queue($job, $data, 0, MicroEngine::getModuleName());
        halt($data, MicroEngine::getModuleName());
    }
}
