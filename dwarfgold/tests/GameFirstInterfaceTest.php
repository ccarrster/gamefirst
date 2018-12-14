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
	}
}