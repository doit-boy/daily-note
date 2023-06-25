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
use App\Service\TaskService;
use App\Service\UserAuth;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Swagger\Annotation as SA;
use Hyperf\Swagger\Request\SwaggerRequest;

#[SA\HyperfServer(name: 'http')]
class TaskController extends Controller
{
    #[Inject]
    protected TaskService $service;

    #[SA\Get('/task', summary: '任务列表', tags: ['任务管理'])]
    #[SA\QueryParameter(parameter: 'offset', description: '偏移量', rules: 'integer')]
    #[SA\QueryParameter(parameter: 'limit', description: '单页条数', rules: 'integer')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/TaskListSchema'))]
    public function index(PageRequest $page)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->index($userId, $page->offset(), $page->limit());

        return $this->response->success($result);
    }

    #[SA\Post('/task/{id:\d+}', summary: '更新任务', tags: ['任务管理'])]
    #[SA\PathParameter(name: 'id', description: '任务ID 0新增 >0修改')]
    #[SA\RequestBody(content: new SA\JsonContent(properties: [
        new SA\Property(property: 'name', description: '任务名', type: 'string', rules: 'required|string'),
        new SA\Property(property: 'summary', description: '任务描述', type: 'string', rules: 'string'),
    ]))]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function save(int $id, SwaggerRequest $request)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->save($id, $userId, $request->all());

        return $this->response->success(new SavedSchema($result));
    }

    #[SA\Get('/task/{id:\d+}', summary: '任务详情', tags: ['任务管理'])]
    #[SA\PathParameter(name: 'id', description: '任务ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/TaskSchema'))]
    public function info(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->info($id, $userId);

        return $this->response->success($result);
    }

    #[SA\Post('/task/{id:\d+}/delete', summary: '删除任务', tags: ['任务管理'])]
    #[SA\PathParameter(name: 'id', description: '任务ID')]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function delete(int $id)
    {
        $userId = UserAuth::instance()->build()->getId();

        $result = $this->service->delete($id, $userId);

        return $this->response->success(new SavedSchema($result));
    }
}
