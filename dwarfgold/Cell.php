<?php
namespace App;
class Cell{
	var $canGold;
	var $gold = 0;
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
}