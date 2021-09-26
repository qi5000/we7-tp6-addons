<?php
// +----------------------------------------------------------------------
// | 队列任务基类
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

namespace app\queue\service;

use think\queue\Job;
use think\facade\Log;

/**
 * 执行队列任务基础类
 */
abstract class Base
{
    /**
     * 执行队列任务
     * 
     * @param Job   $job
     * @param array $data 自定义数据
     */
    protected function execute(Job $job, array $data, $scene, ...$class)
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
            // 调用任务逻辑方法
            call_user_func(...$class);
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
                $delay = 1; // 延迟时间
                $job->release($delay); //重新发布任务(1秒后)
            }
        }

        echo "～～～～～～ ⭐️ {$scene} 任务执行结束 ⭐️ ～～～～～～\n\n";
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
        echo json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL . PHP_EOL;
    }
}
