<?php

declare(strict_types=1);

namespace app\admin\logic;

use app\common\model\Problem as ModelProblem;
use app\common\model\ProblemClassify as ModelProblemClassify;

/**
 * 常见问题
 */
class Problem
{
    /**
     * 获取问题列表
     */
    public static function getLists(int $page, int $limit): array
    {
        $model = ModelProblem::with([
            'classify' => function ($query) {
                $query->bind(['classify_name' => 'name']);
            }
        ]);
        $count = $model->count();
        $list  = $model->order('sort', 'desc')->select()->hidden([
            'create_time', 'delete_time'
        ])->toArray();
        return compact('count', 'list');
    }

    /**
     * 添加问题
     *
     * @param array $data
     */
    public static function save(array $data): void
    {
        $model = new ModelProblem;
        // 启动事务
        $model->startTrans();
        try {
            $model->save($data);
            $model->commit();
        } catch (\Exception $e) {
            $model->rollback();
            fault('添加失败');
        }
    }

    /**
     * 编辑问题
     *
     * @param integer $id
     */
    public static function read(int $id): array
    {
        $model = ModelProblem::findOrEmpty($id);
        $model->isEmpty() && fault('数据不存在');
        return $model->toArray();
    }

    /**
     * 更新问题
     *
     * @param integer $id
     * @param array   $data
     */
    public static function update(int $id, array $data): void
    {
        $model = ModelProblem::findOrEmpty($id);
        $model->isEmpty() && fault('数据不存在');
        $model->save($data);
    }

    /**
     * 删除问题
     *
     * @param int|array $id
     */
    public static function delete($id): void
    {
        if (is_array($id)) {
            $model = ModelProblem::whereIn('id', $id)->findOrEmpty();
        } else {
            $model = ModelProblem::findOrEmpty($id);
        }
        $model->isEmpty() && fault('数据不存在');
        $model->delete();
    }

    // +----------------------------------------------------------------
    // | 问题分类
    // +----------------------------------------------------------------

    /**
     * 分类列表
     *
     * @param integer $page
     * @param integer $limit
     */
    public static function getClassifyLists(int $page = 1, int $limit = 10)
    {
        $model = ModelProblemClassify::scope('sort');
        $count = $model->count();
        $list = $model->page($page, $limit)->select()->hidden([
            'create_time', 'delete_time'
        ])->toArray();
        return compact('count', 'list');
    }

    /**
     * 选择分类
     */
    public static function selectClassify(): array
    {
        $data = ModelProblemClassify::field('id,name')
            ->scope('sort')
            ->select();
        return $data->toArray();
    }

    /**
     * 添加分类
     *
     * @param array $data
     */
    public static function saveClassify(array $data)
    {
        $model = ModelProblemClassify::where('name', $data['name'])->findOrEmpty();
        $model->isEmpty() || fault('该分类名称已存在');
        // 启动事务
        $model->startTrans();
        try {
            $model->save($data);
            $model->commit();
        } catch (\Exception $e) {
            $model->rollback();
            fault('添加失败');
        }
    }

    /**
     * 编辑分类
     *
     * @param integer $id
     */
    public static function readClassify(int $id): array
    {
        $model = ModelProblemClassify::findOrEmpty($id);
        $model->isEmpty() && fault('数据不存在');
        return $model->toArray();
    }

    /**
     * 更新分类
     *
     * @param integer $id
     * @param array   $data
     */
    public static function updateClassify(int $id, array $data): void
    {
        $model = ModelProblemClassify::findOrEmpty($id);
        $model->isEmpty() && fault('数据不存在');
        // 启动事务
        $model->startTrans();
        try {
            $model->save($data);
            $model->commit();
        } catch (\Exception $e) {
            $model->rollback();
            fault('添加失败');
        }
    }

    /**
     * 删除分类
     *
     * @param int|array $id
     */
    public static function deleteClassify($id): void
    {
        if (is_array($id)) {
            $model = ModelProblemClassify::whereIn('id', $id)->findOrEmpty();
        } else {
            $model = ModelProblemClassify::findOrEmpty($id);
        }
        $model->isEmpty() && fault('数据不存在');
        $model->delete();
    }
}
