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
    }
}
