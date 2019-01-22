<?php
use PHPUnit\Framework\TestCase;
use App\DwarfGold;
require_once('DwarfGold.php');
require_once('../FilePersistance.php');

class GameFirstInterfaceTest extends TestCase
{
	public function testOptionsPlayers(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['numberOfPlayers']));
		$playerOptions = $options['numberOfPlayers'];
		$this->assertEquals(2, $playerOptions[0]);
		$this->assertEquals(3, $playerOptions[1]);
		$this->assertEquals(4, $playerOptions[2]);
	}
	public function testOptionsPlayersFactions(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['factions']));
		$factionOptions = $options['factions'];
		$this->assertEquals("Mage", $factionOptions[0]);
		$this->assertEquals("Orc", $factionOptions[1]);
		$this->assertEquals("Goblin", $factionOptions[2]);
		$this->assertEquals("Elf", $factionOptions[3]);
	}
	public function testOptionsAdvancedOptions(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['advanced']));
		$advancedOptions = $options['advanced'];
		$this->assertEquals("false", $advancedOptions[0]);
		$this->assertEquals("true", $advancedOptions[1]);
	}
	public function testOptionsPeekOptions(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['peek']));
		$peekOptions = $options['peek'];
		$this->assertEquals("false", $peekOptions[0]);
		$this->assertEquals("true", $peekOptions[1]);
	}
	public function testStartGameGameId(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame([]);
		$this->assertEquals(null, $result->gameId);
	}
	public function testStartGamePlayers(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame([]);
		$this->assertEquals(0, count($result->players));
	}
	public function testStartGameGoldenPath2(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Mage', 'Orc'], 'advanced'=>"false", 'peek'=>'false']);
		$this->assertEquals(2, count($result->players));
	}

	public function testPublicGameState(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Mage', 'Orc'], 'advanced'=>"false", 'peek'=>'false']);
		$gameId = $result->gameId;
		$this->assertTrue($gameId != null);
		$gameState = $sut->getPublicGameState($gameId);
		$this->assertTrue($gameState != null);
		$this->assertEquals(2, count($gameState->players));
	}
	public function testPublicGameState3(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>3, 'factions'=>['Mage', 'Orc', 'Elf'], 'advanced'=>"false", 'peek'=>'false']);
		$gameId = $result->gameId;
		$this->assertTrue($gameId != null);
		$gameState = $sut->getPublicGameState($gameId);
		$this->assertTrue($gameState != null);
		$this->assertEquals(3, count($gameState->players));
	}
	public function testPublicGameState4(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>4, 'factions'=>['Mage', 'Orc', 'Elf', 'Goblin'], 'advanced'=>"false", 'peek'=>'false']);
		$gameId = $result->gameId;
		$this->assertTrue($gameId != null);
		$gameState = $sut->getPublicGameState($gameId);
		$this->assertTrue($gameState != null);
		$this->assertEquals(4, count($gameState->players));
	}
	public function testPublicPowerToken(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Mage', 'Orc'], 'advanced'=>"false", 'peek'=>'false']);
		$gameId = $result->gameId;
		$this->assertTrue($gameId != null);
		$gameState = $sut->getPublicGameState($gameId);
		$players = $gameState->players;
		foreach($players as $player){
			$this->assertEquals(0, $player->powerTokens);
		}
	}
	public function testPublicPowerTokenTwo(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Mage', 'Elf'], 'advanced'=>"true", 'peek'=>'false']);
		$gameId = $result->gameId;
		$this->assertTrue($gameId != null);
		$gameState = $sut->getPublicGameState($gameId);
		$players = $gameState->players;
		foreach($players as $player){
			$this->assertEquals(2, $player->powerTokens);
		}
	}
	public function testPublicPowerTokenOne(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"true", 'peek'=>'false']);
		$gameId = $result->gameId;
		$gameState = $sut->getPublicGameState($gameId);
		$players = $gameState->players;
		foreach($players as $player){
			$this->assertEquals(1, $player->powerTokens);
		}
	}
	public function testPublicCountPalisades(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"true", 'peek'=>'false']);
		$gameId = $result->gameId;
		$gameState = $sut->getPublicGameState($gameId);
		$this->assertEquals(35, $gameState->palisades);
	}
	public function testPublicBoard(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"true", 'peek'=>'false']);
		$gameId = $result->gameId;
		$gameState = $sut->getPublicGameState($gameId);
		$board = $gameState->board;
		$this->assertTrue($board != null);
		$cell = $board->cells[0][0];
		$this->assertTrue($cell != null);
	}
	public function testPublicBoardFaction(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"true", 'peek'=>'false']);
		$gameId = $result->gameId;
		$gameState = $sut->getPublicGameState($gameId);
		$board = $gameState->board;
		$this->assertTrue($board != null);
		$cell = $board->cells[0][0];
		$this->assertEquals(null, $cell->faction);
		$this->assertEquals(false, $cell->hasReinforcement);
		$this->assertFalse($cell->southPalisade);
		$this->assertFalse($cell->eastPalisade);
		$this->assertEquals(0, $cell->gold);
		$this->assertEquals(0, $cell->arrows);
	}
	public function testPrivateState(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"true", 'peek'=>'false']);
		$gameId = $result->gameId;
		$gameState = $sut->getPrivateGameState($gameId, 'Orc');
		$this->assertTrue($gameState != null);
		$this->assertTrue($gameState->player != null);
		$this->assertTrue(count($gameState->player->warriors) === 5);
		$this->assertEquals(11, $gameState->player->warriors[0]);
		$this->assertEquals(2, $gameState->player->warriors[1]);
		$this->assertEquals(1, $gameState->player->warriors[2]);
		$this->assertEquals(1, $gameState->player->warriors[3]);
		$this->assertEquals(1, $gameState->player->warriors[4]);
		$this->assertEquals(1, $gameState->player->reinforcements);
	}
	public function testOptions(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"true", 'peek'=>'true']);
		$gameId = $result->gameId;
		$options = $sut->getAvailableOptions($gameId, 'Orc');
		$goblinOptions = $sut->getAvailableOptions($gameId, 'Goblin');
		$this->assertTrue((6 == count($options) &&  0 == count($goblinOptions)) || (6 == count($goblinOptions) && 0 == count($options)));
	}

	public function testNonAdvancedOptions(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"false", 'peek'=>'true']);
		$gameId = $result->gameId;
		$options = $sut->getAvailableOptions($gameId, 'Orc');
		$goblinOptions = $sut->getAvailableOptions($gameId, 'Goblin');
		$this->assertTrue((4 == count($options) &&  0 == count($goblinOptions)) || (4 == count($goblinOptions) && 0 == count($options)));
	}
	public function testNonAdvancedNonPeekOptions(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"false", 'peek'=>'false']);
		$gameId = $result->gameId;
		$options = $sut->getAvailableOptions($gameId, 'Orc');
		$goblinOptions = $sut->getAvailableOptions($gameId, 'Goblin');
		$this->assertTrue((3 == count($options) &&  0 == count($goblinOptions)) || (3 == count($goblinOptions) && 0 == count($options)));
	}
	public function testPeekZero(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"false", 'peek'=>'true']);
		$gameId = $result->gameId;
		$options = $sut->getAvailableOptions($gameId, 'Orc');
		$goblinOptions = $sut->getAvailableOptions($gameId, 'Goblin');
		if(count($options) !== 0){
			$currentOptions = $options;
		} else {
			$currentOptions = $goblinOptions;
		}
		$this->assertTrue(isset($currentOptions['Peek']));
		$this->assertEquals(0, count($currentOptions['Peek']));
	}
	public function testWarrior(){
		$persistance = new FilePersistance();
		$sut = new DwarfGold($persistance);
		$result = $sut->startGame(['numberOfPlayers'=>2, 'factions'=>['Orc', 'Goblin'], 'advanced'=>"false", 'peek'=>'true']);
		$gameId = $result->gameId;
		$options = $sut->getAvailableOptions($gameId, 'Orc');
		$goblinOptions = $sut->getAvailableOptions($gameId, 'Goblin');
		$player = '';
		if(count($options) !== 0){
			$player = 'Orc';
			$currentOptions = $options;
		} else {
			$player = 'Goblin';
			$currentOptions = $goblinOptions;
		}
		$this->assertTrue(isset($currentOptions['Warrior']));
		$this->assertTrue(count($currentOptions['Warrior']) > 0);
		$option = new stdClass();
		$option->type = 'Warrior';
		$option->x = $currentOptions['Warrior'][0]->x;
		$option->y = $currentOptions['Warrior'][0]->y;
		$option->strength = '1';
		$result = $sut->chooseOption($gameId, $player, $option);
		$this->assertTrue($result);
		$option = new stdClass();
		$option->type = 'Pass';
		$sut->chooseOption($gameId, $player, $option);
		$options = $sut->getAvailableOptions($gameId, 'Orc');
		$goblinOptions = $sut->getAvailableOptions($gameId, 'Goblin');
		$player = '';
		if(count($options) !== 0){
			$player = 'Orc';
			$currentOptions = $options;
		} else {
			$player = 'Goblin';
			$currentOptions = $goblinOptions;
		}
		$this->assertEquals(1, count($currentOptions['Peek']));
	}
}