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

namespace HyperfTest;

use App\Service\WeChat;
use Hyperf\Testing;
use Mockery;
use PHPUnit\Framework\TestCase;

use function Hyperf\Support\make;

/**
 * Class HttpTestCase.
 * @method get($uri, $data = [], $headers = [])
 * @method post($uri, $data = [], $headers = [])
 * @method json($uri, $data = [], $headers = [])
 * @method file($uri, $data = [], $headers = [])
 */
abstract class HttpTestCase extends TestCase
{
    /**
     * @var Testing\Client
     */
    protected $client;

    protected string $token;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = make(Testing\Client::class);
        // $this->client = make(Testing\HttpClient::class, ['baseUri' => 'http://127.0.0.1:9501']);
    }

    public function __call($name, $arguments)
    {
        return $this->client->{$name}(...$arguments);
    }

    protected function setUp(): void
    {
        if (! isset($this->token)) {
            $weChat = di()->get(WeChat::class);
            try {
                di()->set(WeChat::class, $mock = Mockery::mock(WeChat::class));
                $mock->shouldReceive('login')->with($code = '0a1elMGa1MGxwF0VLGIa1TTQBt0elMG4')->once()->andReturn(['openid' => 'ohjUY0TB_onjcaH2ia06HgGOC4CY']);
                $res = $this->json('/login', [
                    'code' => $code,
                ]);

                $this->token = $res['data']['token'];
            } finally {
                di()->set(WeChat::class, $weChat);
            }
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
