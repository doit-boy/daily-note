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
 * @property int $task_id 任务ID
 * @property string $date 日期
 * @property string $value 数值
 * @property string $comment 备注
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class TaskItem extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'task_item';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'task_id', 'date', 'value', 'comment', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'user_id' => 'integer', 'task_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
