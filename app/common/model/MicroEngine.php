<?php

declare(strict_types=1);

namespace app\common\model;

use liang\MicroEngine as MicroEngineHelper;

/**
 * 微擎基础模型
 */
class MicroEngine extends Base
{
    // 微擎平台uniacid
    protected static $uniacid;
    // 定义全局的查询范围
    protected $globalScope = ['uniacid'];

    // +------------------------------------------------
    // | 模型初始化
    // +------------------------------------------------

    protected static function init()
    {
        if (MicroEngineHelper::isMicroEngine()) {
            global $_W;
            self::$uniacid = $_W['uniacid'];
        }
    }

    // +------------------------------------------------
    // | 全局查询范围
    // +------------------------------------------------

    /**
     * 只查询当前平台下的数据
     */
    public function scopeUniacid($query)
    {
        if (MicroEngineHelper::isMicroEngine()) {
            $query->where('uniacid', self::$uniacid);
        }
    }

    // +------------------------------------------------
    // | 模型事件
    // +------------------------------------------------

    /**
     * 新增前
     */
    public static function onBeforeInsert($model)
    {
        if (MicroEngineHelper::isMicroEngine()) {
            $model->uniacid = self::$uniacid;
        }
    }
}
