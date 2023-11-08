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
use App\Exception\BusinessException;
use App\Model\YsRolerTarget;
use App\Service\Dao\YsRolerDao;
use App\Service\Dao\YsRolerTargetDao;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;
use JetBrains\PhpStorm\ArrayShape;

class YsRolerService extends Service
{
    #[Inject]
    protected YsRolerDao $dao;

    #[Inject]
    protected YsRolerTargetDao $target;

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

        $target->level = $input['level'];
        $target->hp = $input['hp'];
        $target->attack = $input['attack'];
        $target->defend = $input['defend'];
        $target->element = $input['element'];
        $target->crit = $input['crit'];
        $target->crit_dmg = $input['crit_dmg'];
        $target->recharge = $input['recharge'];
        $target->heal = $input['heal'];
        return $target->save();
    }
}
