<?php

declare(strict_types=1);

namespace app\common\logic;

use think\facade\Log;
use app\common\lib\easywechat\Payment as LibPayment;

/**
 * 获取微信支付参数
 */
class Payment
{
    /**
     * 创建开通会员订单
     *
     * @param array $data
     */
    public static function create(array $data)
    {
        // 使用示例
        // $data = [
        //     'total_fee' => 0.01,
        //     'openid'    => 'olCRt5W0cNgEh953SJBz20rio1fA',
        // ];
        // $result = LogicPayment::create($data);

        $body = '测试';
        $out_trade_no = md5(time() . mt_rand(1, 99999));
        try {
            $result = app(LibPayment::class)->unify($data['openid'], $out_trade_no, $data['total_fee'], $body);
        } catch (\Throwable $th) {
            $errMsg = ['error' => $th->getMessage()];
            Log::write(encode($errMsg), 'payment'); // 错误日志
            fault($th->getMessage()); //抛出错误
        }
        return $result;
    }
}
