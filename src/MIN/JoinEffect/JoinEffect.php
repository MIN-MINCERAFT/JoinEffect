<?php

declare(strict_types=1);

namespace MIN\JoinEffect;

use MIN\JoinEffect\Listener\EventListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

final class JoinEffect extends PluginBase
{
    use SingletonTrait;

    public bool $only_op = true;

    public string $op_join_msg = '§b[알림] §f관리자 §7(닉네임)§f님이 접속하셨습니다!';

    public string $user_join_msg = '§b[알림] §7(닉네임) 님이 접속하셨습니다!';

    public string $op_quit_msg = '§b[알림] §f관리자 §7(닉네임)§f님이 퇴장하셨습니다!';

    public string $user_quit_msg = '§b[알림] §7(닉네임) 님이 퇴장하셨습니다!';

    public bool $screen_effect = true;

    public int $id = 10;

    public bool $show_title = true;

    public string $title = '§6§l[ §f! §6]';

    public string $subtitle = '§f§l혜성온라인에 오신것을 환영합니다!';

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}