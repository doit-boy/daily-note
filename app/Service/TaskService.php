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
use App\Model\Task;
use App\Schema\TaskListSchema;
use App\Schema\TaskSchema;
use App\Service\Dao\TaskDao;
use App\Service\Formatter\TaskFormatter;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;
use JetBrains\PhpStorm\ArrayShape;

class TaskService extends Service
{
    #[Inject]
    protected TaskDao $dao;

    #[Inject]
    protected TaskFormatter $formatter;

    public function index(int $userId, int $offset = 0, int $limit = 10): TaskListSchema
    {
        [$count, $models] = $this->dao->find($userId, $offset, $limit);

        return new TaskListSchema(
            $count,
            $this->formatter->formatList($models)
        );
    }

    public function info(int $id, int $userId): TaskSchema
    {
        $model = $this->dao->first($id, true);
        if ($model->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        return new TaskSchema($model);
    }

    public function save(
        int $id,
        int $userId,
        #[ArrayShape(['name' => 'string', 'summary' => 'string'])]
        array $input = []
    ): bool {
        if ($id > 0) {
            $model = $this->dao->first($id, true);
            if ($model->user_id !== $userId) {
                throw new BusinessException(ErrorCode::PERMISSION_DENY);
            }
        } else {
            $model = new Task();
            $model->user_id = $userId;
        }

        $model->name = $input['name'];
        $model->summary = $input['summary'];
        return $model->save();
    }
}
