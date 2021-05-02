<?php

// +----------------------------------------------------------------------
// | 文件存储封装类
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------

namespace Storage;

abstract class Base
{
    abstract function upload(string $name);

    // +------------------------------------------------
    // | 设置文件存储目录
    // +------------------------------------------------

    /**
     * 本地存储
     * 文件存储在本地服务器
     */
    public function localPath()
    {
        return \think\facade\Filesystem::getDiskConfig('w7', 'root');
    }

    /**
     * 云存储
     */
    public function storagePath()
    {
        return implode('/', [$this->module(), $this->uniacid(), date('Ymd')]);
    }

    // +------------------------------------------------
    // | 上传文件中需要的功能方法
    // +------------------------------------------------

    /**
     * 返回文件在云存储中的存放路径
     */
    public function buildSaveName($file)
    {
        // 生成随机文件名
        $filename = sha1(date('YmdHis', time()) . uniqid() . mt_rand(1, 1e9)) . '.' . $file->getOriginalExtension();
        // 在云存储中的存放路径
        return $this->storagePath() . '/' . $filename;
    }

    /**
     * 判断是否有上传文件
     * 
     * @param $name 文件域字段名
     */
    public function isUpload(string $name)
    {
        // 判断是否有文件上传
        // $file = $this->isUpload($name);
        // if ( ! $file instanceof \think\file\UploadedFile ) return $file;
        try {
            $file = request()->file($name);
            if (!$file) throw new Exception('没有文件上传');
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
        return $file;
    }

    // +------------------------------------------------
    // | 上传接口统一返回值
    // +------------------------------------------------

    /**
     * 上传成功
     */
    public function msg(string $url, string $msg = '上传成功', int $code = 1)
    {
        return json(compact('code', 'msg', 'url'));
    }

    /**
     * 上传失败
     */
    public function fail(string $msg = '上传失败', int $code = 0)
    {
        return json(compact('code', 'msg'));
    }

    // +------------------------------------------------
    // | 微擎相关功能方法
    // +------------------------------------------------

    /**
     * 获取当前模块标识
     */
    private function module()
    {
        global $_W;
        return $_W['current_module']['name'];
    }

    /**
     * 获取当前微擎平台uniacid
     */
    protected function uniacid()
    {
        global $_W;
        return $_W['uniacid'];
    }

    // +------------------------------------------------
    // | 查看配置
    // +------------------------------------------------

    public function showConfig()
    {
        return [
            // 本地存储目录
            'localPath'   => $this->localPath(),
            // 云存储文件路径
            'storagePath' => $this->storagePath(),
        ];
    }
}
