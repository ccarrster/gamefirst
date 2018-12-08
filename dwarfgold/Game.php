<?php
namespace App;
require_once('Board.php');

class Game{
	var $board;
	var $factions = [];
	var $availableFactions = [];
	var $players = [];
	var $palisades;
	var $canPeek = false;
	var $advancedMode = false;
	var $started = false;
	var $playerOrder = [];
	var $currentPlayerKey = 0;

	public function __construct(){
		$this->board = new Board();
		$this->factions[] = "Orc";
		$this->factions[] = "Goblin";
		$this->factions[] = "Elf";
		$this->factions[] = "Mage";
		foreach($this->factions as $faction){
			$this->availableFactions[] = $faction;
		}
		$this->palisades = 35;
	}

	public function getBoard(){
		return  $this->board;
	}

	public function getFactions(){
		return $this->factions;
	}

	public function getAvailableFactions(){
		return $this->availableFactions;
	}

	public function takeFaction($faction){
		$key = array_search($faction, $this->availableFactions);
		if($key === false){
			return false;
		}
		unset($this->availableFactions[$key]);
		return true;
	}

	public function addPlayer($player){
		$this->players[] = $player;
		end($this->players);
		return key($this->players);
	}

	public function chooseFaction($playerKey, $faction){
		if($this->players[$playerKey]->getFaction() !== null){
			return false;
		}
		$result = $this->takeFaction($faction);
		if($result === true){
			$this->players[$playerKey]->setFaction($faction);
			return true;
		}
		return false;
	}

	public function setupWarriors(){
		if(count($this->players) == 2){
			foreach($this->players as $player){
				$warriors = [11, 2, 1, 1, 1];
				$player->setWarriors($warriors);
			}
			return true;
		} elseif(count($this->players) == 3){
			foreach($this->players as $player){
				$warriors = [7, 2, 1, 1, 0];
				$player->setWarriors($warriors);
			}
			return true;
		} elseif(count($this->players) == 4){
			foreach($this->players as $player){
				$warriors = [5, 1, 1, 1, 0];
				$player->setWarriors($warriors);
			}
			return true;
		} else {
			return false;
		}
	}
	public function getWarriors($playerKey){
		return $this->players[$playerKey]->getWarriors();
	}
	public function getPalisadeCount(){
		return $this->palisades;
	}
	public function getCanPeek(){
		return $this->canPeek;
	}
	public function setCanPeek($peek){
		$this->canPeek = $peek;
	}
	public function getAdvancedMode(){
		return $this->advancedMode;
	}
	public function setAdvancedMode($mode){
		$this->advancedMode = $mode;
	}
	public function setupAdvancedTokens(){
		if($this->advancedMode === true){
			foreach($this->players as $player){
				$faction = $player->getFaction();
				if($faction == "Mage"){
					$player->setPowerTokens(2);
				} elseif($faction == "Elf"){
					$player->setPowerTokens(2);
				} elseif($faction == "Orc"){
					$player->setPowerTokens(1);
				} elseif($faction == "Goblin"){
					$player->setPowerTokens(1);
				}
				$player->setReinforcements(1);
			}
		}
	}
	public function start(){
		$this->started = true;
		foreach($this->players as $player){
			$this->playerOrder[] = $player;
		}
		shuffle($this->playerOrder);
	}
	public function getCurrentPlayer(){
		return $this->playerOrder[$this->currentPlayerKey];
	}
	public function nextPlayer(){
		if($this->currentPlayerKey == (count($this->playerOrder) - 1)){
			$this->currentPlayerKey = 0;
		} else {
			$this->currentPlayerKey += 1;
		}
	}
	public function getPlayerForFaction($faction){
		foreach($this->players as $player){
			if($player->getFaction() == $faction){
				return $player;
			}
		}
	}
	public function placeWarrior($faction, $value, $x, $y){
		$player = $this->getPlayerForFaction($faction);
		if($player->getWarriors()[$value - 1] > 0){
			$cell = $this->board->getCell($x, $y);
			if($cell->isEmpty()){
				$cell->setFaction($faction);
				$cell->setValue($value);
				$player->removeWarrior($value - 1);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function placePalisade($faction, $side, $x, $y){
		return $this->board->placePalisade($faction, $side, $x, $y);
	}
}