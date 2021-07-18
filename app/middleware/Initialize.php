<?php

declare(strict_types=1);

namespace app\middleware;

use liang\MicroEngine;
use think\facade\Cache;
use app\common\model\Config;
use app\common\model\Storage;
use app\common\logic\Initialize as LogicInitialize;


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
        halt(12);
        // config 系统配置 storage 云存储
        $method = ['config', 'storage'];
        foreach ($method as $value) $this->$value();
    }

    // +-------------------------------------------------------------
    // | 初始化操作
    // +-------------------------------------------------------------

    /**
     * 系统配置初始化
     */
    private function config()
    {
        // 读取系统配置
        $config = $this->getInitialConfig('config');
        foreach ($config as $value) {
            // 根据配置键查询配置
            $data = Config::key($value['key'])->findOrEmpty();
            // 配置项不存在就添加一个配置项
            $data->isEmpty() && $data->save($this->changeValue($value));
        }
    }

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

    /**
     * 改变配置值
     */
    private function changeValue($value)
    {
        if (empty($value['image'])) return $value;
        // 初始化图片地址
        $value['value'] = LogicInitialize::image($value['value'], $value['image']);
        // 选取需要写入系统配置表字段
        return $this->allowField($value);
    }

    /**
     * 获取数组指定键的数据
     * 
     * 指定写入的系统配置表的字段
     */
    private function allowField($value)
    {
        $keys = ['type', 'key', 'value', 'note'];
        $data = [];
        foreach ($keys as $field) {
            $data[$field] = $value[$field];
        }
        return $data;
    }
}
