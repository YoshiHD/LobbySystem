<?php

namespace Core;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\particle\FlameParticle;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\IntTag;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as C;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\DoorBumpSound;
use pocketmine\level\Level;

class Main extends PluginBase implements Listener {
	
	public $prefix = "§8[§6ServerName§8]§f ";

	public function onEnable(){
		$this->getLogger()->info($this->prefix.C::GREEN."Aktiviert");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

	public function MainItems(Player $player){
		$player->getInventory()->clearAll();
		$player->getInventory()->setItem(4, Item::get(345)->setCustomName("§5Teleporter§f§8 {§aVerfügbar§8}"));
        $player->getInventory()->setItem(0, Item::get(340)->setCustomName("§aInfo§f§8 {§aVerfügbar§8}"));
        $player->getInventory()->setItem(7, Item::get(347)->setCustomName("§aLobby Switcher§f§8 {§aVerfügbar§8}"));
        $player->getInventory()->setItem(1, Item::get(130)->setCustomName("§aGadgets§f§8 {§aBalt Verfügbar§8}"));
        $player->getInventory()->setItem(8, Item::get(280)->setCustomName("§eSpieler Verstecken"));
        $player->removeAllEffects();
	    $player->getPlayer()->setHealth(20);
	        $player->getPlayer()->setFood(20);

	}
	
        public function killm(PlayerDeathEvent $event)
        {
            $event->setDeathMessage("");
        }

        

        public function TeleportItems(Player $player){          //Teleport
		$player->getInventory()->clearAll();
		$player->getInventory()->setItem(1, Item::get(19)->setCustomName("§6Community"));
		$player->getInventory()->setItem(2, Item::get(19)->setCustomName("§aSpawn"));
        $player->getInventory()->setItem(3, Item::get(267)->setCustomName("§7MiniSG"));
        $player->getInventory()->setItem(4, Item::get(19)->setCustomName("§fSky§4Wars"));
        $player->getInventory()->setItem(8, Item::get(351, 1)->setCustomName(C::RED."Zurück"));
        $player->removeAllEffects();
        $player->getPlayer()->setHealth(20);
        $player->getPlayer()->setFood(20);
	}
	
	public function InfoItems(Player $player){          //Info
		$player->getInventory()->clearAll();
		$player->getInventory()->setItem(0, Item::get(339)->setCustomName("§6Ts-3"));
        $player->getInventory()->setItem(1, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(2, Item::get(339)->setCustomName("You§4Tuber"));
        $player->getInventory()->setItem(3, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(4, Item::get(339)->setCustomName("§aWebseite"));
        $player->getInventory()->setItem(5, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(6, Item::get(339)->setCustomName("§bTeam"));
        $player->getInventory()->setItem(7, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(8, Item::get(351, 1)->setCustomName(C::RED."Zurück"));
        $player->removeAllEffects();
        $player->getPlayer()->setHealth(20);
        $player->getPlayer()->setFood(20);
    }
    
    public function LobbySwitcherItems(Player $player){          //LobbySwitcherItems
		$player->getInventory()->clearAll();
		$player->getInventory()->setItem(0, Item::get(348)->setCustomName("§6Premium §7{§cOFFLINE§7}"));
        $player->getInventory()->setItem(1, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(2, Item::get(353)->setCustomName("§aLobby1 §7{§aONLINE§7}"));
        $player->getInventory()->setItem(3, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(4, Item::get(353)->setCustomName("§aLobby2 §7{§cOFFLINE§7}"));
        $player->getInventory()->setItem(5, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(6, Item::get(353)->setCustomName("§aLobby3 §7{§cOFFLINE§7}"));
        $player->getInventory()->setItem(7, Item::get(101)->setCustomName(""));
        $player->getInventory()->setItem(8, Item::get(351, 1)->setCustomName(C::RED."Zurück"));
        $player->removeAllEffects();
        $player->getPlayer()->setHealth(20);
        $player->getPlayer()->setFood(20);
    }
    
	public function onJoin(PlayerJoinEvent $event){         //OnJoin
		$player = $event->getPlayer();
		$name = $player->getName();
	    $ds = $this->getServer()->getDefaultLevel()->getSafeSpawn();
        $player->setGamemode(0);
        $player->teleport($ds);
        $event->setJoinMessage("");
		$this->MainItems($player);
		$player->setGamemode(0);
		if($player->isOP()){
			$event->setJoinMessage("");
		}
	}
	
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
	    $event->setQuitMessage("");
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		$name = $sender->getName();
		switch ($cmd->getName()){
			case "Info":
			if(!empty($args[0])){
				if($args[0] == "team"){
					$sender->sendMessage($this->prefix . " §aDu kannst dich bei uns bewerben > www.bamcraftpe.de");
					return true;
				}
				if($args[0] == "youtuber"){
					$sender->sendMessage($this->prefix . "§atext");
					return true;
					}
				if($args[0] == "webseite"){
					$sender->sendMessage($this->prefix . "§atext");
					return true;
				}
				if($args[0] == "ts"){
					$sender->sendMessage($this->prefix . "§atext");
					return true;
				}
			}else{
				$sender->sendMessage($this->prefix. "§a/info team|youtuber|ts");
				return true;
			}
            case "Hub":
			if($sender instanceof Player){
				$ds = $this->getServer()->getDefaultLevel()->getSafeSpawn();
				$sender->teleport($ds);
				$sender->sendTitle("§aWillkommen am Spawn","$name");
				$level = $player->getLevel();
            	$level->addSound(new EndermanTeleportSound($player));
				$this->MainItems($sender);
				$sender->setHealth(20);
				$sender->setFood(20);
				return true;
			}
		}
	}
	
    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $name = $player->getName();
        $item = $player->getInventory()->getItemInHand();
        $itemid = $item->getID();
        $block = $event->getBlock();
      
        if($item->getName() == "§aLobby Switcher§f§8 {§aVerfügbar§8}"){
        	$level = $player->getLevel();
            $level->addSound(new ClickSound($player));
            $this->LobbySwitcherItems($player);
        }
               
        if($item->getName() == "§aLobby2 §7{§cOFFLINE§7}"){
            $player->sendTitle("§aLobby2 §aLobby ist","§7{§cOFFLINE§7}");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        if($item->getName() == "§aLobby3 §7{§cOFFLINE§7}"){
            $player->sendTitle("§aLobby3 §aLobby ist","§7{§cOFFLINE§7}");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        if($item->getName() == "§6Premium §7{§cOFFLINE§7}"){
            $player->sendTitle("§6Premium §aLobby ist","§7{§cOFFLINE§7}");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        if($item->getName() == "§aGadgets§f§8 {§aBalt Verfügbar§8}"){
            $player->sendTitle("§aGadgets","§bKommnt Balt");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        if($item->getName() == "§eSpieler Verstecken"){
        }

        if($item->getName() == "§aWeiter"){
        	$level = $player->getLevel();
            $level->addSound(new ClickSound($player));
            $this->WeiterItems($player);
        }

        if($item->getName() == "§5Teleporter§f§8 {§aVerfügbar§8}"){
            $level = $player->getLevel();
        	$level->addSound(new ClickSound($player));
            $this->TeleportItems($player);
        }         

        elseif ($item->getName() == "§aInfo§f§8 {§aVerfügbar§8}"){
        	$player->sendTitle("§aInfo");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
            $this->InfoItems($player);
        }

        elseif ($item->getName() == C::RED . "Zurück"){
            $this->MainItems($player);
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        elseif ($item->getName() == "You§4Tuber"){
            $player->sendTitle("You§4Tuber","You§4Tuber-namen");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        elseif ($item->getName() == "§aWebseite"){
            $player->sendTitle("§aWebseite","§aWebseite-namen");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }
        
        elseif ($item->getName() == "§bTeam"){
            $player->sendTitle("§bTeam","§bTeam-bewerben");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }

       elseif ($item->getName() == "§6Ts-3"){
            $player->sendTitle("§6Ts-3","§6TS-3Name");
            $level = $player->getLevel();
            $level->addSound(new ClickSound($player));
        }  
        
        elseif ($item->getName() == "§aLobby1 §7{§aONLINE§7}"){
        	$level = $player->getLevel();
        	$level->addSound(new EndermanTeleportSound($player));
            $this->MainItems($player);
            $x = 0;
            $y = 20;
            $z = 1;
            $player->teleport(new Vector3($x, $y, $z));
        }

        elseif ($item->getName() == "§7MiniSG"){
        	$level = $player->getLevel();
        	$level->addSound(new EndermanTeleportSound($player));
            $this->MainItems($player);
            $x = 7;
            $y = 48;
            $z = 85;
            $player->teleport(new Vector3($x, $y, $z));
        }
      
      elseif ($item->getName() == "§aSpawn"){
        	$level = $player->getLevel();
        	$level->addSound(new EndermanTeleportSound($player));
            $this->MainItems($player);
            $x = 0;
            $y = 20;
            $z = 1;
            $player->teleport(new Vector3($x, $y, $z));
        }
        
        elseif ($item->getName() == "§6Community"){
		    $level = $player->getLevel();
        	$level->addSound(new EndermanTeleportSound($player));
            $this->MainItems($player);
            $x = -134;
            $y = 28;
            $z = -139;
            $player->teleport(new Vector3($x, $y, $z));
        }
      
        elseif ($item->getName() == "§fSky§4Wars"){
        	$level = $player->getLevel();
        	$level->addSound(new EndermanTeleportSound($player));
            $this->MainItems($player);
            $x = -96;
            $y = 26;
            $z = 0;
            $player->teleport(new Vector3($x, $y, $z));
        }

        elseif ($item->getCustomName() == "§eSpieler Verstecken") {
            $player->getInventory()->remove(Item::get(280)->setCustomName("§eSpieler Verstecken"));
            $player->getInventory()->setItem(8, Item::get(369)->setCustomName("§eSpieler Anzeigen"));
            $level = $player->getLevel();
        	$level->addSound(new ClickSound($player));
            $player->sendTitle("§aAlle Spieler sind nun","unsichtbar!");
            $this->hideall[] = $player;
            foreach ($this->getServer()->getOnlinePlayers() as $p2) {
                $player->hideplayer($p2);
            }
        }

        elseif ($item->getCustomName() == "§eSpieler Anzeigen"){
            $player->getInventory()->remove(Item::get(369)->setCustomName("§eSpieler Anzeigen"));
            $player->getInventory()->setItem(8, Item::get(280)->setCustomName("§eSpieler Verstecken"));
            $level = $player->getLevel();
        	$level->addSound(new ClickSound($player));
            $player->sendTitle("§aAlle Spieler sind nun","wieder Sichtbar!");
            unset($this->hideall[array_search($player, $this->hideall)]);
            foreach ($this->getServer()->getOnlinePlayers() as $p2) {
                $player->showplayer($p2);
            }
        }
	}
	
	public function onBlockBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		if($player->isOP()){
			$event->setCancelled(false);
		}else{
			$event->setCancelled(true);
			$player->sendMessage($this->prefix.TextFormat::RED." Du kannst hier nichts kaputt machen".C::GRAY."!");
			$level = $player->getLevel();
        	$level->addSound(new DoorBumpSound($player));
		}
	}
	
	public function onBlockPlace(BlockPlaceEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		if($player->isOP()){
			$event->setCancelled(false);
		}else{
			$event->setCancelled(true);
			$player->sendMessage($this->prefix.TextFormat::RED." Du kannst hier nichts platzieren".C::GRAY."!");
			$level = $player->getLevel();
        	$level->addSound(new DoorBumpSound($player));
		}
	}
	
	public function onItemHeld(PlayerItemHeldEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand()->getID();
		switch($item){
			case 10:
			$player->getInventory()->setItemInHand(Item::get(Item::AIR, 0, 0));
			$player->sendMessage($this->prefix.TextFormat::RED." Du darfst keine lava benutzen");
			$level = $player->getLevel();
        	$level->addSound(new DoorBumpSound($player));
			$this->getLogger()->critical($name." versucht lava zu usen");
			return true;
			case 11:
			$player->getInventory()->setItemInHand(Item::get(Item::AIR, 0, 0));
			$player->sendMessage($this->prefix.TextFormat::RED." Du darfst keine lava benutzen");
			$level = $player->getLevel();
        	$level->addSound(new DoorBumpSound($player));
			$this->getLogger()->critical($name." versucht lava zu usen");
			return true;
			case 46:
			$player->getInventory()->setItemInHand(Item::get(Item::AIR, 0, 0));
			$player->sendMessage($this->prefix.TextFormat::RED." Du darfst kein Tnt benutzen");
			$level = $player->getLevel();
        	$level->addSound(new DoorBumpSound($player));
			$this->getLogger()->critical($name." versucht tnt zu usen");
			return true;
			case 325:
			$player->getInventory()->setItemInHand(Item::get(Item::AIR, 0, 0));
			$player->sendMessage($this->prefix.TextFormat::RED." Du darfst kein eimer benutzen");
			$level = $player->getLevel();
        	$level->addSound(new DoorBumpSound($player));
			$this->getLogger()->critical($name." versucht bucket zu usen");
			return true;
		}
	}
}
