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
        if ($result['code'] !== 0) {
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
        ]);
    }

    protected function client()
    {
        // https://api.lelaer.com/ys/getPlayerCard.php?uid=100168339&server=cn_gf01&unionid=ohAccuEfbjf4y28G4hVKhWb5IFD8&from=normal&timestamp=1699323561216&authkey=d1ed9355400a1bb2c3da47a7dc651f961
        return new Client([
            'base_uri' => 'https://api.lelaer.com',
            'timeout' => 5,
        ]);
    }
}
