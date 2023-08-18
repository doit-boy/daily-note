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

#[Schema(title: '图表元数据')]
class ChartMetaSchema implements JsonSerializable
{
    public function __construct(
        #[Property(property: 'key', title: 'x坐标', type: 'string')]
        public string $key,
        #[Property(property: 'value', title: 'y坐标', type: 'string')]
        public string $value,
        #[Property(property: 'value_str', title: 'y坐标', type: 'string')]
        public ?string $valueStr = null
    ) {
        $this->valueStr ??= $this->value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
            'value_str' => $this->valueStr,
        ];
    }
}
