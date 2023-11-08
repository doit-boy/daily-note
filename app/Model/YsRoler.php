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
 * @property int $user_id 用户 ID
 * @property int $uid 原神 UID
 * @property string $role 角色名
 * @property string $role_img 角色头像
 * @property int $level 角色等级
 * @property array $role_data 原始数据
 * @property int $artifacts_sum_point 圣遗物分值
 * @property int $hp 生命值
 * @property int $attack 攻击力
 * @property int $defend 防御力
 * @property int $element 元素精通
 * @property string $crit 暴击率
 * @property string $crit_dmg 暴击伤害
 * @property string $recharge 充能效率
 * @property string $heal 属性伤害加成
 * @property array $raw_data 四维基础数据
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class YsRoler extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'ys_roler';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'uid', 'role', 'role_img', 'level', 'role_data', 'artifacts_sum_point', 'hp', 'attack', 'defend', 'element', 'crit', 'crit_dmg', 'recharge', 'heal', 'raw_data', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'user_id' => 'integer', 'uid' => 'integer', 'level' => 'integer', 'role_data' => 'json', 'raw_data' => 'json', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'artifacts_sum_point' => 'integer', 'hp' => 'integer', 'attack' => 'integer', 'defend' => 'integer', 'element' => 'integer'];

    public function setNumber(string $key, mixed $value)
    {
        if ($this->{$key} == $value) {
            return $this;
        }

        return parent::setAttribute($key, $value);
    }
}
