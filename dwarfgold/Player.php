<?php
namespace App;
class Player{
	var $faction;
	public function setFaction($faction){
		$this->faction = $faction;
	}
	
	public function getFaction(){
		return $this->faction;
	}
}