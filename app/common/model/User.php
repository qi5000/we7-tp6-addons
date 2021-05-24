<?php

declare(strict_types=1);

namespace app\common\model;

/**
 * 公共用户模型
 */
class User extends MicroEngine
{
    // 只读字段
    protected $readonly = ['openid'];

    // +---------------------------------------------------
    // | 搜索器
    // +---------------------------------------------------

    /**
     * 根据用户id搜索用户
     */
    public function searchIdAttr($query, $value, $data)
    {
        empty($value) || $query->where('id', $value);
    }

    /**
     * 根据用户昵称搜索用户
     */
    public function searchNickNameAttr($query, $value, $data)
    {
        $value !== '' && $query->whereLike('nickName', "%{$value}%");
    }

    /**
     * 根据用户性别搜索用户
     */
    public function searchGenderAttr($query, $value, $data)
    {
        $value !== '' && $query->where('gender', $value);
    }
}
