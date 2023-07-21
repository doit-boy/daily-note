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
use App\Schema\ChartMetaSchema;
use App\Schema\ChartSchema;
use App\Schema\TaskItemListSchema;
use App\Schema\TaskItemSchema;
use App\Service\Dao\TaskDao;
use App\Service\Dao\TaskItemDao;
use App\Service\Formatter\TaskItemFormatter;
use Carbon\Carbon;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;
use JetBrains\PhpStorm\ArrayShape;

class TaskItemService extends Service
{
    #[Inject]
    protected TaskItemDao $dao;

    #[Inject]
    protected TaskItemFormatter $formatter;

    public function index(int $taskId, int $userId, int $offset = 0, int $limit = 10): TaskItemListSchema
    {
        $task = di()->get(TaskDao::class)->first($taskId, true);
        if ($task->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        [$count, $models] = $this->dao->findByTaskId($taskId, $offset, $limit);

        return new TaskItemListSchema(
            $count,
            $this->formatter->formatList($models)
        );
    }

    public function chart(int $taskId, int $userId): ChartSchema
    {
        $task = di()->get(TaskDao::class)->first($taskId, true);
        if ($task->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        $models = di()->get(TaskItemDao::class)->queryByTaskId($taskId);
        if ($models->isEmpty()) {
            return new ChartSchema($task->name, []);
        }

        $first = $models->shift();
        $values = [
            new ChartMetaSchema($first->date, $first->value),
        ];
        foreach ($models as $model) {
            $values[] = new ChartMetaSchema($model->date, $model->value);
        }

        return new ChartSchema($task->name, array_values($values));
    }

    public function save(
        int $id,
        int $taskId,
        int $userId,
        #[ArrayShape(['value' => 'string', 'comment' => 'string'])]
        array $input
    ): bool {
        $task = di()->get(TaskDao::class)->first($taskId, true);
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

    public function info(int $id, int $userId): TaskItemSchema
    {
        $model = $this->dao->first($id, true);
        if ($model->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        return new TaskItemSchema($model);
    }

    public function delete(int $id, int $userId): bool
    {
        $model = $this->dao->first($id, true);
        if ($model->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        return $model->delete();
    }
}
