<?php

declare(strict_types=1);

namespace app\api\logic;

use app\common\logic\Config as ConfigLogic;
use app\common\model\MessagePush as MessagePushModel;

/**
 * 添加客服会话待发送记录
 */
class MessageRecord
{
    /**
     * 客服二维码
     */
    public static function service(int $uid)
    {
        $data = [
            'type'  => 1,
            'image' => ConfigLogic::getValueByKey('reply_img'),
        ];
        self::save($uid, $data);
    }

    // +------------------------------------------------------
    // | 添加记录
    // +------------------------------------------------------

    /**
     * 添加数据统一方法
     *
     * @param int   $uid  用户id
     * @param array $data 添加的数据
     */
    private static function save(int $uid, array $content)
    {
        $model = new MessagePushModel;
        // 启动事务
        $model->startTrans();
        try {
            $data = [
                'status'  => 0,
                'openid'  => User::getOpenidById($uid),
                'content' => $content,
            ];
            $model->save($data);
            $model->commit();
        } catch (\Exception $e) {
            $model->rollback();
            fault('添加失败');
        }
    }
}
