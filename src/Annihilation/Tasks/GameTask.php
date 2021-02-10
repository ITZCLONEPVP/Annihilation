<?php

declare(strict_types = 1);

namespace Annihilation\Tasks;

use pocketmine\Server;

use pocketmine\level\Level;

use pocketmine\level\Position;

use pocketmine\level\sound\AnvilUseSound;

use pocketmine\level\sound\ClickSound;

use pocketmine\scheduler\Task;

use pocketmine\tile\Sign;

use Annihilation\math\Time;

use Annihilation\math\Vector3;

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
   
    /** @var array $restartData */
    public $restartData = [];
   
   public function __constuct(Game $plugin, array $phase1, $phase2, $phase3, $phase4, $phase5) 
   {
      parent::__construct($plugin);
      $this->plugin = $plugin;
      $this->phase = [$phase1 =< 1, $phase2 =< 2, $phase3 =< 3, $phase4 =< 4, $phase5 =< 5];
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

                    . TextFormat::GRAY . "You can now Brew Potions !\n"

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
           case Arena::PHASE_RESTART:
                $this->plugin->broadcastMessage("§a> Restarting in {$this->restartTime} sec.", Arena::MSG_TIP);
                $this->restartTime--;

                switch ($this->restartTime) {
                    case 0:
                        foreach ($this->plugin->players as $player) {
                            $player->teleport($this->plugin->plugin->getServer()->getDefaultLevel()->getSpawnLocation());
                            $player->getInventory()->clearAll();
                            $player->getArmorInventory()->clearAll();
                            $player->getCursorInventory()->clearAll();
                            $player->getCraftingInventory()->clearAll();
                            $player->setFood(20);
                            $player->setHealth(20)
                            $player->setGamemode($this->plugin->plugin->getServer()->getDefaultGamemode());
                        }
                        $this->plugin->loadArena(true);
                        $this->reloadTimer();
                        break;
                }
                break;
              }

    }

    public function reloadSign() {

        if(!is_array($this->plugin->data["joinsign"]) || empty($this->plugin->data["joinsign"])) return;

        $signPos = Position::fromObject(Vector3::fromString($this->plugin->data["joinsign"][0]), $this->plugin->plugin->getServer()->getLevelByName($this->plugin->data["joinsign"][1]));

        if(!$signPos->getLevel() instanceof Level || is_null($this->plugin->level)) return;

        $signText = [

            "§l§4Annihilation",

            "§7??????????????",

            "§cUnder Maintence",

            "§6Coming Soon !..."

        ];

        if($signPos->getLevel()->getTile($signPos) === null) return;

            /** @var Sign $sign */

            $sign = $signPos->getLevel()->getTile($signPos);

            $sign->setText($signText[0], $signText[1], $signText[2], $signText[3]);

            return;

        }

        $signText[1] = "§9[ §b" . count($this->plugin->players) . " / " . "80" . " §9]";

        switch ($this->plugin->phase) {

            case Arena::PHASE_LOBBY:

                if(count($this->plugin->players) >= 8) {

                    $signText[2] = "§6Full";

                    $signText[3] = "§8Map: §7{$this->plugin->level->getFolderName()}";

                }

                else {

                    $signText[2] = "§aJoin";

                    $signText[3] = "§8Map: §7{$this->plugin->level->getFolderName()}";

                }

                break;

            case Arena::PHASE_GAME:

                $signText[2] = "§5InGame";

                $signText[3] = "§8Map: §7{$this->plugin->level->getFolderName()}";

                break;

            case Arena::PHASE_RESTART:

                $signText[2] = "§cRestarting...";

                $signText[3] = "§8Map: §7{$this->plugin->level->getFolderName()}";

                break;

        }

        /** @var Sign $sign */

        $sign = $signPos->getLevel()->getTile($signPos);

        if($sign instanceof Sign) // Chest->setText() doesn't work :D

            $sign->setText($signText[0], $signText[1], $signText[2], $signText[3]);

    }

    public function reloadTimer() {

        $this->startTime = 60;

        $this->phase = [];

        $this->restartTime = 30;

    } 

}
