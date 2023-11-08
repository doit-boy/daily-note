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

use App\Constants\ErrorCode;
use App\Constants\Status;
use App\Exception\BusinessException;
use App\Model\YsPlayer;
use Han\Utils\Service;
use Hyperf\Database\Model\Collection;

class YsPlayerDao extends Service
{
    public function first(int $id, bool $throw = false): ?YsPlayer
    {
        $model = YsPlayer::findFromCache($id);
        if (! $model && $throw) {
            throw new BusinessException(ErrorCode::YS_PLAYER_NOT_EXIST);
        }

        return $model;
    }

    public function firstByUid(int $userId, int $uid): ?YsPlayer
    {
        return YsPlayer::query()->where('user_id', $userId)
            ->where('uid', $uid)
            ->first();
    }

    public function count(int $userId): int
    {
        return YsPlayer::query()->where('user_id', $userId)->where('status', Status::NO)->count();
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

    /**
     * @return array{int, Collection<int, YsPlayer>}
     */
    public function findByUserId(int $userId, int $offset = 0, int $limit = 10): array
    {
        $query = YsPlayer::query()->where('user_id', $userId)->orderBy('id', 'desc');

        return $this->factory->model->pagination($query, $offset, $limit);
    }

    /**
     * @return Collection<int, YsPlayer>
     */
    public function findListenPlayers(): Collection
    {
        return YsPlayer::query()
            ->where('listen_time', '<=', time() - 86400)
            ->where('is_deleted', Status::NO)
            ->limit(100)
            ->get();
    }
}
