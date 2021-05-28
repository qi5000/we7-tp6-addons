<?php

declare(strict_types=1);

namespace app\api\logic;

use app\common\logic\Subscribe as LogicSubscribe;

class Subscribe extends LogicSubscribe
{
    /**
     * 使用示例
     */
    public static function demo(string $openid = 'oM9rw4gdW5I0IyANrtY1XqfENcMA')
    {
        $param = [];
        list($page, $tplId) = self::getPathAndTpl('index', 'test', $param);
        $thing1 = '今日未签到';
        $thing6 = '已连续签到5天';
        $thing4 = '签到领金币';
        $thing8 = '点击前往签到';
        $data = [
            'thing1' => ['value' => self::thing($thing1)],
            'thing6' => ['value' => self::thing($thing6)],
            'thing4' => ['value' => self::thing($thing4)],
            'thing8' => ['value' => self::thing($thing8)],
        ];
        self::send($tplId,  $openid,  $page,  $data);
    }
}
