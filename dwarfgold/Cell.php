<?php
namespace App;
class Cell{
	var $canGold;
	var $gold = 0;
	var $southPalisade = false;
	var $eastPalisade = false;
	var $value = 0;
	var $faction = null;
	var $canSouthPalisade;
	var $canEastPalisade;
	var $visited = false;

	public function __construct($canSouthPalisade, $canEastPalisade){
		$this->canGold = false;
		$this->canSouthPalisade = $canSouthPalisade;
		$this->canEastPalisade = $canEastPalisade;
	}
	public function hasGold(){
		return $this->canGold;
	}
	public function canHaveGold(){
		$this->canGold = true;
	}
	public function getGold(){
		return $this->gold;
	}
	public function setGold($gold){
		$this->gold = $gold;
	}
	public function hasPalisade($side){
		if($side === "south"){
			return $this->southPalisade;
		} elseif($side === "east"){
			return $this->eastPalisade;
		}
	}
	public function isEmpty(){
		return $this->faction == null;
	}
	public function setFaction($faction){
		$this->faction = $faction;
	}
	public function setValue($value){
		$this->value = $value;
	}
	public function getValue(){
		return $this->value;
	}
	public function getFaction(){
		return  $this->faction;
	}
	public function placePalisade($side){
		if($side === "south"){
			if($this->canSouthPalisade === false || $this->southPalisade == true){
				return false;
			}
			$this->southPalisade = true;
			return true;
		} elseif($side === "east"){
			if($this->canEastPalisade === false || $this->eastPalisade == true){
				return false;
			}
			$this->eastPalisade = true;
			return true;
		}
		return false;
	}
	public function removePalisade($side){
		if($side === "south"){
			if($this->canSouthPalisade === false || $this->southPalisade == false){
				return false;
			}
			$this->southPalisade = false;
			return true;
		} elseif($side === "east"){
			if($this->canEastPalisade === false || $this->eastPalisade == false){
				return false;
			}
			$this->eastPalisade = false;
			return true;
		}
		return false;
	}
}