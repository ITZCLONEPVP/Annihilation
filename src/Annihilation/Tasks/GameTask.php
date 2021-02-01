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
k   
 

   /** @var float|int $phase4 */

   public $phase4 = 20 * 60;
   

  

   /** @var float|int $phase2 */

   public $phase2 = 20 * 60;
   


