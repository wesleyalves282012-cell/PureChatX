<?php

namespace PureChatX;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener {

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $groups = $this->getConfig()->getAll();

        foreach ($groups as $group) {
            if (isset($group["permission"]) && $player->hasPermission($group["permission"])) {

                $tag = $group["tag"] ?? "";
                $color = $group["message-color"] ?? "§f";

                // PMMP 5 way
                $event->setPrefix($tag . " §f" . $player->getName() . " §7» ");
                $event->setMessage($color . $message);
                return;
            }
        }

        // Fallback Player
        if (isset($groups["Player"])) {
            $tag = $groups["Player"]["tag"] ?? "";
            $color = $groups["Player"]["message-color"] ?? "§f";

            $event->setPrefix($tag . " §f" . $player->getName() . " §7» ");
            $event->setMessage($color . $message);
        }
    }
}
