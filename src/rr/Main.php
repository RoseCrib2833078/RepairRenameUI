<?php

namespace rr;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use jojoe77777\FormAPI;
use pocketmine\Player;
use pocketmine\Server;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool
    {
        switch($cmd->getName()){
        case "rrui":
        if(!$sender instanceof Player){
                $sender->sendMessage("§cUse that command in game!.");
                return true;
        }
