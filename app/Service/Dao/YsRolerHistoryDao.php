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

use App\Model\YsRoler;
use App\Model\YsRolerHistory;
use Carbon\Carbon;
use Han\Utils\Service;
use Hyperf\Database\Model\Collection;

class YsRolerHistoryDao extends Service
{
    public function create(YsRoler $roler, Carbon $dt): YsRolerHistory
    {
        $model = YsRolerHistory::query()->where('roler_id', $roler->id)
            ->where('dt', $dt->toDateString())
            ->first();

        if (! $model) {
            $model = new YsRolerHistory();
            $model->roler_id = $roler->id;
            $model->dt = $dt->toDateString();
        }

        $model->level = $roler->level;
        $model->hp = $roler->hp;
        $model->attack = $roler->attack;
        $model->defend = $roler->defend;
        $model->element = $roler->element;
        $model->crit = $roler->crit;
        $model->crit_dmg = $roler->crit_dmg;
        $model->recharge = $roler->recharge;
        $model->heal = $roler->heal;
        $model->save();

        return $model;
    }

    /**
     * @return Collection<int, YsRolerHistory>
     */
    public function findByRolerId(int $rolerId): Collection
    {
        return YsRolerHistory::query()->where('roler_id', $rolerId)
            ->orderBy('dt', 'asc')
            ->get();
    }

    /**
     * @return array<string, YsRolerHistory>
     */
    public function findMapByRolerId(int $rolerId): array
    {
        $models = $this->findByRolerId($rolerId);
        $result = [];
        foreach ($models as $model) {
            $result[$model->dt] = $model;
        }

        return $result;
    }
}
