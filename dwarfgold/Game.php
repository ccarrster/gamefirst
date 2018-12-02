<?php
namespace App;
require_once('Board.php');

class Game{
	var $board;
	var $factions = [];
	var $availableFactions = [];
	var $players = [];

	public function __construct(){
		$this->board = new Board();
		$this->factions[] = "Orc";
		$this->factions[] = "Goblin";
		$this->factions[] = "Elf";
		$this->factions[] = "Mage";
		foreach($this->factions as $faction){
			$this->availableFactions[] = $faction;
		}
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
}