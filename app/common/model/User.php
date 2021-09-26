<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 用户模型
 */
class User extends MicroEngine
{
    // 只读字段
    protected $readonly = ['uniacid', 'openid'];

    // +---------------------------------------------------
    // | 搜索器
    // +---------------------------------------------------

    /**
     * 根据用户昵称搜索
     */
    public function searchNickNameAttr($query, $value, $data)
    {
        $query->whereLike('nickName', '%' . $value . '%');
    }

    /**
     * 根据注册时间范围查询
     */
    public function searchCreateTimeRangeAttr($query, $value, $data)
    {
        $query->whereBetweenTime('create_time', ...$value);
    }
}
