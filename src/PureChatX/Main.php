<?php

declare(strict_types=1);

namespace PureChatX;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $config = $this->getConfig();

        $tag = "";
        $messageColor = "§f";

        foreach ($config->get("groups") as $group) {
            if (isset($group["permission"]) && $player->hasPermission($group["permission"])) {
                $tag = $group["tag"];
                $messageColor = $group["message-color"];
                break;
            }
        }

        if ($tag === "") {
            $playerGroup = $config->get("groups")["Player"];
            $tag = $playerGroup["tag"];
            $messageColor = $playerGroup["message-color"];
        }

        $format = str_replace(
            ["{tag}", "{name}", "{message}"],
            [$tag, $player->getName(), $messageColor . $message],
            $config->get("format")
        );

        $event->setFormat($format);
    }
}
