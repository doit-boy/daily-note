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

namespace App\Service;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Schema\YsPlayerListSchema;
use App\Schema\YsPlayerSchema;
use App\Service\Dao\YsPlayerDao;
use App\Service\Dao\YsRolerDao;
use App\Service\Formatter\YsPlayerFormatter;
use App\Service\Formatter\YsRolerFormatter;
use App\Service\SubService\YsClient;
use Carbon\Carbon;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;
use Throwable;

class YsPlayerService extends Service
{
    #[Inject]
    protected YsPlayerDao $dao;

    #[Inject]
    protected YsClient $client;

    #[Inject]
    protected YsPlayerFormatter $formatter;

    public function create(int $uid, string $comment, int $userId): bool
    {
        $count = $this->dao->count($userId);
        if ($count >= 3) {
            throw new BusinessException(ErrorCode::YS_PLAYER_ALREADY_FULL);
        }

        $player = $this->dao->create($uid, $comment, $userId);
        $card = $this->client->getPlayerCard($uid);
        $map = $this->client->getMapSumComment($card['role_data']);
        foreach ($card['role_data'] ?? [] as $item) {
            di()->get(YsRolerDao::class)->create($player, $item, $map[$item['role']]);
        }

        return true;
    }

    public function players(int $userId, int $offset, int $limit): YsPlayerListSchema
    {
        [$count, $models] = $this->dao->findByUserId($userId, $offset, $limit);

        $result = $this->formatter->formatList($models);

        return new YsPlayerListSchema($count, $result);
    }

    public function player(int $id, int $userId): YsPlayerSchema
    {
        $model = $this->dao->first($id, true);
        if ($model->user_id !== $userId) {
            throw new BusinessException(ErrorCode::PERMISSION_DENY);
        }

        $rolers = di()->get(YsRolerDao::class)->findByPlayer($model);

        return new YsPlayerSchema(
            $model,
            di()->get(YsRolerFormatter::class)->formatList($rolers)
        );
    }

    public function syncPlayers(): void
    {
        $models = $this->dao->findListenPlayers();
        $now = Carbon::now();
        foreach ($models as $model) {
            try {
                $card = $this->client->getPlayerCard($model->uid);
                $map = $this->client->getMapSumComment($card['role_data']);
                foreach ($card['role_data'] ?? [] as $item) {
                    di()->get(YsRolerDao::class)->create($model, $item, $map[$item['role']]);
                }
                $model->listen_time = $now->getTimestamp();
                $model->save();
            } catch (Throwable $exception) {
                $this->logger->error((string) $exception);
                continue;
            }
        }
    }
}
