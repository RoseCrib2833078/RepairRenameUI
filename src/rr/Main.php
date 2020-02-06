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
                            $this->repair($sender);
                            break;
                        case 1:
                            $this->rename($sender);
                            break;
      }
    });
    $form->setTitle("§a§lRRUI");
    $form->addButton("§eRepair");
    $form->addButton("§bRename");
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
 }
public function repair(Player $sender){
		  $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		  $f = $api->createCustomForm(function(Player $sender, ?array $data){
		      if(!isset($data)) return;
		  $economy = EconomyAPI::getInstance();
          $mymoney = $economy->myMoney($sender);
          $cash = $this->getConfig()->get("price");
          $dg = $sender->getInventory()->getItemInHand()->getDamage();
          if($mymoney >= $cash * $dg){
	      $economy->reduceMoney($sender, $cash * $dg);
          $index = $sender->getPlayer()->getInventory()->getHeldItemIndex();
	  $item = $sender->getInventory()->getItem($index);
	  $id = $item->getId();
	   if($item instanceof Armor or $item instanceof Tool){
	     if($item->getDamage() > 0){
		 $sender->getInventory()->setItem($index, $item->setDamage(0));
                 $sender->sendMessage("§aYour have been repaired");
		  return true;
		    }else{
		 $sender->sendMessage("§c Item doesn't have any damage.");
	       	return false;
				
     }
		return true;
	      }else{
         	$sender->sendMessage("§cThis item can't repaired");
		return false;
		}
		  return true;
			}else{
		$sender->sendMessage("§cYou don't have enough money!");
		return true;
	 }
	   });
	  $mny = $this->getConfig()->get("price");
          $dg = $sender->getInventory()->getItemInHand()->getDamage();
          $pc = $mny * $dg;
          $economy = EconomyAPI::getInstance();
          $mne = $economy->myMoney($sender);
         $f->setTitle("Repair your item using money");
	 $f->addLabel("§eYour money: $mne \n§aPrice perDamage: $mny\n§aItem damage: $dg \n§dTotal money needed : $pc");
         $f->sendToPlayer($sender);
   }
//todo
}
