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
namespace HyperfTest\Cases;

use App\Service\UserAuth;
use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class TaskTest extends HttpTestCase
{
    public function testTaskSave()
    {
        $res = $this->json('/task/1', [
            'name' => '单测',
            'summary' => '专门用于单元测试',
        ], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testTaskIndex()
    {
        $res = $this->json('/task', [], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
