<?php

// +---------------------------------------------------------------
// | 绑定到容器
// +---------------------------------------------------------------
// | 'EasyWeChat' => app\api\lib\EasyWeChat::class,
// +---------------------------------------------------------------
// | 调用示例
// +---------------------------------------------------------------
// | $app = app('EasyWeChat')->payment;
// +---------------------------------------------------------------
// | $app = app('EasyWeChat')->miniProgram;
// +---------------------------------------------------------------

declare(strict_types=1);

namespace app\api\lib;

use EasyWeChat\Factory;

/**
 * EasyWeChat 功能封装
 */
class EasyWeChat
{
    // 微信支付
    public $payment;
    // 小程序相关
    public $miniProgram;

    /**
     * 构造方法生成相关操作实例
     */
    public function __construct()
    {
        // 微信支付
        $this->getPayment();
        // 小程序相关
        $this->getMiniProgram();
    }

    // +---------------------------------------------------------------
    // | 获取 EasyWeChat 相关操作的实例
    // +---------------------------------------------------------------

    /**
     * 小程序相关操作所需实例
     */
    private function getMiniProgram()
    {
        global $_W;
        $config = [
            'app_id' => $_W['account']['key'],
            'secret' => $_W['account']['secret'],
            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log',
            ],
        ];
        $this->miniProgram = Factory::miniProgram($config);
    }

    /**
     * 微信支付相关操作所需实例
     */
    private function getPayment()
    {
        $config = [
            // 必要配置
            'app_id'             => 'xxxx',
            'mch_id'             => 'your-mch-id',
            'key'                => 'key-for-signature',   // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！

            'notify_url'         => '默认的订单回调地址',     // 你也可以在下单时单独设置来想覆盖它
        ];
        $this->payment = Factory::payment($config);
    }
}
