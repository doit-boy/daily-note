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

use App\Constants\Status;
use App\Model\YsPlayer;
use Han\Utils\Service;

class YsPlayerDao extends Service
{
    public function firstByUid(int $userId, int $uid): ?YsPlayer
    {
        return YsPlayer::query()->where('user_id', $userId)
            ->where('uid', $uid)
            ->first();
    }

    public function create(int $uid, string $comment, int $userId): YsPlayer
    {
        $model = $this->firstByUid($userId, $uid);
        if (! $model) {
            $model = new YsPlayer();
            $model->user_id = $userId;
            $model->uid = $uid;
        }

        $model->comment = $comment;
        $model->is_deleted = Status::NO;
        $model->save();
        return $model;
    }
}
