<?php
// +----------------------------------------------------------------------
// | 执行订阅消息消息队列任务
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

namespace app\queue\service;

use think\queue\Job;
use app\common\logic\Subscribe as LogicSubscribe;

/**
 * 订阅消息
 */
class Subscribe extends Base
{
    /**
     * 队列任务
     *
     * @param Job   $job
     * @param array $data 自定义数据
     */
    public function drawNotice(Job $job, array $data)
    {
        $scene = '新活动提醒通知';
        $class = [[LogicSubscribe::class, 'drawNotice'], $data['activity_id']];
        $this->execute($job, $data, $scene, ...$class); // 执行任务
    }
}
