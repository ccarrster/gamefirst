<?php
namespace App;
class Cell{
	var $canGold;
	public function __construct(){
		$this->canGold = false;
	}
	public function hasGold(){
		return $this->canGold;
	}
	public function canHaveGold(){
		$this->canGold = true;
	}
}