<?php

namespace PureChatX;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener {

    protected function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $msg = $event->getMessage();

        // Tag simples (depois ligamos com grupos)
        $tag = "VIP";
        $event->setFormat("§6[$tag] §f{$player->getName()}: §e$msg");
    }
}
