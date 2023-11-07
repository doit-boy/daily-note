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

    #[SA\Post('/ys-player/create', summary: '添加我的 UID', tags: ['原神练度管理'])]
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
}
