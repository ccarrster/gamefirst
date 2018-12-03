<?php
namespace App;
class Cell{
	var $canGold;
	var $gold = 0;
	var $southPalisade = false;
	var $eastPalisade = false;
	var $value = 0;
	var $faction = null;

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
}