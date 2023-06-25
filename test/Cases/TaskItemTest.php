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

use App\Model\TaskItem;
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

        if ($model = TaskItem::query()->where('task_id', 1)->first()) {
            $res = $this->get('/task-item/' . $model->id, [], [
                UserAuth::X_TOKEN => $this->token,
            ]);

            $this->assertSame(0, $res['code']);
            $this->assertSame(1, $res['data']['task_id']);

            $res = $this->json('/task-item/' . $model->id . '/delete', [], [
                UserAuth::X_TOKEN => $this->token,
            ]);

            $this->assertSame(0, $res['code']);
        }
    }

    public function testTaskItemList()
    {
        $res = $this->get('/task-item', [
            'task_id' => 1,
        ], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
