<?php
namespace App;
class Player{
	var $faction;
	var $warriors = [];
	var $powerTokens = 0;
	var $reinforcements = 0;
	public function setFaction($faction){
		$this->faction = $faction;
	}
	
	public function getFaction(){
		return $this->faction;
	}

	public function setWarriors($warriors){
		$this->warriors = $warriors;
	}

	public function getWarriors(){
		return $this->warriors;
	}
	public function getPowerTokens(){
		return $this->powerTokens;			
	}
	public function setPowerTokens($powerTokens){
		$this->powerTokens = $powerTokens;
	}
	public function getReinforcments(){
		return $this->reinforcements;
	}
	public function setReinforcements($reinforcements){
		$this->reinforcements = $reinforcements;
	}
	//4 player game
	//Teams
	//Turn order
}