<?php

// +---------------------------------------------------------------
// | EasyWeChat 微信支付相关功能封装
// +---------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +---------------------------------------------------------------

declare(strict_types=1);

namespace app\common\lib\easywechat;

use think\facade\Log;
use liang\MicroEngine;
use EasyWeChat\Factory;
use app\common\logic\Config as LogicConfig;

/**
 * 微信支付
 */
class Payment
{
    public $app;

    /**
     * 构造方法生成相关操作实例
     */
    public function __construct()
    {
        // 小程序APPID和开发者密钥
        $miniProgram = MicroEngine::getMiniProgramConfig();
        // 微信商户号相关配置
        $wechatMerch = LogicConfig::getBatchByType('merchant');
        $config = [
            // 必要配置
            'app_id'     => $miniProgram['appid'],       // 小程序APPID
            'mch_id'     => $wechatMerch['mch_id'],      // 商户号ID
            'key'        => $wechatMerch['mch_key'],     // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径
            'cert_path'  => $wechatMerch['cert_path'],   // XXX: 绝对路径！！！！
            'key_path'   => $wechatMerch['key_path'],    // XXX: 绝对路径！！！！
            'notify_url' => MicroEngine::getNotifyUrl(), // 默认的订单回调地址,你也可以在下单时单独设置来想覆盖它
        ];
        $this->app = Factory::payment($config);
    }

    // +-----------------------------------------------------------------------------
    // | 小程序统一下单
    // +-----------------------------------------------------------------------------
    // | https://www.easywechat.com/4.x/payment/order.html
    // +-----------------------------------------------------------------------------

    /**
     * 统一下单
     *
     * @param $openid
     * @param $out_trade_no 商家订单号
     * @param $total_fee    订单金额(元)
     * @param $body         备注
     * @param $notify       回调地址
     * @param $attach       附加数据
     */
    public function unify($openid, $out_trade_no, $total_fee, $body, $notify = null, $attach = [])
    {
        $config = MicroEngine::getMiniProgramConfig();
        $extra = [
            'appid'   => $config['appid'],
            'secret'  => $config['secret'],
        ];
        if (MicroEngine::isMicroEngine()) {
            // 在微擎中
            $extra['uniacid'] = MicroEngine::getUniacid();
        }
        $attach = array_merge($attach, $extra);
        // 支付参数
        $jssdk = $this->app->jssdk;
        $attributes = [
            'trade_type'   => 'JSAPI',
            'openid'       => $openid,
            'out_trade_no' => $out_trade_no,
            'total_fee'    => $total_fee * 100,
            'body'         => $body,
            'attach'       => queryString($attach),
        ];
        if (!is_null($notify)) {
            $attributes['notify_url'] = $notify;
        }
        $result = $this->app->order->unify($attributes);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $prepayId = $result['prepay_id'];
            $config   = $jssdk->sdkConfig($prepayId);
            $config['timeStamp'] = $config['timestamp'];
            return $config;
        }
        if ($result['return_code'] == 'FAIL' && array_key_exists('return_msg', $result)) {
            fault($result['return_msg']);
        }
        fault($result['err_code_des']);
    }

    // +-----------------------------------------------------------------------------
    // | 企业付款到零钱
    // +-----------------------------------------------------------------------------
    // | https://www.easywechat.com/4.x/payment/transfer.html
    // +-----------------------------------------------------------------------------

    /**
     * 企业付款到零钱
     *
     * @param   $trade_no 商家订单号
     * @param   $openid   用户openid
     * @param   $amount   提现金额,单位:元
     * @param   $desc     备注
     */
    public function toBalance($trade_no, $openid, $amount, $desc = '提现')
    {
        try {
            // 商户证书未配置会抛出异常
            // SSL certificate not found
            $result = $this->app->transfer->toBalance([
                'partner_trade_no' => $trade_no,      // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
                'openid'           => $openid,        // 提现用户openid
                'check_name'       => 'NO_CHECK',     // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
                're_user_name'     => '王小帅',        // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
                'amount'           => $amount * 100,  // 企业付款金额，单位为分
                'desc'             => $desc,          // 企业付款操作说明信息。必填
            ]);
            Log::write(encode($result), 'withdraw');
        } catch (\Throwable $th) {
            Log::write(encode(['error' => $th->getMessage()]), 'withdraw');
            fault($th->getMessage());
        }
        return $result;
    }

    // +-----------------------------------------------------------------------------
    // | 退款
    // +-----------------------------------------------------------------------------
    // | https://www.easywechat.com/4.x/payment/refund.html
    // +-----------------------------------------------------------------------------

    /**
     * 根据商户订单号退款
     *
     * @param string  $number           商户订单号
     * @param string  $refundNumber     商户退款单号
     * @param integer $totalFee         订单金额
     * @param integer $refundFee        退款金额
     * @param string  $refund_desc      退款说明
     */
    public function byOutTradeNumber(string $number, string $refundNumber, int $totalFee, int $refundFee, string $refund_desc = '退款')
    {
        // 参数分别为：商户订单号、商户退款单号、订单金额、退款金额、其他参数
        return $this->app->refund->byOutTradeNumber($number, $refundNumber, $totalFee, $refundFee, [
            'refund_desc' => $refund_desc,
        ]);
    }
}
