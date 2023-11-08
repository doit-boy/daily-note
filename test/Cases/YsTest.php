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

use function App\Kernel\Common\format_to_number;

/**
 * @internal
 * @coversNothing
 */
class YsTest extends HttpTestCase
{
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

    public function testYsPlayerIndex()
    {
        $res = $this->get('/ys-player', [], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testYsPlayerInfo()
    {
        $res = $this->get('/ys-player/1', [], [
            UserAuth::X_TOKEN => $this->token,
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testFormatToNumber()
    {
        $this->assertSame('8851', format_to_number('生命值：8851'));
        $this->assertSame('688', format_to_number('攻击力：688'));
        $this->assertSame('506', format_to_number('防御力：506'));
        $this->assertSame('35', format_to_number('元素精通：35'));
        $this->assertSame('0.120', format_to_number('暴击率：12%'));
        $this->assertSame('0.542', format_to_number('暴击伤害：54.2%'));
        $this->assertSame('1.066', format_to_number('元素充能效率：106.6%'));
        $this->assertSame('0.000', format_to_number('岩伤加成：0%'));
    }
}
