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

namespace App\Crontab;

use App\Service\YsPlayerService;
use Hyperf\Crontab\Annotation\Crontab;

class YsCrontab
{
    #[Crontab(rule: '* * * * *')]
    public function listenRoler()
    {
        di()->get(YsPlayerService::class)->syncPlayers();
    }
}
