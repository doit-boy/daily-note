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

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\EnumConstantsTrait;

#[Constants]
enum ErrorCode: int implements ErrorCodeInterface
{
    use EnumConstantsTrait;

    /**
     * @Message("Server Error")
     */
    case SERVER_ERROR = 500;

    /**
     * @Message("Token 已失效")
     */
    case TOKEN_INVALID = 700;

    /**
     * @Message("权限非法")
     */
    case PERMISSION_DENY = 701;

    /**
     * @Message("参数非法")
     */
    case PARAM_INVALID = 1000;

    /**
     * @Message("用户不存在")
     */
    case USER_NOT_EXIST = 1001;

    /**
     * @Message("任务不存在")
     */
    case TASK_NOT_EXIST = 1101;

    /**
     * @Message("任务记录不存在")
     */
    case TASK_ITEM_NOT_EXIST = 1200;

    /**
     * @Message("原神接口调用失败")
     */
    case YS_REQUEST_FAILED = 1300;

    /**
     * @Message("原神账号不存在")
     */
    case YS_PLAYER_NOT_EXIST = 1301;

    /**
     * @Message("原神角色不存在")
     */
    case YS_ROLER_NOT_EXIST = 1401;

    public function getMessage(array $translate = null): string
    {
        $arguments = [];
        if ($translate) {
            $arguments = [$translate];
        }

        return $this->__call('getMessage', $arguments);
    }
}
