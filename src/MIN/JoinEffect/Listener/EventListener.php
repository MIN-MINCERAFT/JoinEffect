<?php

declare(strict_types=1);

namespace MIN\JoinEffect\Listener;

use MIN\AnimationHelper\AnimationHelper;
use MIN\JoinEffect\JoinEffect;
use MIN\JoinEffect\Task\TitleDealyTask;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use function str_replace;

final class EventListener implements Listener
{
    public function onJoin(PlayerJoinEvent $event): void
    {
        $api = JoinEffect::getInstance();
        $player = $event->getPlayer();
        $name = $player->getName();

        $packet = new PlaySoundPacket();
        $packet->soundName = 'random.levelup';
        $packet->x = $player->getPosition()->getX();
        $packet->y = $player->getPosition()->getY();
        $packet->z = $player->getPosition()->getZ();
        $packet->volume = 1;
        $packet->pitch = 1;
        $player->getNetworkSession()->sendDataPacket($packet);
        if($api->show_title){
            $api->getScheduler()->scheduleDelayedTask(new TitleDealyTask($player),20);
        }
        if ($api->screen_effect) {
            AnimationHelper::setAnimation($player, $api->id);
        }
        if ($api->only_op) {
            if ($api->getServer()->isOp($name)) {
                $event->setJoinMessage(str_replace('(닉네임)', $player->getName(), $api->op_join_msg));
                return;
            }
            $event->setJoinMessage('');
            $api->getServer()->broadcastTip('§l+ ' . $name);
        } else {
            if ($api->getServer()->isOp($name)) {
                $event->setJoinMessage(str_replace('(닉네임)', $player->getName(), $api->op_join_msg));
                return;
            }
            $event->setJoinMessage(str_replace('(닉네임)', $player->getName(), $api->user_join_msg));
        }
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $api = JoinEffect::getInstance();
        $player = $event->getPlayer();
        $name = $player->getName();
        if ($api->only_op) {
            if ($api->getServer()->isOp($name)) {
                $event->setQuitMessage(str_replace('(닉네임)', $player->getName(), $api->op_quit_msg));
                return;
            }
            $event->setQuitMessage('');
            $api->getServer()->broadcastTip('§l- ' . $name);
        } else {
            if ($api->getServer()->isOp($name)) {
                $event->setQuitMessage(str_replace('(닉네임)', $player->getName(), $api->op_quit_msg));
                return;
            }
            $event->setQuitMessage(str_replace('(닉네임)', $player->getName(), $api->user_quit_msg));
        }
    }
}