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
    // +---------------------------------------------------------
    // | 获取微信支付参数
    // +---------------------------------------------------------

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

        $body = '开通会员';
        $trade_no = self::ordersn('TX');
        try {
            $result = app(LibPayment::class)->unify($data['openid'], $trade_no, $data['total_fee'], $body);
        } catch (\Throwable $th) {
            $errMsg = ['error' => $th->getMessage()];
            Log::write(encode($errMsg), 'payment'); // 错误日志
            fault($th->getMessage()); //抛出错误
        }
        return $result;
    }

    // +---------------------------------------------------------
    // | 企业付款到零钱
    // +---------------------------------------------------------

    /**
     * 用户提现
     *
     * @param $openid   提现用户openid
     * @param $amount   提现金额,单位:元
     */
    public static function toBalance($openid, $amount)
    {
        $trade_no = self::ordersn('TX');
        return app(LibPayment::class)->toBalance($trade_no, $openid, $amount);
    }

    /**
     * 随机生成20位数字订单号(18位:不包含前缀)
     * @param string $prefix 订单号前缀
     * @return string 随机订单号
     */
    private static function ordersn(string $prefix = '')
    {
        return $prefix . date('YmdHis') . substr(implode("", array_map('ord', str_split(substr(uniqid(), 7,  13), 1))), 0, 2) . mt_rand(1000, 9999);
    }
}
