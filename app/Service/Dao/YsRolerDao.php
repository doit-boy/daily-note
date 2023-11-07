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

use App\Model\YsPlayer;
use App\Model\YsRoler;
use Han\Utils\Service;

class YsRolerDao extends Service
{
    public function firstByUid(int $userId, int $uid, string $role): ?YsRoler
    {
        return YsRoler::query()->where('user_id', $userId)
            ->where('uid', $uid)
            ->where('role', $role)
            ->first();
    }

    public function create(YsPlayer $player, array $data): bool
    {
        if (empty($data['role'])) {
            return false;
        }

        $model = $this->firstByUid($player->user_id, $player->uid, $data['role']);
        if (! $model) {
            $model = new YsRoler();
            $model->user_id = $player->user_id;
            $model->uid = $player->uid;
            $model->role = $data['role'];
        }

        $model->role_img = $data['role_img'] ?? '';
        $model->level = $data['level'] ?? 0;
        $model->role_data = $data;
        return $model->save();
    }
}
