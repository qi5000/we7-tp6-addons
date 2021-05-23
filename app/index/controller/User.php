<?php

declare(strict_types=1);

namespace app\index\controller;

use app\index\lib\Layui;
use app\index\logic\User as LogicUser;

class User extends Base
{
    /**
     * 数据表格接口
     *
     * @param integer $page  页码
     * @param integer $limit 每页数据条数
     */
    public function data(int $page = 1, int $limit = 10)
    {
        $where = Layui::search('id,nickName,gender');
        list($count, $data) = LogicUser::getList($where, $page, $limit);
        return Layui::dataTable('用户列表', $count, $data);
    }
}
