<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\logic\User as LogicUser;

class User
{
    /**
     * 获取用户列表
     *
     * @param array   $where
     * @param integer $page
     * @param integer $limit
     */
    public function getLists(array $where = [], int $page = 1, int $limit = 10)
    {
        $data = LogicUser::getLists($where, $page, $limit);
        return data($data, '用户列表');
    }
}
