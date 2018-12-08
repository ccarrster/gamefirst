<?php
namespace App;
class Team{
	var $factions = [];
	var $goldPiles = [];
	public function addFaction($faction){
		$this->factions[] = $faction;
	}
	public function getFactions(){
		return $this->factions;
	}
	public function addGoldPile($gold){
		$this->goldPiles[] = $gold;
	}
	public function getGoldPiles(){
		return $this->goldPiles;
	}
	public function getTeamString(){
		$teamString = "";
		foreach($this->factions as $faction){
			$teamString .= $faction;
		}
		return $teamString;
	}
	public function hasFaction($inFaction){
		foreach($this->factions as $faction){
			if($inFaction === $faction){
				return true;
			}
		}
		return  false;
	}
}