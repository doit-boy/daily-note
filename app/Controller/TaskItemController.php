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
use App\Service\TaskItemService;
use App\Service\UserAuth;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Swagger\Annotation as SA;
use Hyperf\Swagger\Request\SwaggerRequest;

#[SA\HyperfServer(name: 'http')]
class TaskItemController extends Controller
{
    #[Inject]
    protected TaskItemService $service;

    #[SA\Post('/task-item/{id:\d+}', summary: '更新记录', tags: ['任务记录管理'])]
    #[SA\PathParameter(name: 'id', description: '任务记录ID')]
    #[SA\RequestBody(content: new SA\JsonContent(properties: [
        new SA\Property(property: 'task_id', description: '任务ID', type: 'integer', rules: 'required|integer'),
        new SA\Property(property: 'value', description: '数值', type: 'string', rules: 'required|numeric'),
        new SA\Property(property: 'comment', description: '备注', type: 'string', rules: 'string'),
    ]))]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function save(int $id, SwaggerRequest $request)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->save($id, $userId, $request->all());

        return $this->response->success(new SavedSchema($result));
    }
}
