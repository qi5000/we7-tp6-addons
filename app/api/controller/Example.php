<?php

// +----------------------------------------------------------------------
// | 本控制器只为测试功能
// +----------------------------------------------------------------------

declare(strict_types=1);

namespace app\api\controller;

use app\common\logic\Subscribe;
use app\common\logic\Payment as LogicPayment;

/**
 * 使用示例
 */
class Example
{
    public $openid = 'olCRt5W0cNgEh953SJBz20rio1fA';

    /**
     * 订阅消息
     */
    public function subscribe()
    {
        // 发送订阅消息
        // $data = Subscribe::demo($this->openid, ['id' => 1, 'uid' => 6]);
        $data = Subscribe::demo($this->openid);
        return json($data);
    }

    /**
     * 获取支付参数
     */
    public function payment()
    {
        $data = [
            'total_fee' => 0.01,
            'openid'    => $this->openid,
        ];
        $params = LogicPayment::create($data);
        return data($params, '支付参数');
    }

    public function notify()
    {
        \app\common\logic\Notify::main();
    }

    /**
     * 提现
     */
    public function withdraw()
    {
        $amount = 0.3;
        $result = LogicPayment::toBalance($this->openid, $amount);
        halt($result);
    }
}
