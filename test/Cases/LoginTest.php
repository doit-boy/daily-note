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

use App\Service\WeChat;
use HyperfTest\HttpTestCase;
use Mockery;

/**
 * @internal
 * @coversNothing
 */
class LoginTest extends HttpTestCase
{
    public function testLogin()
    {
        $weChat = di()->get(WeChat::class);
        try {
            di()->set(WeChat::class, $mock = Mockery::mock(WeChat::class));
            $mock->shouldReceive('login')->with($code = '0a1elMGa1MGxwF0VLGIa1TTQBt0elMG4')->once()->andReturn(['openid' => 'ohjUY0TB_onjcaH2ia06HgGOC4CY']);
            $res = $this->json('/login', [
                'code' => $code,
            ]);

            $this->assertSame(0, $res['code']);
        } finally {
            di()->set(WeChat::class, $weChat);
        }
    }
}
