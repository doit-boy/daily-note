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

use App\Model\Task;
use Carbon\Carbon;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '任务详情')]
class TaskSchema implements JsonSerializable
{
    #[Property(property: 'id', title: '', type: 'int')]
    public ?int $id;

    #[Property(property: 'user_id', title: '用户ID', type: 'int')]
    public ?int $userId;

    #[Property(property: 'name', title: '任务标题', type: 'string')]
    public ?string $name;

    #[Property(property: 'summary', title: '备注', type: 'string')]
    public ?string $summary;

    #[Property(property: 'is_deleted', title: '0未删除 1已删除', type: 'int')]
    public ?int $isDeleted;

    #[Property(property: 'created_at', title: '创建时间', type: 'string')]
    public Carbon $createdAt;

    #[Property(property: 'updated_at', title: '更新时间', type: 'string')]
    public Carbon $updatedAt;

    public function __construct(Task $model)
    {
        $this->id = $model->id;
        $this->userId = $model->user_id;
        $this->name = $model->name;
        $this->summary = $model->summary;
        $this->isDeleted = $model->is_deleted;
        $this->createdAt = $model->created_at;
        $this->updatedAt = $model->updated_at;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'summary' => $this->summary,
            'is_deleted' => $this->isDeleted,
            'created_at' => $this->createdAt->toDateTimeString(),
            'updated_at' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
