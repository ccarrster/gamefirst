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
}
?>