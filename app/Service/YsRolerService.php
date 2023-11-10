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

namespace App\Service;

use App\Constants\ErrorCode;
use App\Constants\YsRolerColumn;
use App\Exception\BusinessException;
use App\Model\YsRolerTarget;
use App\Schema\ChartMetaSchema;
use App\Schema\ChartSchema;
use App\Schema\YsRolerSchema;
use App\Service\Dao\YsRolerDao;
use App\Service\Dao\YsRolerHistoryDao;
use App\Service\Dao\YsRolerTargetDao;
use Carbon\Carbon;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;
use JetBrains\PhpStorm\ArrayShape;

use function Han\Utils\date_load;

class YsRolerService extends Service
{
    #[Inject]
    protected YsRolerDao $dao;

    #[Inject]
    protected YsRolerTargetDao $target;

    #[Inject]
    protected YsRolerHistoryDao $history;

    public function saveTarget(
        int $rolerId,
        #[ArrayShape([
            'level' => 'int',
            'hp' => 'int',
            'attack' => 'int',
            'defend' => 'int',
            'element' => 'int',
            'crit' => 'float',
            'crit_dmg' => 'float',
            'recharge' => 'float',
            'heal' => 'float',
        ])]
        array $input,
        int $userId
    ): bool {
        $roler = $this->dao->first($rolerId, true);
        if ($roler->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        $target = $this->target->first($roler->id);
        if (! $target) {
            $target = new YsRolerTarget();
            $target->id = $roler->id;
        }

        $target->level = $input['level'] ?? 0;
        $target->hp = $input['hp'] ?? 0;
        $target->attack = $input['attack'] ?? 0;
        $target->defend = $input['defend'] ?? 0;
        $target->element = $input['element'] ?? 0;
        $target->crit = $input['crit'] ?? 0;
        $target->crit_dmg = $input['crit_dmg'] ?? 0;
        $target->recharge = $input['recharge'] ?? 0;
        $target->heal = $input['heal'] ?? 0;
        return $target->save();
    }

    public function roler(int $id, int $userId): YsRolerSchema
    {
        $model = $this->dao->first($id);
        if ($model->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        $target = di()->get(YsRolerTargetDao::class)->first($id);

        return new YsRolerSchema($model, $target);
    }

    public function chart(int $id, int $userId): array
    {
        $target = $this->target->first($id);
        if (! $target) {
            throw new BusinessException(ErrorCode::YS_ROLER_TARGET_NOT_EXIST);
        }

        $roler = $this->dao->first($id, true);
        if ($roler->user_id !== $userId) {
            throw new BusinessException(ErrorCode::YS_ROLER_NOT_EXIST);
        }

        $history = $this->history->findMapByRolerId($roler->id);
        if (! $history) {
            throw new BusinessException(ErrorCode::YS_ROLER_HISTORY_NOT_EXIST);
        }

        $charts = [];
        $beginDt = date_load(min(array_keys($history)));
        $now = Carbon::now();
        if ($now->diffInDays($beginDt) < 30) {
            $beginDt = $now->clone()->subMonth();
        }

        foreach (YsRolerColumn::enums() as $column) {
            $max = $target->{$column->value} ?? null;
            if (! $max) {
                continue;
            }

            $index = $beginDt->clone();
            $chart = [];
            $prev = null;
            while (true) {
                $dt = $index->toDateString();
                if ($model = $history[$dt] ?? null) {
                    $prev = $model;
                } else {
                    $model = $prev;
                }

                $score = bcmul(bcdiv((string) $model->{$column->value}, (string) $target->{$column->value}, 4), '100', 2);
                $chart[] = new ChartMetaSchema($dt, $score);
                if ($index->toDateString() >= $now->toDateString()) {
                    break;
                }

                $index->addDay();
            }

            $charts[] = new ChartSchema($column->getName(), $chart);
        }

        return $charts;
    }
}
