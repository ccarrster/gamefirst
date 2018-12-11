<?php
use PHPUnit\Framework\TestCase;
use App\Game;
use App\Board;
use App\Player;
require_once('Game.php');
require_once('Board.php');
require_once('Player.php');

class JimmyTest extends TestCase
{
    public function testGameHasABoard()
    {
        $game = new Game();
        $board = $game->getBoard();
        $this->assertTrue(null !== $board);
    }

    public function testBoard00()
    {
        $board = new Board();
        $cell = $board->getCell(0,0);        
        $this->assertTrue(null !== $cell);
    }
    public function testBoard70()
    {
        $board = new Board();
        $cell = $board->getCell(7,0);        
        $this->assertTrue(null !== $cell);
    }
    public function testBoard74()
    {
        $board = new Board();
        $cell = $board->getCell(7,4);        
        $this->assertTrue(null !== $cell);
    }
    public function testBoard04()
    {
        $board = new Board();
        $cell = $board->getCell(0,4);        
        $this->assertTrue(null !== $cell);
    }
    public function testBoardm10()
    {
        $board = new Board();
        $cell = $board->getCell(-1,0);
        $this->assertTrue(null === $cell);   
    }
    public function testBoard0m1()
    {
        $board = new Board();
        $cell = $board->getCell(0,-1);
        $this->assertTrue(null === $cell);   
    }
    public function testBoard05()
    {
        $board = new Board();
        $cell = $board->getCell(0,5);
        $this->assertTrue(null === $cell);   
    }
    public function testBoard80()
    {
        $board = new Board();
        $cell = $board->getCell(8,0);
        $this->assertTrue(null === $cell);   
    }
    public function testBoard85()
    {
        $board = new Board();
        $cell = $board->getCell(8,5);
        $this->assertTrue(null === $cell);   
    }
    public function testBoardGoldSpaces30(){
        $board = new Board();
        $cell = $board->getCell(3,0);
        $result = $cell->hasGold();
        $this->assertTrue($result);      
    }
    public function testBoardGoldSpaces00(){
        $board = new Board();
        $cell = $board->getCell(0,0);
        $result = $cell->hasGold();
        $this->assertFalse($result);      
    }
    public function testFactionsOrc(){
        $game = new Game();
        $result = $game->getFactions();
        $this->assertTrue(in_array("Orc", $result));
    }
    public function testFactionsGoblin(){
        $game = new Game();
        $result = $game->getFactions();
        $this->assertTrue(in_array("Goblin", $result));
    }
    public function testFactionsElf(){
        $game = new Game();
        $result = $game->getFactions();
        $this->assertTrue(in_array("Elf", $result));
    }
    public function testFactionsMage(){
        $game = new Game();
        $result = $game->getFactions();
        $this->assertTrue(in_array("Mage", $result));
    }
    public function testFactionsCount(){
        $game = new Game();
        $result = $game->getFactions();
        $this->assertEquals(4, count($result));
    }
    public function testGetAvailableFactions(){
        $game = new Game();
        $result = $game->getAvailableFactions();
        $this->assertEquals(4, count($result));
    }
    public function testTakeAvailableFactionsOrc(){
        $game = new Game();
        $result = $game->takeFaction("Orc");
        $this->assertTrue($result);
    }
    public function testTakeAvailableFactionsOrcTwice(){
        $game = new Game();
        $game->takeFaction("Orc");
        $result = $game->takeFaction("Orc");
        $this->assertFalse($result);
    }
    public function testTakeAvailableFactionsOrcCount(){
        $game = new Game();
        $game->takeFaction("Orc");
        $result = $game->getAvailableFactions();
        $this->assertEquals(3, count($result));
    }
    public function testAvailableFactionsOrc(){
        $game = new Game();
        $result = $game->getAvailableFactions();
        $this->assertTrue(in_array("Orc", $result));
    }
    public function testAvailableFactionsGoblin(){
        $game = new Game();
        $result = $game->getAvailableFactions();
        $this->assertTrue(in_array("Goblin", $result));
    }
    public function testAvailableFactionsElf(){
        $game = new Game();
        $result = $game->getAvailableFactions();
        $this->assertTrue(in_array("Elf", $result));
    }
    public function testAvailableFactionsMage(){
        $game = new Game();
        $result = $game->getAvailableFactions();
        $this->assertTrue(in_array("Mage", $result));
    }
    public function testPlayer(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $this->assertEquals("Mage", $player->getFaction());
    }
    public function testPlayerResult(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $this->assertTrue($game->chooseFaction($key, "Mage"));
    }
    public function testPlayerResultTwo(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $this->assertFalse($game->chooseFaction($key, "Mage"));
    }
    public function testPlayerResultPickTwo(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $this->assertFalse($game->chooseFaction($key, "Orc"));
    }
    public function testTwoPlayerResult(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $this->assertTrue($game->chooseFaction($keyA, "Orc"));
    }
    public function testTwoPlayerResultSame(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $this->assertFalse($game->chooseFaction($keyA, "Mage"));
    }
    public function testWarriorsTwoPlayers(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $this->assertEquals(11, $game->getWarriors($key)[0]);
        $this->assertEquals(2, $game->getWarriors($key)[1]);
        $this->assertEquals(1, $game->getWarriors($key)[2]);
        $this->assertEquals(1, $game->getWarriors($key)[3]);
        $this->assertEquals(1, $game->getWarriors($key)[4]);
    }
    public function testWarriorsThreePlayers(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $this->assertEquals(7, $game->getWarriors($keyB)[0]);
        $this->assertEquals(2, $game->getWarriors($keyB)[1]);
        $this->assertEquals(1, $game->getWarriors($keyB)[2]);
        $this->assertEquals(1, $game->getWarriors($keyB)[3]);
        $this->assertEquals(0, $game->getWarriors($keyB)[4]);
    }
    public function testWarriorsFourPlayers(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $this->assertEquals(5, $game->getWarriors($keyB)[0]);
        $this->assertEquals(1, $game->getWarriors($keyB)[1]);
        $this->assertEquals(1, $game->getWarriors($keyB)[2]);
        $this->assertEquals(1, $game->getWarriors($keyB)[3]);
        $this->assertEquals(0, $game->getWarriors($keyB)[4]);
    }
    public function testGoldDistribution(){
        $board = new Board();
        $goldAmount = 0;
        $goldAmount += $board->getCell(3, 0)->getGold();
        $goldAmount += $board->getCell(1, 1)->getGold();
        $goldAmount += $board->getCell(5, 1)->getGold();
        $goldAmount += $board->getCell(7, 1)->getGold();
        $goldAmount += $board->getCell(0, 3)->getGold();
        $goldAmount += $board->getCell(4, 3)->getGold();
        $goldAmount += $board->getCell(2, 4)->getGold();
        $goldAmount += $board->getCell(6, 4)->getGold();
        $this->assertEquals(40, $goldAmount);
    }
    public function testGetPalisadeCount(){
        $game = new Game();
        $this->assertEquals(35, $game->getPalisadeCount());
    }
    public function testCellPalisadeSouth(){
        $board = new Board();
        $cell = $board->getCell(0, 0);
        $this->assertFalse($cell->hasPalisade("south"));
    }
    public function testCellPalisadeEast(){
        $board = new Board();
        $cell = $board->getCell(0, 0);
        $this->assertFalse($cell->hasPalisade("east"));
    }
    public function testCanPeek(){
        $game = new Game();
        $this->assertFalse($game->getCanPeek());
    }
    public function testCanPeekTrue(){
        $game = new Game();
        $game->setCanPeek(true);
        $this->assertTrue($game->getCanPeek());
    }
    public function testAdvancedMode(){
        $game = new Game();
        $this->assertFalse($game->getAdvancedMode());
    }
    public function testSetAdvancedMode(){
        $game = new Game();
        $game->setAdvancedMode(true);
        $this->assertTrue($game->getAdvancedMode());
    }
    public function testSetAdvancedTokens(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupAdvancedTokens();
        $this->assertEquals(0, $player->getPowerTokens());
    }

