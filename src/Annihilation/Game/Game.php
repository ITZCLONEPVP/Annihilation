§t<?php

namespace Annihilation\Game;

class Game{
  
  public $rednexus = 75;
  public $bluenexus = 75;
  public $yellownexus = 75;
  public $greennexus = 75;
  public $started = false;
  public $players = [];
  
  public function __construct($id, Annihilation $plugin){
    $this->id = $id;
    $this->plugin = $plugin;
    $this->redspawn = $plugin->data[$this->id]["spawn1"];
    $this->bluespawn = $plugin->data[$this->id]["spawn2"];
    $this->greenspawn = $plugin->data[$this->id]["spawn3"];
    $this->yellspawn = $plugin->data[$this->id]["spawn4"];
    $this->m
  }
  
  public function getPlayers(){
    foreach($this->players as $p){
      return $p;
    }
  }
  
  public function startGame(){
    $this->started = true;
    $this->setPhase(1);
  }
  
  public function setPhase($phase){
    switch($phase){
        case 1;
        $this->getPlayers()->sendMessage("§aPhase 1 started");
        $this->phase = 1;
    }
  }
  
  public function teleportToGame(Player $p){
    //TODO
    $p->sendMessage(Annihilation::PREFIX . "§aJoining to $this->id");
  }
}
