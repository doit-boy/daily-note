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

namespace App\Service;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\User;
use Hyperf\Codec\Json;
use Hyperf\Redis\Redis;
use Hyperf\Support\Traits\StaticInstance;

class UserAuth
{
    use StaticInstance;

    public const X_TOKEN = 'x-token';

    public const TOKEN_PREFIX = 'auth:';

    protected string $token = '';

    protected int $id = 0;

    public function init(User $user): static
    {
        $token = md5($user->id . uniqid());

        di()->get(Redis::class)->set(
            self::TOKEN_PREFIX . $token,
            Json::encode(['id' => $user->id]),
            86400
        );

        $this->token = $token;
        $this->id = $user->id;

        return $this;
    }

    public function load(string $token): static
    {
        $res = di()->get(Redis::class)->get(self::TOKEN_PREFIX . $token);
        if (! $res) {
            throw new BusinessException(ErrorCode::TOKEN_INVALID);
        }

        $data = Json::decode($res);

        $this->token = $token;
        $this->id = $data['id'];

        return $this;
    }

    public function build(): static
    {
        if (! $this->id) {
            throw new BusinessException(ErrorCode::SERVER_ERROR);
        }

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
