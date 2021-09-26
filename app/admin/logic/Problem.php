<?php

declare(strict_types=1);

namespace app\admin\logic;

use app\common\model\Problem as ModelProblem;
use app\common\model\ProblemClassify as ModelClassify;

/**
 * 常见问题
 */
class Problem
{
    /**
     * 获取常见问题列表
     *
     * @param array   $where
     * @param integer $page
     * @param integer $limit
     */
    public static function getLists(array $where, int $page, int $limit): array
    {
        $where = where_filter($keys, $where);
        $model = ModelProblem::withSearch($keys, $where);
        $count = $model->count();
        $list  = $model->with([
            'classify' => function ($query) {
                $query->bind(['classify_name' => 'name']);
            }
        ])->order('sort', 'desc')->select()->hidden(['create_time', 'delete_time'])->toArray();
        return compact('count', 'list');
    }

    /**
     * 添加问题
     *
     * @param array $data
     */
    public static function save(array $data)
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
    public static function read(int $id)
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
    public static function update(int $id, array $data)
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
    public static function delete($id)
    {
        if (is_array($id)) {
            // 批量删除
            ModelProblem::destroy($id);
        } else {
            // 单个删除
            $model = ModelProblem::findOrEmpty($id);
            $model->isEmpty() && fault('数据不存在');
            $model->delete();
        }
    }

    // +----------------------------------------------------------------
    // | 问题分类
    // +----------------------------------------------------------------

    /**
     * 获取问题分类列表
     *
     * @param array   $where
     * @param integer $page
     * @param integer $limit
     */
    public static function getClassifyLists(array $where, int $page, int $limit)
    {
        $where = where_filter($keys, $where);
        $model = ModelClassify::withSearch($keys, $where)->scope('sort');
        $count = $model->count();
        $list = $model->page($page, $limit)->select()->hidden([
            'create_time', 'delete_time'
        ])->toArray();
        return compact('count', 'list');
    }

    /**
     * 选择分类
     */
    public static function selectClassify()
    {
        $data = ModelClassify::field('id,name')
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
        $model = ModelClassify::where('name', $data['name'])->findOrEmpty();
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
    public static function readClassify(int $id)
    {
        $model = ModelClassify::findOrEmpty($id);
        $model->isEmpty() && fault('数据不存在');
        return $model->toArray();
    }

    /**
     * 更新分类
     *
     * @param integer $id
     * @param array   $data
     */
    public static function updateClassify(int $id, array $data)
    {
        $model = ModelClassify::findOrEmpty($id);
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
    public static function deleteClassify($id)
    {
        if (is_array($id)) {
            // 批量删除
            ModelClassify::destroy($id);
        } else {
            // 单个删除
            $model = ModelClassify::findOrEmpty($id);
            $model->isEmpty() && fault('数据不存在');
            $model->delete();
        }
    }
}
