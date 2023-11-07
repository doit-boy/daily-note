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

use App\Service\SubService\YsClient;
use App\Service\UserAuth;
use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class YsTest extends HttpTestCase
{
    public function testGetPlayerCards()
    {
        $res = di()->get(YsClient::class)->getPlayerCard(258462145);

        $this->assertIsArray($res);

        $res = di()->get(YsClient::class)->getSumComment($res['role_data']);

        $this->assertIsArray($res);
    }

    public function testYsPlayerCreate()
    {
        $res = $this->json('/ys-player/create', [
            'uid' => 258462145,
            'comment' => '单侧专用',
        ], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
