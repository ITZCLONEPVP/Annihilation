<?php

namespace Annihilation;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Annihilation extends PluginBase implements Listener{
  
     const PREFIX = "§l§9Annihilation §r";
     public $games;
     public $data;
  
     public function onEnable(){
         $this->getServer()->getPluginManager()->registerEvets($this, $this);
         $this->setGameData();
         $this->getLogger()->info("Enabled Annihilation plugin.");
     }
  
     public function setGameData(){
       $this->games = ["anni-1" => ["sign-join" => new Vector3(1,1,1),
                                    "max-players" => 100,
                                    "min-players" => 2]];
     }
  
     public function getData(Player $p){
       return  $this->playerData[$player->getId()] = $data = new PlayerData($p->getName());
     }
  
     public function isPlaying(Player $p){
       if($this->getData()->isingame == false){
         return false;
     }else{
         return true;
       }
  
     public function onNexusBreak($nexus, BlockBreakEvent $e){
       $p = $e->getPlayer();
       $b = $e->getBlock();
       if($this->isPlaying($p){
         if($b instaceof /*Nexus*/){
           //TODO 
         }
       }
     }
  
     public function setMapData(){
       $this->data = ["Canyon" => ["spawn-1" => new Vector3(1,1,1),
                                   "spawn-2" => new Vector3(1,1,1),
                                   "spawn-3" => new Vector3(1,1,1),
                                   "spawn-4" => new Vector3(1,1,1),
                                   "boss-1" => new Vector3(1,1,1),
                                   "boss-2" => new Vector3(1,1,1)]]; // More positions are TODO, now I want only spawns for testing.
                                                     
     }
 
     public function inInGame($game){
       $gejm = new Game($game, $this);
       if($gejm->ingame == false){
         return false;
       }else{
         return true;
     }
  
  
}
