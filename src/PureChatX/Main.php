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
        $groups = $this->getConfig()->getAll();

        foreach ($groups as $group) {
            if (!isset($group["permission"])) {
                continue;
            }

            if ($player->hasPermission($group["permission"])) {
                $tag = $group["tag"] ?? "";
                $color = $group["message-color"] ?? "§f";

                $event->setPrefix($tag . " §f" . $player->getName() . " §7» ");
                $event->setMessage($color . $event->getMessage());
                return;
            }
        }

        // Player padrão
        if (isset($groups["Player"])) {
            $tag = $groups["Player"]["tag"] ?? "";
            $color = $groups["Player"]["message-color"] ?? "§f";

            $event->setPrefix($tag . " §f" . $player->getName() . " §7» ");
            $event->setMessage($color . $event->getMessage());
        }
    }
}
