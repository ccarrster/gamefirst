<?php
namespace App;
class Player{
	var $faction;
	var $warriors = [];
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
}