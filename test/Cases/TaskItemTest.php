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
class TaskItemTest extends HttpTestCase
{
    public function testTaskItemSave()
    {
        $res = $this->json('/task-item/0', [
            'task_id' => 1,
            'value' => '99.01',
        ], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
