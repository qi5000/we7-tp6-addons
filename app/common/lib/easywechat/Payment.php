<?php

// +---------------------------------------------------------------
// | EasyWeChat 微信支付相关功能封装
// +---------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +---------------------------------------------------------------

declare(strict_types=1);

namespace app\common\lib\easywechat;

use liang\MicroEngine;
use EasyWeChat\Factory;
use app\common\logic\Config as LogicConfig;

/**
 * 微信支付
 */
class Payment
{
    // 微信支付
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
}
