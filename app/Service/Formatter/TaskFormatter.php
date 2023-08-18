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

namespace App\Service\Formatter;

use App\Schema\TaskSchema;
use Han\Utils\Service;
use Hyperf\Database\Model\Collection;

class TaskFormatter extends Service
{
    public function formatList(Collection $models)
    {
        $result = [];
        foreach ($models as $model) {
            $result[] = new TaskSchema($model);
        }
        return $result;
    }
}
