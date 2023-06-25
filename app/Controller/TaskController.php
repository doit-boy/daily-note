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

    #[SA\Post('/task', summary: '任务列表', tags: ['任务管理'])]
    #[SA\RequestBody(content: new SA\JsonContent(properties: [
        new SA\Property(property: 'offset', description: '偏移量', type: 'integer', rules: 'integer'),
        new SA\Property(property: 'limit', description: '单页条数', type: 'integer', rules: 'integer'),
    ]))]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/LoginSchema'))]
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
}
