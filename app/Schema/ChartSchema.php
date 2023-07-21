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

use Hyperf\Swagger\Annotation\Items;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '图表数据')]
class ChartSchema implements JsonSerializable
{
    /**
     * @param string $name
     * @param ChartMetaSchema[] $values
     */
    public function __construct(
        #[Property(property: 'name', title: '图表名', type: 'string')]
        public string $name,
        #[Property(property: 'values', title: '图表数据', type: 'array', items: new Items(ref: '#/components/schemas/ChartMetaSchema'))]
        public array $values
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'values' => $this->values,
        ];
    }
}
