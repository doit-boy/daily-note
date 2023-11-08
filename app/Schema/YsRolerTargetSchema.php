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

use App\Model\YsRolerTarget;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use JsonSerializable;

#[Schema(title: '原神角色目标详情')]
class YsRolerTargetSchema implements JsonSerializable
{
    #[Property(property: 'id', title: '原神角色ID', type: 'int')]
    public ?int $id;

    #[Property(property: 'level', title: '角色等级', type: 'int')]
    public ?int $level;

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

    public function __construct(YsRolerTarget $model)
    {
        $this->id = $model->id;
        $this->level = $model->level;
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
            'level' => $this->level,
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
