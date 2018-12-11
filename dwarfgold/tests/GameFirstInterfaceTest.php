<?php
use PHPUnit\Framework\TestCase;
use App\DwarfGold;
require_once('DwarfGold.php');

class GameFirstInterfaceTest extends TestCase
{
	public function testOptionsPlayers(){
		$sut = new DwarfGold();
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['numberOfPlayers']));
		$playerOptions = $options['numberOfPlayers'];
		$this->assertEquals(2, $playerOptions[0]);
		$this->assertEquals(3, $playerOptions[1]);
		$this->assertEquals(4, $playerOptions[2]);
	}
	public function testOptionsPlayersFactions(){
		$sut = new DwarfGold();
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['factions']));
		$factionOptions = $options['factions'];
		$this->assertEquals("Mage", $factionOptions[0]);
		$this->assertEquals("Orc", $factionOptions[1]);
		$this->assertEquals("Goblin", $factionOptions[2]);
		$this->assertEquals("Elf", $factionOptions[3]);
	}
	public function testOptionsAdvancedOptions(){
		$sut = new DwarfGold();
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['advanced']));
		$advancedOptions = $options['advanced'];
		$this->assertEquals("false", $advancedOptions[0]);
		$this->assertEquals("true", $advancedOptions[1]);
	}
	public function testOptionsPeekOptions(){
		$sut = new DwarfGold();
		$options = $sut->getGameOptions();
		$this->assertTrue(isset($options['peek']));
		$peekOptions = $options['peek'];
		$this->assertEquals("false", $peekOptions[0]);
		$this->assertEquals("true", $peekOptions[1]);
	}
}