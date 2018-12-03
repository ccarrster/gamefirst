<?php
namespace App;
class Cell{
	var $canGold;
	var $gold = 0;
	var $southPalisade = false;
	var $eastPalisade = false;

	public function __construct(){
		$this->canGold = false;
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
}