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
use App\Constants\YsRolerColumn;
use App\Exception\BusinessException;
use App\Model\YsPlayer;
use App\Model\YsRoler;
use Carbon\Carbon;
use Han\Utils\Service;
use Hyperf\Database\Model\Collection;

use function App\Kernel\Common\format_to_number;

class YsRolerDao extends Service
{
    public function first(int $id, bool $throw = false): ?YsRoler
    {
        $model = YsRoler::findFromCache($id);
        if (! $model && $throw) {
            throw new BusinessException(ErrorCode::YS_ROLER_NOT_EXIST);
        }

        return $model;
    }

    public function firstByUid(int $userId, int $uid, string $role): ?YsRoler
    {
        return YsRoler::query()->where('user_id', $userId)
            ->where('uid', $uid)
            ->where('role', $role)
            ->first();
    }

    public function create(YsPlayer $player, array $data, array $rawData): YsRoler
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
        $model->artifacts_sum_point = $rawData['artifacts_sum_point2'];
        $columns = YsRolerColumn::columns();
        foreach ($columns as $column) {
            $model->setNumber($column->value, format_to_number($rawData[$column->value]));
        }
        $model->raw_data = $rawData;
        $model->save();

        if ($model->wasChanged(YsRolerColumn::values())) {
            di()->get(YsRolerHistoryDao::class)->create($model, Carbon::now());
        }

        return $model;
    }

    /**
     * @return Collection<int, YsRoler>
     */
    public function findByPlayer(YsPlayer $player): Collection
    {
        return YsRoler::query()->where('user_id', $player->user_id)
            ->where('uid', $player->uid)
            ->orderBy('level', 'desc')
            ->orderBy('artifacts_sum_point', 'desc')
            ->get();
    }
}
