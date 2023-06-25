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
use App\Constants\Status;
use App\Exception\BusinessException;
use App\Model\Task;
use Han\Utils\Service;
use Hyperf\Collection\Collection;

class TaskDao extends Service
{
    public function first(int $id, bool $throw = false): ?Task
    {
        $model = Task::findFromCache($id);
        if (! $model && $throw) {
            throw new BusinessException(ErrorCode::TASK_NOT_EXIST);
        }

        return $model;
    }

    /**
     * @return array{int, Collection<int, Task>}
     */
    public function find(int $userId, int $offset, int $limit): array
    {
        $query = Task::query()->where('user_id', $userId)
            ->where('is_deleted', Status::NO)
            ->orderBy('id', 'desc');

        return $this->factory->model->pagination($query, $offset, $limit);
    }
}
