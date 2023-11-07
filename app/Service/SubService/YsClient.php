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
use GuzzleHttp\RequestOptions;
use Han\Utils\Service;
use Hyperf\Codec\Json;
use Hyperf\Collection\Arr;

class YsClient extends Service
{
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
            throw new BusinessException(ErrorCode::YS_REQUEST_FAILED, $result['tips']);
        }
        return $result['result'];
    }

    public function getSumComment(array $roleData)
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
            throw new BusinessException(ErrorCode::YS_REQUEST_FAILED, $result['tips']);
        }
        return $result['result'];
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
        return new Client([
            'base_uri' => 'https://api.lelaer.com',
            'timeout' => 5,
        ]);
    }
}
