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

namespace App\Model;

/**
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $sort 排序值
 * @property string $name 任务标题
 * @property string $summary 备注
 * @property int $is_deleted 0未删除 1已删除
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Task extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'task';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'sort', 'name', 'summary', 'is_deleted', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'user_id' => 'integer', 'sort' => 'integer', 'is_deleted' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
