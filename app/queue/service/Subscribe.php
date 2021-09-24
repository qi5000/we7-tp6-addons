<?php

namespace app\queue\service;

use think\queue\Job;
use think\facade\Log;
use app\common\logic\Subscribe as LogicSubscribe;

/**
 * 执行订阅消息相关消息队列任务
 */
class Subscribe
{
    /**
     * 队列任务
     * @param Job $job
     * @param [type] $data 自定义数据
     */
    public function drawNotice(Job $job, $data)
    {
        $scene = '新活动提醒通知';
        $class = [[LogicSubscribe::class, 'drawNotice'], $data['activity_id']];
        $this->execute($job, $data, $scene, ...$class); // 执行任务
    }

    /**
     * 队列任务
     * @param Job $job
     * @param [type] $data 自定义数据
     */
    public function execute(Job $job, $data, $scene, ...$class)
    {
        echo "\n～～～～～～ ⭐️ {$scene} 开始执行任务 ⭐️ ～～～～～～\n\n";

        // 消息队列日志
        $log = [
            'scene'    => $scene,
            'state'    => '',
            'attempts' => $job->attempts(),
            'msg'      => '',
            'name'     => $job->getName(),
            'data'     => $data,
        ];

        //....这里执行具体的任务
        try {
            $this->json($data);
            // 任务逻辑
            call_user_func(...$class);
            // fault('法外狂徒张三' . mt_rand(100, 999));
            // 消息队列执行日志
            $log['state'] = 'success';
            $log['msg'] = '任务执行成功';
            Log::write(encode($log), 'queue');
            // 任务执行成功则删除任务
            $job->delete();
        } catch (\Throwable $th) {
            // 消息队列执行日志
            $msg = $th->getMessage();
            $log['msg'] = $msg;
            $log['state'] = 'fault';
            Log::write(encode($log), 'queue');
            $this->json(['state' => '任务执行中发生异常', 'exception' => $msg]);
            // $job->attempts() 当前任务执行次数
            if ($job->attempts() > 2) {
                // 如果任务执行成功后 记得删除任务，
                // 不然这个任务会重复执行，直到达到最大重试次数后失败后，执行failed方法
                $job->delete();
            } else {
                // 重新发布任务
                $delay = 1;
                $job->release($delay); //$delay为延迟时间
            }
        }

        echo "\n～～～～～～ ⭐️ {$scene} 任务执行结束 ⭐️ ～～～～～～\n\n";
    }

    /**
     * 任务执行失败时触发
     */
    public function failed($data)
    {
        // 任务达到最大重试次数后，失败了
    }

    /**
     * 执行任务时输出自定义数据
     */
    private function json($data)
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
}
