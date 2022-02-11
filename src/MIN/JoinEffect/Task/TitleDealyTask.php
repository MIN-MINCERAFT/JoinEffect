<?php

declare(strict_types=1);

namespace MIN\JoinEffect\Task;

use MIN\JoinEffect\JoinEffect;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;

final class TitleDealyTask extends Task
{
    public function __construct(private Player $player)
    {
    }

    public function onRun(): void
    {
        $api = JoinEffect::getInstance();
        $this->player->sendTitle($api->title,$api->subtitle);
    }
}