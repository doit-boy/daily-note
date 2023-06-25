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
use function Hyperf\Support\env;

return [
    'app_id' => env('MP_APP_ID'),
    'secret' => env('MP_SECRET'),
    'token' => 'easywechat',
    'aes_key' => '',
    'http' => [
        'throw' => true, // 状态码非 200、300 时是否抛出异常，默认为开启
        'timeout' => 5.0,
        'retry' => true, // 使用默认重试配置
    ],
];
