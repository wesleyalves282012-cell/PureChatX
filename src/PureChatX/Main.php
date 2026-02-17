<?php

namespace PureChatX;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $groups = $this->getConfig()->getAll();

        $tag = "";
        $color = TextFormat::WHITE;

        foreach ($groups as $group) {
            if (!is_array($group)) {
                continue;
            }

            if (isset($group["permission"]) && $player->hasPermission($group["permission"])) {
                $tag = $group["tag"] ?? "";
                $color = $group["message-color"] ?? TextFormat::WHITE;
                break;
            }
        }

        $event->setFormatter(function(Player $player, string $message) use ($tag, $color): string {
            return $tag . TextFormat::WHITE . $player->getName() .
                TextFormat::GRAY . " » " .
                $color . $message;
        });
    }
}
