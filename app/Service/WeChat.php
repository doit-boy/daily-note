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

use EasyWeChat\MiniApp\Application;
use Han\Utils\Service;
use Hyperf\Codec\Json;
use Hyperf\Di\Annotation\Inject;

class WeChat extends Service
{
    #[Inject]
    protected Application $application;

    public function login(string $code): array
    {
        $res = $this->application->getClient()->get('/sns/jscode2session', [
            'query' => [
                'appid' => $this->application->getConfig()['app_id'],
                'secret' => $this->application->getConfig()['secret'],
                'js_code' => $code,
            ],
        ]);

        return Json::decode($res->getContent(false));
    }

    public function getAppId(): string
    {
        return $this->application->getConfig()['app_id'];
    }

    public function getSecret(): string
    {
        return $this->application->getConfig()['secret'];
    }
}
