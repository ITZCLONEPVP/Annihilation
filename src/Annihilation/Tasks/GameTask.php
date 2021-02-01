<?php

declare(strict_types = 1);

namespace Annihilation\Tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;

use Annihilation\game\Game;

class GameTask extends Task {
   
   /** @var Game[] $plugin */
   public $plugin;
   
   /** @var int[] StartTime */
   public $startTime = 60;
   
   /** @var int[] $restartTime */
   public $restartTime = 20;
   
   /** @var float|int $phase1 */
   public $phase1 = 20 * 60;

   /** @var float|int $phase2 */
   public $phase2 = 20 * 60;
   
   /** @var float|int $phase3 */
   public $phase3 = 20 * 60;
   
   /** @var float|int $phase4 */
   public $phase4 = 20 * 60;

   /** @var float|int $phase5 */
   public $phase5 = 20 * 60;
   
   public function __constuct(Game $plugin) 
   {
      parent::__construct($plugin);
      $this->plugin = $plugin;
   }
   
   public function onRun(int $currentTick) {
       $this->reloadSign();

        switch ($this->plugin->phase) {

            case Arena::PHASE_LOBBY:

                if(count($this->plugin->players) >= 8) {

                    $this->plugin->broadcastMessage("§a> Starting in " . Time::calculateTime($this->startTime) . " sec.", Arena::MSG_TIP);

                    $this->startTime--;

                    if($this->startTime == 0) {

                        $this->plugin->startGame();

                        foreach ($this->plugin->players as $player) {

                            $this->plugin->playSound($player, "mob.wither.spawn");

                        }

                    }

                    else {

                        foreach ($this->plugin->players as $player) {

                            $this->plugin->level->addSound(new ClickSound($player->asVector3()));

                        }

                    }

                }

                else {

                    $this->plugin->broadcastMessage("§c> You need more players to start a game!", Arena::MSG_TIP);

                    $this->startTime = 60;

                }

                break;
              }
            case Arena::PHASE_GAME:

                $this->plugin->broadcastMessage("§a> There are " . count($this->plugin->players) . " players, time to end: " . Time::calculateTime($this->gameTime) . "", Arena::MSG_TIP);

                switch ($this->gameTime) {
                case $phase1:
                    $this->plugin->broadcastMessage(TextFormat::GRAY . "===========[ " . TextFormat::DARK_AQUA . "Progress" . TextFormat::GRAY . " ]===========\n"

                    . TextFormat::BLUE . "Phase I " . TextFormat::GRAY . "has started\n"

                    . TextFormat::GRAY . "Each nexus is invicible until Phase II\n"

                    . TextFormat::GRAY . "==================================");

                    break;
                case $phase2:
                    $this->plugin->bossManager()->spawnBosses();
                    $this->plugin->broadcastMessage(TextFormat::GRAY . "===========[ " . TextFormat::DARK_AQUA . "Progress" . TextFormat::GRAY . " ]===========\n"

                    . TextFormat::GREEN . "Phase II " . TextFormat::GRAY . "has started\n"

                    . TextFormat::GRAY . "Each nexus is no longer invicible\n"

                    . TextFormat::GRAY . "Boss Iron Golems will now spawn\n"

                    . TextFormat::GRAY . "==================================");
                    break;
                case $phase3:
.                   $this->plugin->spawnDiamonds(true);  
                    $this->plugin->bossManager()->spawnBosses()
                    $this->plugin->broadcastMessage(TextFormat::GRAY . "===========[ " . TextFormat::DARK_AQUA . "Progress" . TextFormat::GRAY . " ]===========\n"

                    . TextFormat::YELLOW . "Phase III " . TextFormat::GRAY . "has started\n"

                    . TextFormat::GRAY . "Diamonds now spawn in the middle\n"

                    . TextFormat::GRAY . "==================================");
                     break;
                case $phase4:
                    $this->plugin->bossManager()->spawnBosses();
                    $this->plugin->broadcastMessage(TextFormat::GRAY . "===========[ " . TextFormat::DARK_AQUA . "Progress" . TextFormat::GRAY . " ]===========\n"

                    . TextFormat::GOLD . "Phase IV " . TextFormat::GRAY . "has started\n"

                    . TextFormat::GRAY . "Now you can brew strength\n"

                    . TextFormat::GRAY . "==================================");
                    break;
                 case $phase5:
                    $this->plugin->bossManager()->spawnBosses();
                    $this->plugin->broadcastMessage(TextFormat::GRAY . "===========[ " . TextFormat::DARK_AQUA . "Progress" . TextFormat::GRAY . " ]===========\n"

                    . TextFormat::RED . "Phase V " . TextFormat::GRAY . "has started\n"

                    . TextFormat::RED . "Double nexus damage\n"

                    . TextFormat::GRAY . "==================================");
                     break;

                }

                if($this->plugin->checkEnd()) $this->plugin->startRestart();

                $this->gameTime--;
                break;

   
   




   

