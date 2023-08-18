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
use App\Schema\LoginSchema;
use App\Service\Dao\UserDao;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;

class UserService extends Service
{
    #[Inject]
    protected UserDao $dao;

    public function login(string $code): LoginSchema
    {
        $res = di()->get(WeChat::class)->login($code);

        $openid = $res['openid'] ?? null;
        if (! $openid) {
            throw new BusinessException(ErrorCode::SERVER_ERROR, '授权登录失败，请重新打开小程序再试');
        }

        $user = $this->dao->firstByOpenId($openid);
        if (! $user) {
            $user = new User();
            $user->openid = $openid;
            $user->save();
        }

        $userAuth = UserAuth::instance()->init($user);

        return new LoginSchema($userAuth->getToken());
    }
}
