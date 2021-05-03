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
use think\facade\Filesystem;

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

    // +---------------------------------------------------------------
    // | 小程序码
    // +---------------------------------------------------------------
    // | https://www.easywechat.com/docs/4.x/mini-program/app_code
    // +---------------------------------------------------------------

    /**
     * 生成小程序码
     *
     * @param string $scene
     * @param string $page
     */
    public function getAppCode(string $scene, string $page)
    {
        try {
            $response = $this->miniProgram->app_code->getUnlimit($scene, [
                'page'  => $page,
            ]);
            // 保存小程序码到文件
            if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
                $path = Filesystem::getDiskConfig('miniCode', 'root');
                $filename = $response->save($path);
                return Filesystem::getDiskConfig('miniCode', 'url') . $filename;
            } else {
                fault(json_encode($response));
            }
        } catch (\Exception $e) {
            fault($e->getMessage());
        }

        // $response = $app->app_code->getUnlimit('scene-value', [
        //     'page'  => 'path/to/page',
        //     'width' => 600,
        // ]);
        // // $response 成功时为 EasyWeChat\Kernel\Http\StreamResponse 实例，失败为数组或你指定的 API 返回类型

        // // 保存小程序码到文件
        // if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
        //     $filename = $response->save('/path/to/directory');
        // }
        // // 或
        // if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
        //     $filename = $response->saveAs('/path/to/directory', 'appcode.png');
        // }
    }
}
