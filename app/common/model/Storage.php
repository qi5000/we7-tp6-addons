<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 云存储模型
 */
class Storage extends MicroEngine
{
    // 只读字段
    protected $readonly = ['uniacid', 'type'];
}
