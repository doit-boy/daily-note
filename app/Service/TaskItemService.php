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
namespace App\Service;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\TaskItem;
use App\Service\Dao\TaskDao;
use App\Service\Dao\TaskItemDao;
use Carbon\Carbon;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;
use JetBrains\PhpStorm\ArrayShape;

class TaskItemService extends Service
{
    #[Inject]
    protected TaskItemDao $dao;

    public function save(
        int $id,
        int $userId,
        #[ArrayShape(['task_id' => 'integer', 'value' => 'string', 'comment' => 'string'])]
        array $input
    ): bool {
        $task = di()->get(TaskDao::class)->first($input['task_id'], true);
        if ($task->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        if ($id > 0) {
            $model = $this->dao->first($id, true);
        } else {
            $model = $this->dao->firstToday($task->id);
            if (! $model) {
                $model = new TaskItem();
                $model->user_id = $userId;
                $model->task_id = $task->id;
                $model->date = Carbon::today()->toDateString();
            }
        }

        if ($model->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        $model->value = $input['value'];
        $model->comment = $input['comment'] ?? '';
        return $model->save();
    }
}
