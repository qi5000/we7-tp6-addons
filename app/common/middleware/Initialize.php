<?php

declare(strict_types=1);

namespace app\common\middleware;

use liang\MicroEngine;
use think\facade\Cache;
use think\facade\Config;

/**
 * 全局中间件 初始化数据
 */
class Initialize
{
    // 初始化配置版本号
    private $version = '1.0.1';

    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if (MicroEngine::isMicroEngine()) {
            // 微擎版 兼容微擎多开
            $name = 'version_uniacid_' . MicroEngine::getUniacid();
        } else {
            // 独立版
            $name = 'version';
        }
        if (Cache::store('file')->get($name) != $this->version) {
            // 初始化配置入口
            $this->run();
            // 本次版本初始化纪录存入缓存
            Cache::store('file')->set($name, $this->version);
        }
        return $next($request);
    }

    /**
     * 初始化入口
     */
    private function run()
    {
        $array = [
            // 系统配置
            'config'  => \app\common\init\Config::class,
            // 文件存储配置
            'storage' => \app\common\init\Storage::class,
        ];
        foreach ($array as $key => $value) {
            $config = $this->getInitData($key);
            call_user_func([$value, 'init'], $config);
        }
    }

    // +-------------------------------------------------------------
    // | 功能封装
    // +-------------------------------------------------------------

    /**
     * 读取默认配置
     *
     * @param string $name
     */
    private function getInitData(string $name)
    {
        return Config::load('initial/' . $name, $name);
    }
}
