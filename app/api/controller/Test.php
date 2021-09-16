<?php

declare(strict_types=1);

namespace app\api\controller;

use think\facade\Log;

use app\common\logic\Payment as LogicPayment;

class Test
{
    public function index()
    {
        $data = [
            'total_fee' => 0.01,
            'openid'    => 'olCRt5W0cNgEh953SJBz20rio1fA',
        ];
        $result = LogicPayment::create($data);
        halt($result);
    }
}
