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

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Swagger\Annotation as SA;
use Hyperf\Swagger\Request\SwaggerRequest;

#[SA\HyperfServer(name: 'http')]
class LoginController extends Controller
{
    #[Inject]
    protected UserService $service;

    #[SA\Post('/login', summary: '小程序登录', tags: ['注册登录'])]
    #[SA\RequestBody(content: new SA\JsonContent(properties: [
        new SA\Property(property: 'code', description: '微信授权码', type: 'string', rules: 'string'),
    ]))]
    #[SA\Response(response: '200', content: new SA\JsonContent(ref: '#/components/schemas/SavedSchema'))]
    public function login(SwaggerRequest $request)
    {
        $code = (string) $request->input('code');

        $result = $this->service->login($code);

        return $this->response->success($result);
    }
}
