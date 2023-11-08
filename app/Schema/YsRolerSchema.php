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

namespace App\Schema;

use App\Model\YsRoler;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '原神角色详情')]
class YsRolerSchema implements JsonSerializable
{
    #[Property(property: 'id', title: '', type: 'int')]
    public ?int $id;

    #[Property(property: 'user_id', title: '用户 ID', type: 'int')]
    public ?int $userId;

    #[Property(property: 'uid', title: '原神 UID', type: 'int')]
    public ?int $uid;

    #[Property(property: 'role', title: '角色名', type: 'string')]
    public ?string $role;

    #[Property(property: 'role_img', title: '角色头像', type: 'string')]
    public ?string $roleImg;

    #[Property(property: 'level', title: '角色等级', type: 'int')]
    public ?int $level;

    public function __construct(YsRoler $model)
    {
        $this->id = $model->id;
        $this->userId = $model->user_id;
        $this->uid = $model->uid;
        $this->role = $model->role;
        $this->roleImg = $model->role_img;
        $this->level = $model->level;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'uid' => $this->uid,
            'role' => $this->role,
            'role_img' => $this->roleImg,
            'level' => $this->level,
        ];
    }
}
