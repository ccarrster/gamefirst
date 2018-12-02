<?php
namespace App;
require_once('Cell.php');
class Board{
	var $cells;

	public function __construct(){
		$this->cells = [];
		for($x = 0; $x < 8; $x++){
			$column = [];
			for($y = 0; $y < 5; $y++){
				$column[] = new Cell();
			}
			$this->cells[] = $column;
		}
		$this->cells[3][0]->canHaveGold();
		$this->cells[1][1]->canHaveGold();
		$this->cells[5][1]->canHaveGold();
		$this->cells[7][1]->canHaveGold();
		$this->cells[0][3]->canHaveGold();
		$this->cells[4][3]->canHaveGold();
		$this->cells[2][4]->canHaveGold();
		$this->cells[6][4]->canHaveGold();
	}

	public function getCell($x, $y){
		if(isset($this->cells[$x]) && isset($this->cells[$x][$y])){
			return $this->cells[$x][$y];
		}
	}
}