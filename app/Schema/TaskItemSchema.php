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

namespace App\Schema;

use App\Model\TaskItem;
use Carbon\Carbon;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '任务记录详情')]
class TaskItemSchema implements JsonSerializable
{
    #[Property(property: 'id', title: '', type: 'int')]
    public ?int $id;

    #[Property(property: 'user_id', title: '用户ID', type: 'int')]
    public ?int $userId;

    #[Property(property: 'task_id', title: '任务ID', type: 'int')]
    public ?int $taskId;

    #[Property(property: 'date', title: '日期', type: 'mixed')]
    public mixed $date;

    #[Property(property: 'value', title: '数值', type: 'mixed')]
    public mixed $value;

    #[Property(property: 'comment', title: '备注', type: 'string')]
    public ?string $comment;

    #[Property(property: 'created_at', title: '创建时间', type: 'string')]
    public Carbon $createdAt;

    #[Property(property: 'updated_at', title: '更新时间', type: 'string')]
    public Carbon $updatedAt;

    public function __construct(TaskItem $model)
    {
        $this->id = $model->id;
        $this->userId = $model->user_id;
        $this->taskId = $model->task_id;
        $this->date = $model->date;
        $this->value = $model->value;
        $this->comment = $model->comment;
        $this->createdAt = $model->created_at;
        $this->updatedAt = $model->updated_at;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'task_id' => $this->taskId,
            'date' => $this->date,
            'value' => $this->value,
            'comment' => $this->comment,
            'created_at' => $this->createdAt->toDateTimeString(),
            'updated_at' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
