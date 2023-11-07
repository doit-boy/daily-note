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

use App\Service\Dao\YsPlayerDao;
use App\Service\Dao\YsRolerDao;
use App\Service\SubService\YsClient;
use Han\Utils\Service;
use Hyperf\Di\Annotation\Inject;

class YsPlayerService extends Service
{
    #[Inject]
    protected YsPlayerDao $dao;

    #[Inject]
    protected YsClient $client;

    public function create(int $uid, string $comment, int $userId): bool
    {
        $player = $this->dao->create($uid, $comment, $userId);
        $card = $this->client->getPlayerCard($uid);
        foreach ($card['role_data'] ?? [] as $item) {
            di()->get(YsRolerDao::class)->create($player, $item);
        }

        return true;
    }
}
