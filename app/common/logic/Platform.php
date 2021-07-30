<?php

declare(strict_types=1);

namespace app\common\logic;

use think\facade\Db;
use liang\MicroEngine;
use app\common\model\Platform as ModelPlatform;

class Platform
{
    /**
     * 初始化平台数据
     * 
     * 返回当前平台是否已绑定单开 true 已绑定 false 未绑定
     */
    public static function initData()
    {
        if (MicroEngine::isMicroEngine()) {
            global $_W;
            $platform = ModelPlatform::where('uniacid', $_W['uniacid'])->findOrEmpty();
            $isAccountWxapp = Db::connect('w7')->table(tablename('account_wxapp'))->where('uniacid', $_W['uniacid'])->find();
            // 当前平台是小程序并且平台信息表中没有当前平台数据
            if ($isAccountWxapp && $platform->isEmpty()) {
                $data = [
                    'uniacid' => $_W['uniacid'],
                    'name'    => $_W['account']['name'],
                    'status'  => ModelPlatform::count() > 0 ? 0 : 1,
                ];
                $platform->save($data);
            }
        }
        return $platform->status == 1;
    }

    /**
     * 获取多开平台信息
     *
     * @param integer $page
     * @param integer $limit
     */
    public static function getLists(int $page, int $limit)
    {
        $uniacids = ModelPlatform::column('uniacid');
        $query = Db::connect('w7')->table(tablename('account_wxapp'))->field('uniacid,name')->whereIn('uniacid', $uniacids);
        $count = $query->count();
        $data = $query->page($page, $limit)->select()->toArray();
        foreach ($data as &$value) {
            $value['status'] = ModelPlatform::where('uniacid', $value['uniacid'])->value('status');
        }
        return compact('count', 'data');
    }

    /**
     * 切换绑定的平台
     *
     * @param integer $uniacid
     */
    public static function bind(int $uniacid)
    {
        ModelPlatform::where('uniacid', $uniacid)->update(['status' => 1]);
        ModelPlatform::where('uniacid', '<>', $uniacid)->update(['status' => 0]);
        return success('切换绑定成功');
    }
}
