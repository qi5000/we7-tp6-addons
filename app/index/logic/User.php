<?php

declare(strict_types=1);

namespace app\index\logic;

use app\index\model\User as ModelUser;

class User
{
    /**
     * 获取用户列表
     */
    public static function getList(array $where, int $page = 1, int $limit = 10)
    {
        $where = where_filter($where, $fields);
        $count = ModelUser::withSearch($fields, $where)->count();
        $list = ModelUser::withSearch($fields, $where)->page($page, $limit)->select();
        return [$count, $list];
    }
}
