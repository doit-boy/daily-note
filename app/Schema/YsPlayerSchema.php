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

use App\Model\YsPlayer;
use Hyperf\Swagger\Annotation\Items;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '原神账号详情')]
class YsPlayerSchema implements JsonSerializable
{
    #[Property(property: 'id', title: '', type: 'int')]
    public ?int $id;

    #[Property(property: 'user_id', title: '用户 ID', type: 'int')]
    public ?int $userId;

    #[Property(property: 'uid', title: '原神 UID', type: 'int')]
    public ?int $uid;

    #[Property(property: 'comment', title: '备注', type: 'string')]
    public ?string $comment;

    #[Property(property: 'rolers', title: '角色列表', type: 'array', items: new Items(ref: '#/components/schemas/YsRolerSchema'))]
    public array $rolers = [];

    public function __construct(YsPlayer $model, array $rolers = [])
    {
        $this->id = $model->id;
        $this->userId = $model->user_id;
        $this->uid = $model->uid;
        $this->comment = $model->comment;
        $this->rolers = $rolers;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'uid' => $this->uid,
            'comment' => $this->comment,
            'rolers' => $this->rolers,
        ];
    }
}
