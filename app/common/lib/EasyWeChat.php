<?php

// +---------------------------------------------------------------
// | EasyWeChat 功能封装 已通过服务系统绑定到容器
// +---------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +---------------------------------------------------------------
// | $app = app('EasyWeChat')->payment; //微信支付实例
// +---------------------------------------------------------------
// | $app = app('EasyWeChat')->miniProgram;//微信小程序实例
// +---------------------------------------------------------------

declare(strict_types=1);

namespace app\common\lib;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Image;
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

    // +-----------------------------------------------------------------------------
    // | 获取 EasyWeChat 相关操作的实例
    // +-----------------------------------------------------------------------------

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
                // 'file' => __DIR__ . '/wechat.log',
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

    // +-------------------------------------------------------------------------------------
    // | 小程序登录
    // +-------------------------------------------------------------------------------------
    // | https://www.easywechat.com/docs/5.x/mini-program/auth
    // +-------------------------------------------------------------------------------------

    /**
     * 根据 jsCode 获取用户 session 信息
     *
     * @param string $code
     */
    public function login(string $code)
    {
        // 返回示例
        // $res = [
        //     'session_key' => '5qpyH6pz1Xjuyg3rZ0KD8A==',
        //     'openid'      => 'oNiWa5CB9VFKgr-TqssteGoieibY',
        // ];
        // $res = [
        //     'errcode' => '40029',
        //     'errmsg'  => 'invalid code, hints: [ req_id: 3Ibcf2LnRa-lgVExa ]',
        // ];
        return $this->miniProgram->auth->session($code);
    }

    // +-----------------------------------------------------------------------------
    // | 小程序码
    // +-----------------------------------------------------------------------------
    // | https://www.easywechat.com/docs/4.x/mini-program/app_code
    // +-----------------------------------------------------------------------------

    /**
     * 生成小程序码
     *
     * @param string $page         页面路径
     * @param string|array $scene  场景(额外参数)
     * @param string $type         小程序码类型(目录名)
     */
    public function miniCode(string $page, $scene, string $type = '')
    {
        // 小程序码存放目录
        $path = $this->getStoragePath($type);
        // 数组数据转为查询字符串
        if (is_array($scene)) $scene = $this->queryString($scene);
        // 小程序码已存在就不再重复生成
        if (file_exists($path . '/' . $scene . '.jpg')) {
            $filename = $scene . '.jpg';
            return $this->getCodeUrl($filename, $type);
        }
        // 小程序码不存在时就生成
        try {
            $response = $this->miniProgram->app_code->getUnlimit($scene, [
                'page'  => $page,
            ]);
            if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
                // 保存小程序码到本地服务器
                $filename = $response->save($path, $scene);
                // 返回可访问的小程序码URL地址
                return $this->getCodeUrl(strval($filename), $type);
            } else {
                fault($response['errmsg'], $response['errcode']);
            }
        } catch (\Exception $e) {
            fault($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 获取小程序码存放目录
     *
     * @param string $type
     */
    private function getStoragePath(string $type)
    {
        return Filesystem::getDiskConfig('miniCode', 'root') . ($type ? '/' . $type : '');
    }

    /**
     * 返回小程序码URL地址
     *
     * @param string $filename
     * @param string $type
     */
    private function getCodeUrl(string $filename, string $type)
    {
        $type =  $type ? ltrim($type, '/') . '/' : '';
        return Filesystem::getDiskConfig('miniCode', 'url') . $type . $filename;
    }

    /**
     * 数组数据转为查询字符串
     *
     * @param array $data
     */
    private function queryString(array $data)
    {
        $link = '';
        foreach ($data as $key => $value) {
            $link .= $key . '=' . $value . '&';
        }
        return rtrim($link, '&');
    }

    // +-----------------------------------------------------------------------------
    // | 客服消息
    // +-----------------------------------------------------------------------------
    // | https://www.easywechat.com/docs/4.x/official-account/messages
    // +-----------------------------------------------------------------------------

    /**
     * 消息推送接入验证
     * 开发者服务器接收消息推送
     */
    public function checkSignature(string $token)
    {
        $nonce     = $_GET["nonce"] ?? '';
        $signature = $_GET["signature"] ?? '';
        $timestamp = $_GET["timestamp"] ?? '';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode('', $tmpArr);
        $tmpStr = trim(sha1($tmpStr));
        if (empty($token)) die('未设置消息推送token令牌');
        if (empty($signature) || empty($tmpStr) || empty($nonce)) die('非法请求！！！');
        if ($tmpStr != $signature) die('签名验证错误');
        isset($_GET['echostr']) ? die($_GET['echostr']) : new self;
    }

    /**
     * 获取客服消息会话接口地址
     */
    public function replyApi()
    {
        $module  = module();
        $uniacid = getUniacid();
        $domain  = request()->domain();
        return "{$domain}/app/index.php?i={$uniacid}&c=entry&m={$module}&a=wxapp&do=api&s=/customer/index";
    }

    /**
     * 回复文本消息
     *
     * @param string $openid 接收者openid
     * @param string $text   回复的文本内容
     */
    public function replyText(string $openid, string $text)
    {
        $this->miniProgram->customer_service->message($text)->to($openid)->send();
    }

    /**
     * 回复图片消息
     *
     * @param string $openid 接收者openid
     * @param string $image  图片绝对路径
     */
    public function replyImg(string $openid, string $image)
    {
        // 上传临时素材
        $result = $this->miniProgram->media->uploadImage($image);
        $content = new Image($result['media_id']);
        $this->miniProgram->customer_service->message($content)->to($openid)->send();
    }

    // +-----------------------------------------------------------------------------
    // | 订阅消息
    // +-----------------------------------------------------------------------------
    // | https://www.easywechat.com/docs/4.x/mini-program/subscribe_message
    // +-----------------------------------------------------------------------------

    /**
     * 发送订阅消息
     *
     * @param string $tplId
     * @param string $openid
     * @param string $page
     * @param array $data
     */
    public function subscribeMessage(string $tplId, string $openid, string $page, array $data)
    {
        $data = [
            'template_id' => $tplId,    // 所需下发的订阅模板id
            'touser'      => $openid,   // 接收者（用户）的 openid
            'page'        => $page,     // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'data'        => $data,
        ];
        // 返回一个数组
        return $this->miniProgram->subscribe_message->send($data);
    }
}
