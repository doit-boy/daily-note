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

enum YsRolerColumn: string
{
    case LEVEL = 'level';
    case HP = 'hp';
    case ATTACK = 'attack';
    case DEFEND = 'defend';
    case ELEMENT = 'element';
    case CRIT = 'crit';
    case CRIT_DMG = 'crit_dmg';
    case RECHARGE = 'recharge';
    case HEAL = 'heal';

    public static function enums(): array
    {
        return [
            self::LEVEL,
            self::HP,
            self::ATTACK,
            self::DEFEND,
            self::ELEMENT,
            self::CRIT,
            self::CRIT_DMG,
            self::RECHARGE,
            self::HEAL,
        ];
    }

    public static function columns(): array
    {
        return [
            self::HP,
            self::ATTACK,
            self::DEFEND,
            self::ELEMENT,
            self::CRIT,
            self::CRIT_DMG,
            self::RECHARGE,
            self::HEAL,
        ];
    }

    public static function values(): array
    {
        $result = [];
        foreach (self::columns() as $column) {
            $result[] = $column->value;
        }
        return $result;
    }

    public function getName(): string
    {
        return match ($this) {
            self::LEVEL => '等级',
            self::HP => '生命值',
            self::ATTACK => '攻击力',
            self::DEFEND => '防御力',
            self::ELEMENT => '元素精通',
            self::CRIT => '暴击率',
            self::CRIT_DMG => '暴击伤害',
            self::RECHARGE => '元素充能',
            self::HEAL => '元素伤害',
        };
    }
}