    public function testSetAdvancedTokensMage(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setAdvancedMode(true);
        $game->setupAdvancedTokens();
        $this->assertEquals(2, $player->getPowerTokens());
    }
    public function testSetAdvancedTokensOrc(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setAdvancedMode(true);
        $game->setupAdvancedTokens();
        $this->assertEquals(1, $playerA->getPowerTokens());
    }
    public function testSetAdvancedTokensElf(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setAdvancedMode(true);
        $game->setupAdvancedTokens();
        $this->assertEquals(2, $playerB->getPowerTokens());
    }
    public function testSetAdvancedTokensGoblin(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setAdvancedMode(true);
        $game->setupAdvancedTokens();
        $this->assertEquals(1, $playerC->getPowerTokens());
    }
    public function testReinforcments(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupAdvancedTokens();
        $this->assertEquals(0, $player->getReinforcments());
    }
    public function testReinforcmentsAdvanced(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setAdvancedMode(true);
        $game->setupAdvancedTokens();
        $this->assertEquals(1, $player->getReinforcments());
    }
    public function testPlayerOrder(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $this->assertTrue($currentPlayer == $player || $currentPlayer == $playerA || $currentPlayer == $playerB || $currentPlayer == $playerC);
    }
    public function testPlayerOrderNext(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->nextPlayer();
        $currentPlayer2 = $game->getCurrentPlayer();
        $this->assertNotEquals($currentPlayer, $currentPlayer2);
    }
    public function testPlayerOrderNextLoop(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->nextPlayer();
        $game->nextPlayer();
        $game->nextPlayer();
        $game->nextPlayer();
        $currentPlayer2 = $game->getCurrentPlayer();
        $this->assertEquals($currentPlayer, $currentPlayer2);
    }
    public function testPlaceWarrior(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertEquals(5, $currentPlayer->getWarriors()[0]);
        $this->assertTrue($game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0));
        $this->assertEquals(4, $currentPlayer->getWarriors()[0]);
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertEquals(1, $cell->getValue());
        $this->assertEquals($faction, $cell->getFaction());
    }
    public function testPlaceWarriorTwice(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $this->assertFalse($game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0));
    }
    public function testPlaceWarriorEmpty(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertEquals(0, $currentPlayer->getWarriors()[4]);
        $this->assertFalse($game->placeWarrior($currentPlayer->getFaction(), 5, 0, 0));
    }
    public function testPlaceWarriorValue(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertEquals(1, $currentPlayer->getWarriors()[3]);
        $this->assertTrue($game->placeWarrior($currentPlayer->getFaction(), 4, 0, 0));
        $this->assertEquals(0, $currentPlayer->getWarriors()[3]);
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertEquals(4, $cell->getValue());
        $this->assertEquals($faction, $cell->getFaction());
    }

    public function testPlacePalisadeEast(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertFalse($cell->hasPalisade('east'));
        $game->placePalisade($faction, "east", 0, 0);
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertTrue($cell->hasPalisade('east'));
    }
    public function testPlacePalisadeSouth(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertFalse($cell->hasPalisade('south'));
        $game->placePalisade($faction, "south", 0, 0);
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertTrue($cell->hasPalisade('south'));
    }
    public function testPlacePalisadeTwice(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $cell = $game->getBoard()->getCell(0, 0);
        $this->assertTrue($game->placePalisade($faction, "south", 0, 0));
        $this->assertFalse($game->placePalisade($faction, "south", 0, 0));
        $cell = $game->getBoard()->getCell(0, 0);
    }
    public function testPlacePalisadeInvalidSouth(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $cell = $game->getBoard()->getCell(0, 4);
        $this->assertFalse($game->placePalisade($faction, "south", 0, 4));
    }
    public function testPlacePalisadeValidShape(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertTrue($game->placePalisade($faction, "south", 0, 0));
        $this->assertTrue($game->placePalisade($faction, "south", 1, 0));
        $this->assertTrue($game->placePalisade($faction, "south", 2, 0));
        $this->assertTrue($game->placePalisade($faction, "south", 3, 0));
        $this->assertTrue($game->placePalisade($faction, "east", 3, 0));
    }
    public function testPlacePalisadeInvalidShape(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertTrue($game->placePalisade($faction, "south", 0, 0));
        $this->assertTrue($game->placePalisade($faction, "south", 1, 0));
        $this->assertTrue($game->placePalisade($faction, "south", 2, 0));
        $this->assertFalse($game->placePalisade($faction, "east", 2, 0));
        $this->assertFalse($game->getBoard()->getCell(2, 0)->hasPalisade('east'));
    }
    public function testPlacePalisadeInvalidShape2(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertTrue($game->placePalisade($faction, "east", 0, 0));
        $this->assertTrue($game->placePalisade($faction, "east", 1, 0));
        $this->assertTrue($game->placePalisade($faction, "east", 2, 0));
        $this->assertFalse($game->placePalisade($faction, "south", 2, 0));
        $this->assertFalse($game->getBoard()->getCell(2, 0)->hasPalisade('south'));
    }

    public function testPlacePalisadeValidShapeBottomLeft(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertTrue($game->placePalisade($faction, "south", 0, 2));
        $this->assertTrue($game->placePalisade($faction, "south", 1, 2));
        $this->assertTrue($game->placePalisade($faction, "east", 1, 3));
        $this->assertTrue($game->placePalisade($faction, "east", 1, 4));
    }

    public function testPlacePalisadeValidShapeBottomRight(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $this->assertTrue($game->placePalisade($faction, "south", 6, 2));
        $this->assertTrue($game->placePalisade($faction, "south", 7, 2));
        $this->assertTrue($game->placePalisade($faction, "east", 5, 3));
        $this->assertTrue($game->placePalisade($faction, "east", 5, 4));
    }
    public function testGetTerritories1(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $territories = $game->getTerritories();
        $this->assertEquals(1, count($territories));
    }
    public function testGetTerritories2(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $game->placePalisade($faction, "south", 6, 2);
        $game->placePalisade($faction, "south", 7, 2);
        $game->placePalisade($faction, "east", 5, 3);
        $game->placePalisade($faction, "east", 5, 4);
        $territories = $game->getTerritories();
        $this->assertEquals(2, count($territories));
    }
    public function testGetGold(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $territories = $game->getTerritories();
        $this->assertEquals(40, $game->getTerritoryGold($territories[0]));
    }
    public function testGetGold2(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $game->placePalisade($faction, "south", 6, 2);
        $game->placePalisade($faction, "south", 7, 2);
        $game->placePalisade($faction, "east", 5, 3);
        $game->placePalisade($faction, "east", 5, 4);
        
        $territories = $game->getTerritories();
        $gold = 0;
        $oneGold = $game->getBoard()->getCell(6, 4)->getGold();
        $this->assertTrue($oneGold === $game->getTerritoryGold($territories[0]) || $oneGold === $game->getTerritoryGold($territories[1]));
        foreach($territories as $territory){
            $gold += $game->getTerritoryGold($territory);
        }
        $this->assertEquals(40, $gold);
    }

    public function testWarriorTerritory(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $territories = $game->getTerritories();
        $result = $game->getTerritoryWarriorSum($territories[0]);
        $this->assertEquals(0, $result["Mage"]);
        $this->assertEquals(0, $result["Orc"]);
    }
    public function testWarriorTerritory2(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $faction = $currentPlayer->getFaction();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $territories = $game->getTerritories();
        $result = $game->getTerritoryWarriorSum($territories[0]);
        $this->assertEquals(1, $result[$faction]);
    }
    public function testWarriorTerritoryGold(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $game->splitGold();
        $teams = $game->getTeams();
        foreach($teams as $team){
            if($team->hasFaction($currentPlayer->getFaction())){
                $gold = $team->getGoldPiles();
                $this->assertEquals(1, count($gold));
                $this->assertEquals(40, $gold[0]);
            }
        }
    }
    public function testWarriorTerritoryGoldSplit(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 1);
        $game->splitGold();
        $teams = $game->getTeams();
        foreach($teams as $team){
            if($team->hasFaction($currentPlayer->getFaction())){
                $gold = $team->getGoldPiles();
                $this->assertEquals(1, count($gold));
                $this->assertEquals(20, $gold[0]);
            }
        }
    }
    public function testWarriorTerritoryGoldSplitRound(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 1);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 2);
        $game->splitGold();
        $teams = $game->getTeams();
        foreach($teams as $team){
            if($team->hasFaction($currentPlayer->getFaction())){
                $gold = $team->getGoldPiles();
                $this->assertEquals(1, count($gold));
                $this->assertEquals(13, $gold[0]);
            }
        }
    }

    public function testTeam4(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $teams = $game->getTeams();
        $this->assertEquals(2, count($teams));
        $this->assertEquals(2, count($teams[0]->getFactions()));
        $this->assertEquals(2, count($teams[1]->getFactions()));
    }
    public function testTeam3(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $teams = $game->getTeams();
        $this->assertEquals(3, count($teams));
        $this->assertEquals(1, count($teams[0]->getFactions()));
        $this->assertEquals(1, count($teams[1]->getFactions()));
        $this->assertEquals(1, count($teams[2]->getFactions()));
    }
    public function testWinnerTie(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $game->splitGold();
        $winners = $game->getWinners();
        $this->assertEquals(2, count($winners));
    }
    public function testWinnerOne(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $game->splitGold();
        $winners = $game->getWinners();
        $this->assertEquals(1, count($winners));
        $this->assertEquals($currentPlayer->getFaction(), $winners[0]);
    }
    public function testWinnerTieish(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $teams = $game->getTeams();
        $teams[0]->addGoldPile(5);
        $teams[0]->addGoldPile(4);
        $teams[1]->addGoldPile(3);
        $teams[1]->addGoldPile(3);
        $teams[1]->addGoldPile(3);
        $winners = $game->getWinners();
        $this->assertEquals(1, count($winners));
        $this->assertEquals($teams[0]->getTeamString(), $winners[0]);
    }
    public function testWinnerTieishBackwards(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $teams = $game->getTeams();
        $teams[1]->addGoldPile(5);
        $teams[1]->addGoldPile(4);
        $teams[0]->addGoldPile(3);
        $teams[0]->addGoldPile(3);
        $teams[0]->addGoldPile(3);
        $winners = $game->getWinners();
        $this->assertEquals(1, count($winners));
        $this->assertEquals($teams[1]->getTeamString(), $winners[0]);
    }
    public function testWinnerTieishThreeWayBackwards(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $teams = $game->getTeams();
        $teams[1]->addGoldPile(5);
        $teams[1]->addGoldPile(4);
        $teams[0]->addGoldPile(3);
        $teams[0]->addGoldPile(3);
        $teams[0]->addGoldPile(3);
        $teams[2]->addGoldPile(3);
        $teams[2]->addGoldPile(3);
        $teams[2]->addGoldPile(3);
        $winners = $game->getWinners();
        $this->assertEquals(1, count($winners));
        $this->assertEquals($teams[1]->getTeamString(), $winners[0]);
    }
    public function testGetMageTargets(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 1);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 2);
        $game->splitGold();
        $teams = $game->getTeams();
        foreach($teams as $team){
           $targets = $game->getMageTargets();
           $this->assertEquals(2, count($targets));
        }
    }
    public function testGetGoblinTargets(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 0);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 1);
        $game->nextPlayer();
        $currentPlayer = $game->getCurrentPlayer();
        $game->placeWarrior($currentPlayer->getFaction(), 1, 0, 2);
        $targets = $game->getFreeSquares();
        $this->assertEquals(29, count($game->getFreeSquares()));
    }
    public function testIsTerritoryFullEmpty(){
        $board = new Board();
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $territories = $board->getTerritories();
        foreach($territories as $territory){
            if(count($territory) === 4){
                $this->assertFalse($board->isTerritoryFull($territory));
            }
        }
    }
    public function testIsTerritoryFullFull(){
        $board = new Board();
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $board->getCell(0, 0)->setFaction("Mage");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction("Mage");
        $board->getCell(0, 1)->setValue(1);
        $board->getCell(1, 0)->setFaction("Mage");
        $board->getCell(1, 0)->setValue(1);
        $territories = $board->getTerritories();
        foreach($territories as $territory){
            if(count($territory) === 4){
                $this->assertTrue($board->isTerritoryFull($territory));
            }
        }
    }
    public function testGetArrowTargets(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->getCell(0, 0)->setFaction("Mage");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction("Elf");
        $board->getCell(0, 1)->setValue(1);
        $this->assertEquals(1, count($game->getArrowTargets()));
    }
    public function testGetArrowTargetsNoElf(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->getCell(0, 0)->setFaction("Mage");
        $board->getCell(0, 0)->setValue(1);
        $this->assertEquals(0, count($game->getArrowTargets()));
    }
    public function testGetArrowTargetsNoEnemy(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->getCell(0, 0)->setFaction("Elf");
        $board->getCell(0, 0)->setValue(1);
        $this->assertEquals(0, count($game->getArrowTargets()));
    }
    public function testGetArrowTargetsAlly(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $teams = $game->getTeams();
        $allyFaction = null;
        foreach($teams as $team){
            if($team->hasFaction("Elf")){
                $factions = $team->getFactions();
                foreach($factions as $faction){
                    if($faction !== "Elf"){
                        $allyFaction = $faction;
                    }
                }
            }
        }
        $board->getCell(0, 0)->setFaction("Elf");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction($allyFaction);
        $board->getCell(0, 1)->setValue(1);
        $this->assertEquals(0, count($game->getArrowTargets()));
    }
    public function testGetArrowTargets4PlayerEnemy(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $teams = $game->getTeams();
        $enemyFaction = null;
        foreach($teams as $team){
            if(!$team->hasFaction("Elf")){
                $factions = $team->getFactions();
                $enemyFaction = $factions[0];
            }
        }
        $board->getCell(0, 0)->setFaction("Elf");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction($enemyFaction);
        $board->getCell(0, 1)->setValue(1);
        $this->assertEquals(1, count($game->getArrowTargets()));
    }

    public function testGetArrowTargets4PlayerEnemyOtherTerritory(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $teams = $game->getTeams();
        $enemyFaction = null;
        foreach($teams as $team){
            if(!$team->hasFaction("Elf")){
                $factions = $team->getFactions();
                $enemyFaction = $factions[0];
            }
        }
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $board->getCell(0, 0)->setFaction("Elf");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(2, 1)->setFaction($enemyFaction);
        $board->getCell(2, 1)->setValue(1);
        $this->assertEquals(0, count($game->getArrowTargets()));
    }
    public function testGetReinforcementTargets(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $board->getCell(0, 0)->setFaction("Mage");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction("Mage");
        $board->getCell(0, 1)->setValue(1);
        $board->getCell(1, 0)->setFaction("Mage");
        $board->getCell(1, 0)->setValue(1);
        $targets = $game->getReinforcmentTargets("Mage");
        $this->assertEquals(3, count($targets));
    }
    public function testGetReinforcementTargetsAlreadyReinforced(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $board->getCell(0, 0)->setFaction("Mage");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction("Mage");
        $board->getCell(0, 1)->setValue(1);
        $board->getCell(1, 0)->setFaction("Mage");
        $board->getCell(1, 0)->setValue(1);
        $board->getCell(1, 0)->setReinforcment(true);
        $targets = $game->getReinforcmentTargets("Mage");
        $this->assertEquals(0, count($targets));
    }
    public function testGetReinforcementTargetsNotFull(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $board->getCell(0, 0)->setFaction("Mage");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction("Mage");
        $board->getCell(0, 1)->setValue(1);
        $targets = $game->getReinforcmentTargets("Mage");
        $this->assertEquals(0, count($targets));
    }
    public function testGetReinforcementTargetsNoPlayersWarriors(){
        $game = new Game();
        $player = new Player();
        $key = $game->addPlayer($player);
        $game->chooseFaction($key, "Mage");
        $playerA = new Player();
        $keyA = $game->addPlayer($playerA);
        $game->chooseFaction($keyA, "Orc");
        $playerB = new Player();
        $keyB = $game->addPlayer($playerB);
        $game->chooseFaction($keyB, "Elf");
        $playerC = new Player();
        $keyC = $game->addPlayer($playerC);
        $game->chooseFaction($keyC, "Goblin");
        $game->setupWarriors();
        $game->start();
        $board = $game->getBoard();
        $board->placePalisade("Mage", "south", 0, 1);
        $board->placePalisade("Mage", "south", 1, 1);
        $board->placePalisade("Mage", "east", 1, 0);
        $board->placePalisade("Mage", "east", 1, 1);
        $board->getCell(0, 0)->setFaction("Orc");
        $board->getCell(0, 0)->setValue(1);
        $board->getCell(0, 1)->setFaction("Elf");
        $board->getCell(0, 1)->setValue(1);
        $board->getCell(1, 0)->setFaction("Goblin");
        $board->getCell(1, 0)->setValue(1);
        $targets = $game->getReinforcmentTargets("Mage");
        $this->assertEquals(0, count($targets));
    }
}
?>