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
	public function compare($other){
		$thisSum = 0;
		foreach($this->goldPiles as $pile){
			$thisSum += $pile;
		}
		$otherSum = 0;
		foreach($other->goldPiles as $pile){
			$otherSum += $pile;
		}
		if($thisSum > $otherSum){
			return 1;
		} elseif($thisSum < $otherSum){
			return -1;
		} else {
			$maxIndex = count($this->goldPiles) - 1;
			if(count($other->goldPiles) - 1 > $maxIndex){
				$maxIndex = count($other->goldPiles) - 1;
			}
			sort($this->goldPiles);
			$otherPiles = $other->getGoldPiles();
			sort($otherPiles);
			for($i = 0; $i < $maxIndex; $i++){
				if(isset($this->goldPiles[$i])){
					$thisValue = $this->goldPiles[$i];
				} else {
					$thisValue = 0;
				}
				if(isset($otherPiles[$i])){
					$otherValue = $otherPiles[$i];
				} else {
					$otherValue = 0;
				}
				if($thisValue > $otherValue){
					return 1;
				} elseif($thisValue < $otherValue){
					return -1;
				} elseif($thisValue == 0 && $otherValue == 0){
					return 0;
				}
			}
		}
	}
}