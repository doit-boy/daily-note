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

namespace App\Model;

/**
 * @property int $id
 * @property int $roler_id 原神角色ID
 * @property int $level 角色等级
 * @property int $hp 生命值
 * @property int $attack 攻击力
 * @property int $defend 防御力
 * @property int $element 元素精通
 * @property string $crit 暴击率
 * @property string $crit_dmg 暴击伤害
 * @property string $recharge 充能效率
 * @property string $heal 属性伤害加成
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class YsRolerHistory extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'ys_roler_history';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'roler_id', 'level', 'hp', 'attack', 'defend', 'element', 'crit', 'crit_dmg', 'recharge', 'heal', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'int', 'roler_id' => 'integer', 'level' => 'integer', 'hp' => 'integer', 'attack' => 'integer', 'defend' => 'integer', 'element' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
