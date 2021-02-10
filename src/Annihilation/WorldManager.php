<?php 

declare(strict_types = 1);

namespace Annihilation;

use pocketmine\Server;
use pocketmine\level\Level;

use Annihilation\game\Game;

class worldManager extends Level {

    public $plugin;

    public $level = []:
    
    public function __construct(Game $plugin)
    {
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    
    public function loadLevel(Level $level) {
     foreach($level->getFolderName as $levelName) {
       // $levelName = $levelName->getFolderName():
       $zip = new \ZipArchive();
       $levelZip = $this->getDataFolder("Annihilation\worlds\$levelName.zip");
       $levelPath = $this->getDataPath("worlds\", $zip->extract($levelZip);
    }
    
    public function saveLevel(Level $level) {
     foreach($level->getFolderName as $levelName) {
       // $levelName = $levelName->getFolderName():
       $levelZip = $this->getDataFolder("Annihilation\worlds\$levelName.zip");
       $levelZip->save();
    }
    
    public function getDataFolder(): string {
        return $this->plugin->getDataFolder();
    
    public function getDataPath(): string {
        return $this->plugin->getServer()->getDataPath();
    }
}
        
       
    
    
       
