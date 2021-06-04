<?php

namespace app\queue;

use think\queue\Job;
use think\facade\Log;

class Task
{
    /**
     * 队列任务
     * @param Job $job
     * @param [type] $data 自定义数据
     */
    public function fire(Job $job, $data)
    {
        //....这里执行具体的任务
        try {
            $this->json($data);
            $log = [
                'data'     => $data,
                'attempts' => $job->attempts(),
            ];
            ######## 执行任务逻辑 ########
            $rand = mt_rand(1, 10);
            $log['rand'] = $rand;
            $result = $rand > 5;
            if ($result) throw new \Exception('执行任务发生错误');
            ######## 执行任务逻辑 / ########
            $log['message'] = '任务执行成功';
            // Log::channel('queue')->success($log);
            $job->delete();
        } catch (\Throwable $th) {
            $log['errMsg'] = $th->getMessage();
            $this->json(['err' => $th->getMessage()]);
            // Log::channel('queue')->error($log);
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
    }

    /**
     * 任务执行失败时触发
     */
    public function failed($data)
    {
        // 任务达到最大重试次数后，失败了
        $data['message'] = '任务执行失败';
        // Log::channel('queue')->failed($data);
    }

    /**
     * 执行任务时输出自定义数据
     */
    public function json($data)
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
}
