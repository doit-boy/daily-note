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

namespace App\Kernel\Common;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;

function format_to_number(string $value): string
{
    preg_match('/\\d+(.\\d+)?/', $value, $match);
    $result = $match[0] ?? null;
    if ($result === null) {
        throw new BusinessException(ErrorCode::SERVER_ERROR, '不合规的数字');
    }

    return $result;
}
