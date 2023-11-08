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

use App\Model\YsRolerTarget;
use Han\Utils\Service;

class YsRolerTargetDao extends Service
{
    public function first(int $id): ?YsRolerTarget
    {
        return YsRolerTarget::findFromCache($id);
    }
}
