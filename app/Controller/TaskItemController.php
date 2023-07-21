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
        $taskId = (int) $request->input('task_id');

        $result = $this->service->save($id, $taskId, $userId, $request->all());

        return $this->response->success(new SavedSchema($result));
    }

    #[SA\Get('/task-item', summary: '任务记录列表', tags: ['任务记录管理'])]
    #[SA\QueryParameter(parameter: 'task_id', description: '任务ID', rules: 'required|integer')]
    #[SA\QueryParameter(parameter: 'offset', description: '偏移量', rules: 'integer')]
    #[SA\QueryParameter(parameter: 'limit', description: '单页条数', rules: 'integer')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/TaskItemListSchema'))]
    public function index(SwaggerRequest $request, PageRequest $page)
    {
        $taskId = (int) $request->input('task_id');
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->index($taskId, $userId, $page->offset(), $page->limit());

        return $this->response->success($result);
    }

    #[SA\Get('/task-item/chart', summary: '任务记录图表', tags: ['任务记录管理'])]
    #[SA\QueryParameter(parameter: 'task_id', description: '任务ID', rules: 'required|integer')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/ChartSchema'))]
    public function chart(SwaggerRequest $request, PageRequest $page)
    {
        $taskId = (int) $request->input('task_id');
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->chart($taskId, $userId);

        return $this->response->success($result);
    }

    #[SA\Get('/task-item/{id:\d+}', summary: '任务记录详情', tags: ['任务记录管理'])]
    #[SA\PathParameter(name: 'id', description: '任务ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/TaskItemSchema'))]
    public function info(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->info($id, $userId);

        return $this->response->success($result);
    }

    #[SA\Post('/task-item/{id:\d+}/delete', summary: '删除任务记录', tags: ['任务记录管理'])]
    #[SA\PathParameter(name: 'id', description: '任务ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function delete(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->delete($id, $userId);

        return $this->response->success(new SavedSchema($result));
    }
}
