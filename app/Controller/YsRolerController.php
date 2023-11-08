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
use Hyperf\Di\Annotation\Inject;
use Hyperf\Swagger\Annotation as SA;
use Hyperf\Swagger\Request\SwaggerRequest;

#[SA\HyperfServer(name: 'http')]
class YsRolerController extends Controller
{
    #[Inject]
    protected YsPlayerService $player;

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
}
