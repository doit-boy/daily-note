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

use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: 'YsPlayerSchema')]
class YsPlayerSchema implements JsonSerializable
{
    #[Property(property: 'id', title: '', type: 'int')]
    public ?int $id;

    #[Property(property: 'user_id', title: '用户 ID', type: 'int')]
    public ?int $userId;

    #[Property(property: 'uid', title: '原神 UID', type: 'int')]
    public ?int $uid;

    #[Property(property: 'comment', title: '备注', type: 'string')]
    public ?string $comment;

    #[Property(property: 'is_deleted', title: '是否删除', type: 'int')]
    public ?int $isDeleted;

    #[Property(property: 'created_at', title: '', type: 'mixed')]
    public mixed $createdAt;

    #[Property(property: 'updated_at', title: '', type: 'mixed')]
    public mixed $updatedAt;

    public function __construct(\App\Model\YsPlayer $model)
    {
        $this->id = $model->id;
        $this->userId = $model->user_id;
        $this->uid = $model->uid;
        $this->comment = $model->comment;
        $this->isDeleted = $model->is_deleted;
        $this->createdAt = $model->created_at;
        $this->updatedAt = $model->updated_at;
    }

    public function jsonSerialize(): mixed
    {
        return ['id' => $this->id, 'user_id' => $this->userId, 'uid' => $this->uid, 'comment' => $this->comment, 'is_deleted' => $this->isDeleted, 'created_at' => $this->createdAt, 'updated_at' => $this->updatedAt];
    }
}
