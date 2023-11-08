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

namespace App\Service\SubService;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Han\Utils\Service;
use Hyperf\Codec\Json;
use Hyperf\Collection\Arr;
use Hyperf\Guzzle\RetryMiddleware;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerInterface;

class YsClient extends Service
{
    protected RetryMiddleware $middleware;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->middleware = new RetryMiddleware(5, 200);
    }

    #[ArrayShape(['role_data' => [['role' => 'string', 'role_img' => 'string', 'level' => 'int']]])]
    public function getPlayerCard(int $uid): array
    {
        $response = $this->client()->get('/ys/getPlayerCard.php', [
            RequestOptions::QUERY => [
                'uid' => $uid,
                'server' => 'cn_gf01',
                'unionid' => $this->unionid(),
                'from' => 'normal',
                'timestamp' => (int) (time() * 1000),
                'authkey' => uniqid(),
            ],
        ]);

        $result = Json::decode((string) $response->getBody());
        if ($result['code'] !== 200) {
            throw new BusinessException(ErrorCode::YS_REQUEST_FAILED, $this->getMessage($result));
        }
        return $result['result'];
    }

    public function getSumComment(array $roleData): array
    {
        $response = $this->client()->post('/ys/getSumComment.php', [
            RequestOptions::JSON => [
                'role_data' => $roleData,
                'timestamp' => (int) (time() * 1000),
                'authkey' => uniqid(),
            ],
        ]);

        $result = Json::decode((string) $response->getBody());
        if ($result['code'] !== 200) {
            throw new BusinessException(ErrorCode::YS_REQUEST_FAILED, $this->getMessage($result));
        }
        return $result['result'];
    }

    public function getMapSumComment(array $roleData): array
    {
        $res = $this->getSumComment($roleData);
        $result = [];
        foreach ($res as $re) {
            $result[$re['role']] = $re;
        }

        return $result;
    }

    public function logMiddleware()
    {
        $formatter = new MessageFormatter(MessageFormatter::DEBUG);

        return Middleware::log($this->logger, $formatter);
    }

    protected function getMessage(array $result): string
    {
        $message = $result['tips'] ?? null;
        if (! $message) {
            $message = $result['result'] ?? null;
        }

        return $message ?: '接口调用失败';
    }

    protected function unionid(): string
    {
        return Arr::random([
            '7p7d5zMxsXWylIIe1QVmjjqieCSQ',
            'VzzeqoLF9rOyyLs8oQpZHnwwGCP2',
            'hHm0meS5pavwWOUx4InT9Y5BHTj6',
            'VjY8wMgErI2wGbhcWWWYsoB8rhCd',
            'pUGCq93woIQA91qNITseLPTVBkRQ',
            'ACvWhGxuz316mHuFjjOyBYI57tkh',
            'twf7YROSBoDkcslFGKWG4DyNjVUT',
            'nTumBDQKiAmm2TQXi97W7EOPDj9G',
            'dIAE6OBsoKgyh9QaQQiZiNX8tB20',
        ]);
    }

    protected function client()
    {
        $handler = HandlerStack::create();
        $handler->push($this->logMiddleware(), 'log');
        $handler->push($this->middleware->getMiddleware(), 'retry');
        return new Client([
            'handler' => $handler,
            'base_uri' => 'https://api.lelaer.com',
            'timeout' => 5,
        ]);
    }
}
