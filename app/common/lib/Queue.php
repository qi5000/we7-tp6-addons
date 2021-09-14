<?php

declare(strict_types=1);

namespace app\common\lib;

/**
 * 消息队列
 */
class Queue
{
    /**
     * 获取任务对象
     * 发布任务时使用
     * @param string $class
     * @param string $action
     * @return string app\queue\task@fire
     */
    public static function getJob(string $class, string $action)
    {
        // 使用示例
        // $delay = 10;
        // $job = Queue::getJob(\app\queue\Task::class, 'fire');
        // \think\facade\Queue::later($delay, $job, $data);
        return implode('@', [strtolower($class), $action]);
    }
}
