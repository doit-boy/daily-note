<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Service\Dao;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\TaskItem;
use Carbon\Carbon;
use Han\Utils\Service;

class TaskItemDao extends Service
{
    public function first(int $id, bool $throw = false): ?TaskItem
    {
        $model = TaskItem::findFromCache($id);
        if (! $model && $throw) {
            throw new BusinessException(ErrorCode::TASK_ITEM_NOT_EXIST);
        }

        return $model;
    }

    public function firstToday(int $taskId): ?TaskItem
    {
        return TaskItem::query()->where('task_id', $taskId)
            ->where('date', Carbon::today()->toDateString())
            ->first();
    }
}
