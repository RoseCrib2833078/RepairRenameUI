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
                $this->rruiform($sender);
                return true;
        }
   }
public function rruiform(Player $sender){
    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function(Player $sender, ?int $data){
			if(!isset($data)) return;
			switch($data){
			case 0:
			    break;
                        case 1:
                            $this->repair($sender);
                            break;
                        case 2:
                            $this->rename($sender);
                            break;
      }
    });
//todo
 }
}
