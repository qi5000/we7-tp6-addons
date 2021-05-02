<?php

declare(strict_types=1);

namespace app\middleware;

use think\facade\Cache;
use app\common\model\Storage;

/**
 * 初始化数据
 * 全局中间件
 */
class Initialize
{
    // 初始化配置版本号
    private $version = '1.0.0';

    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if (Cache::store('file')->get('version') != $this->version) {
            // 初始化配置入口
            $this->run();
            // 本次版本初始化纪录存入缓存
            Cache::store('file')->set('version', $this->version);
        }
        return $next($request);
    }

    /**
     * 初始化入口
     */
    public function run()
    {
        // 云存储
        $this->storage();
    }

    // +-------------------------------------------------------------
    // | 初始化操作
    // +-------------------------------------------------------------

    /**
     * 云存储配置初始化
     */
    private function storage()
    {
        // 读取系统配置
        $config = $this->getInitialConfig('storage');
        foreach ($config as $value) {
            $data = Storage::type($value['type'])->findOrEmpty();
            if ($data->isEmpty()) $data->save($value);
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
    private function getInitialConfig(string $name)
    {
        return \think\facade\Config::load('initial/' . $name, $name);
    }
}
