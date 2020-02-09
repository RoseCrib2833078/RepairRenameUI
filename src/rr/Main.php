<?php

namespace rr;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\item\Armor;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as T;

use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(T::AQUA . "plugin enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
    	if($sender instanceof Player){
        switch($command->getName()){
            case "rr":
                $this->rruiform($sender);
        }
        return true;
    }
    return false;
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
                        case 2:
                            break;
      }
    });
    $form->setTitle(T::BOLD . T::GREEN . "•RRUI•");
    $form->addButton(T::YELLOW . "•REPAIR•");
    $form->addButton(T::AQUA . "•RENAME•");
    $form->addButton(T::RED . "•EXIT•");
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
                 $sender->sendMessage(T::GREEN . "Your have been repaired");
		  return true;
		    }else{
		 $sender->sendMessage(T::RED . "Item doesn't have any damage.");
	       	return false;			
     }
		return true;
	           }else{
         	$sender->sendMessage(T::RED . "This item can't repaired");
		return false;
		}
		  return true;
			}else{
		$sender->sendMessage(T::RED . "You don't have enough money!");
		return true;
	 }
	   });
	  $mny = $this->getConfig()->get("price");
          $dg = $sender->getInventory()->getItemInHand()->getDamage();
          $pc = $mny * $dg;
          $economy = EconomyAPI::getInstance();
          $mne = $economy->myMoney($sender);
          $f->setTitle(T::BOLD . T::GOLD . "RepairUI");
	  $f->addLabel("§eYour money: $mne \n§aPrice perDamage: $mny\n§aItem damage: $dg \n§dTotal money needed : $pc");
          $f->sendToPlayer($sender);
   }

public function rename(Player $sender){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $f = $api->createCustomForm(function(Player $sender, ?array $data){
             if(!isset($data)) return;
		 $item = $sender->getInventory()->getItemInHand();
		  if($item->getId() == 0) {
                    $sender->sendMessage(T::RED . "Hold item in hand!");
                    return;
                }
          $economy = EconomyAPI::getInstance();
          $mymoney = $economy->myMoney($sender);
          $rename = $this->getConfig()->get("price-rename");
          if($mymoney >= $rename){
	      $economy->reduceMoney($sender, $rename);
                $item->setCustomName($data[1]);
                $sender->getInventory()->setItemInHand($item);
                $sender->sendMessage(T::GREEN . "successfully changed item name to §e$data[1]");
                }else{
             $sender->sendMessage(T::RED . "You don't have enough money!");
             }
	    });
	   
          $economy = EconomyAPI::getInstance();
          $mymoney = $economy->myMoney($sender);
          $rename = $this->getConfig()->get("price-rename");
	  $f->setTitle(T::BOLD . T::YELLOW . "•RenameUI•");
	  $f->addLabel("§aRename cost: §e$rename\n§bYour money: $mymoney");
          $f->addInput(T::RED . "Rename Item:", "HardCore");
	  $f->sendToPlayer($sender);
	     }
}
