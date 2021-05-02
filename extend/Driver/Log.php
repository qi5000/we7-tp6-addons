<?php

declare(strict_types=1);

namespace Driver;

use think\contract\LogHandlerInterface;

/**
 * 自定义日志驱动
 */
class Log implements LogHandlerInterface
{
    /**
     * 构造方法
     */
    public function __construct()
    {
        // 获取日志通道配置信息
        $this->config = \think\facade\Log::getChannelConfig('W7');
    }

    /**
     * 保存日志
     * @param array $data
     */
    public function save(array $data): bool
    {
        foreach ($data as $type => $item) {
            foreach ($item as $value) {
                $this->write($type, ['type' => $type, 'value' => $value]);
            }
        }
        return true;
    }

    /**
     * 执行写入文件
     * @param [type] $type
     * @param [type] $data
     * @return void
     */
    public function write($type, $data)
    {
        $path = implode('/', [$this->config['path'], $type . '.log']);
        if (!file_exists(dirname($path))) mkdir(dirname($path), 0777, true);
        $content = '------------ ' . date('Y-m-d H:i:s') . ' ------------' . PHP_EOL . PHP_EOL . var_export($data, true) . PHP_EOL . PHP_EOL;
        file_put_contents($path, $content, FILE_APPEND);
    }
}
