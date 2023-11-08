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

namespace App\Controller;

use App\Request\PageRequest;
use App\Schema\SavedSchema;
use App\Service\UserAuth;
use App\Service\YsPlayerService;
use App\Service\YsRolerService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Swagger\Annotation as SA;
use Hyperf\Swagger\Request\SwaggerRequest;

#[SA\HyperfServer(name: 'http')]
class YsRolerController extends Controller
{
    #[Inject]
    protected YsPlayerService $player;

    #[Inject]
    protected YsRolerService $roler;

    #[SA\Post('/ys-player/create', summary: '添加原神账号', tags: ['原神练度管理'])]
    #[SA\RequestBody(content: new SA\JsonContent(properties: [
        new SA\Property(property: 'uid', description: '原神 UID', type: 'integer', rules: 'required|integer'),
        new SA\Property(property: 'comment', description: '备注', type: 'string', rules: 'string'),
    ]))]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function create(SwaggerRequest $request)
    {
        $userId = UserAuth::instance()->build()->getId();
        $uid = (int) $request->input('uid');
        $comment = (string) $request->input('comment');

        $result = $this->player->create($uid, $comment, $userId);

        return $this->response->success(new SavedSchema($result));
    }

    #[SA\Get('/ys-player', summary: '原神账号列表', tags: ['原神练度管理'])]
    #[SA\QueryParameter(parameter: 'offset', description: '偏移量', rules: 'integer')]
    #[SA\QueryParameter(parameter: 'limit', description: '单页条数', rules: 'integer')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/YsPlayerListSchema'))]
    public function players(SwaggerRequest $request, PageRequest $page)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->player->players($userId, $page->offset(), $page->limit());

        return $this->response->success($result);
    }

    #[SA\Get('/ys-player/{id:\d+}', summary: '原神账号详情', tags: ['原神练度管理'])]
    #[SA\PathParameter(name: 'id', description: '原神账号 ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/YsPlayerListSchema'))]
    public function player(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->player->player($id, $userId);

        return $this->response->success($result);
    }

    #[SA\Delete('/ys-player/{id:\d+}', summary: '原神账号详情', tags: ['原神练度管理'])]
    #[SA\PathParameter(name: 'id', description: '原神账号 ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function deletePlayer(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->player->delete($id, $userId);

        return $this->response->success(new SavedSchema($result));
    }

    #[SA\Get('/ys-roler/{id:\d+}', summary: '查看角色详情', tags: ['原神练度管理'])]
    #[SA\PathParameter(name: 'id', description: '原神账号 ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/YsRolerSchema'))]
    public function roler(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->roler->roler($id, $userId);

        return $this->response->success($result);
    }

    #[SA\Post('/ys-roler/target', summary: '设置角色目标', tags: ['原神练度管理'])]
    #[SA\RequestBody(content: new SA\JsonContent(properties: [
        new SA\Property(property: 'id', description: '原神角色 ID', type: 'integer', rules: 'required|integer'),
        new SA\Property(property: 'level', description: '等级', type: 'integer', rules: 'integer'),
        new SA\Property(property: 'hp', description: '生命值', type: 'integer', rules: 'integer'),
        new SA\Property(property: 'attack', description: '攻击力', type: 'integer', rules: 'integer'),
        new SA\Property(property: 'defend', description: '防御力', type: 'integer', rules: 'integer'),
        new SA\Property(property: 'element', description: '元素精通', type: 'integer', rules: 'integer'),
        new SA\Property(property: 'crit', description: '暴击率', type: 'float', rules: 'float'),
        new SA\Property(property: 'crit_dmg', description: '暴击伤害', type: 'float', rules: 'float'),
        new SA\Property(property: 'recharge', description: '充能效率', type: 'float', rules: 'float'),
        new SA\Property(property: 'heal', description: '属性伤害加成', type: 'float', rules: 'float'),
    ]))]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function saveTarget(SwaggerRequest $request)
    {
        $rolerId = (int) $request->input('id');
        $userId = UserAuth::instance()->build()->getId();
        $input = $request->all();

        $result = $this->roler->saveTarget($rolerId, $input, $userId);

        return $this->response->success(new SavedSchema($result));
    }
}
