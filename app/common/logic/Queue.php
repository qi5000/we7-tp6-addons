<?php

declare(strict_types=1);

namespace app\common\logic;

use app\common\lib\Queue as LibQueue;

/**
 * 发布任务逻辑层
 */
class Queue
{
    /**
     * 发布测试任务
     */
    public static function test($id)
    {
        $data = ['name' => '张三', 'time' => time()];
        $job = LibQueue::getJob(\app\queue\Task::class, 'fire');
        \think\facade\Queue::push($job, $data, 'abc');
    }
}
