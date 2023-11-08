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
 * @property int $user_id 用户 ID
 * @property int $uid 原神 UID
 * @property string $comment 备注
 * @property int $is_deleted 是否删除
 * @property int $listen_time 上次监听时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class YsPlayer extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'ys_player';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'uid', 'comment', 'is_deleted', 'listen_time', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'user_id' => 'integer', 'uid' => 'integer', 'is_deleted' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'listen_time' => 'integer'];
}
