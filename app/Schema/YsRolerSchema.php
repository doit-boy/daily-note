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

    #[Property(property: 'artifacts_sum_point', title: '圣遗物分值', type: 'int')]
    public ?int $artifactsSumPoint;

    #[Property(property: 'hp', title: '生命值', type: 'int')]
    public ?int $hp;

    #[Property(property: 'attack', title: '攻击力', type: 'int')]
    public ?int $attack;

    #[Property(property: 'defend', title: '防御力', type: 'int')]
    public ?int $defend;

    #[Property(property: 'element', title: '元素精通', type: 'int')]
    public ?int $element;

    #[Property(property: 'crit', title: '暴击率', type: 'string')]
    public string $crit;

    #[Property(property: 'crit_dmg', title: '暴击伤害', type: 'string')]
    public string $critDmg;

    #[Property(property: 'recharge', title: '充能效率', type: 'string')]
    public string $recharge;

    #[Property(property: 'heal', title: '属性伤害加成', type: 'string')]
    public string $heal;

    public function __construct(YsRoler $model)
    {
        $this->id = $model->id;
        $this->userId = $model->user_id;
        $this->uid = $model->uid;
        $this->role = $model->role;
        $this->roleImg = $model->role_img;
        $this->level = $model->level;
        $this->artifactsSumPoint = $model->artifacts_sum_point;
        $this->hp = $model->hp;
        $this->attack = $model->attack;
        $this->defend = $model->defend;
        $this->element = $model->element;
        $this->crit = $model->crit;
        $this->critDmg = $model->crit_dmg;
        $this->recharge = $model->recharge;
        $this->heal = $model->heal;
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
            'artifacts_sum_point' => $this->artifactsSumPoint,
            'hp' => $this->hp,
            'attack' => $this->attack,
            'defend' => $this->defend,
            'element' => $this->element,
            'crit' => $this->crit,
            'crit_dmg' => $this->critDmg,
            'recharge' => $this->recharge,
            'heal' => $this->heal,
        ];
    }
}
