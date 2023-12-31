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
return [
    Hyperf\Contract\StdoutLoggerInterface::class => App\Kernel\Log\LoggerFactory::class,
    Hyperf\Server\Listener\AfterWorkerStartListener::class => App\Kernel\Http\WorkerStartListener::class,
    Psr\EventDispatcher\EventDispatcherInterface::class => App\Kernel\Event\EventDispatcherFactory::class,
    EasyWeChat\MiniApp\Application::class => App\Service\Factory\WeChatFactory::class,
    Hyperf\Crontab\Strategy\StrategyInterface::class => Hyperf\Crontab\Strategy\CoroutineStrategy::class,
];
