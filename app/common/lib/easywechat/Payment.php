<?php

// +---------------------------------------------------------------
// | EasyWeChat 微信支付相关功能封装
// +---------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +---------------------------------------------------------------

declare(strict_types=1);

namespace app\common\lib\easywechat;

use EasyWeChat\Factory;
use app\common\logic\Alone;

class Payment
{
    // 微信支付
    public $app;

    /**
     * 构造方法生成相关操作实例
     */
    public function __construct()
    {
        // 获取小程序APPID和开发者密钥
        $miniProgram = Alone::getMiniProgramConfig();
        $config = [
            // 必要配置
            'app_id'     => $miniProgram['appid'], //小程序APPID
            'mch_id'     => 'your-mch-id',         //商户号ID
            'key'        => 'key-for-signature',   // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'  => 'path/to/your/cert.pem',   // XXX: 绝对路径！！！！
            'key_path'   => 'path/to/your/key',        // XXX: 绝对路径！！！！
            'notify_url' => '默认的订单回调地址',               // 你也可以在下单时单独设置来想覆盖它
        ];
        $this->app = Factory::payment($config);
    }
}
