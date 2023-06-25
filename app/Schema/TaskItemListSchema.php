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
namespace App\Schema;

use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '任务记录列表')]
class TaskItemListSchema implements JsonSerializable
{
    public function __construct(
        #[Property(property: 'count', title: '总数', type: 'integer')]
        public int $count,
        #[Property(property: 'list', title: '列表', type: 'integer')]
        public array $list
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'count' => $this->count,
            'list' => $this->list,
        ];
    }
}
