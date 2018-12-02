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
		$gold = [3, 4, 4, 5, 5, 6, 6, 7];
		shuffle($gold);
		$this->cells[3][0]->canHaveGold();
		$this->cells[1][1]->canHaveGold();
		$this->cells[5][1]->canHaveGold();
		$this->cells[7][1]->canHaveGold();
		$this->cells[0][3]->canHaveGold();
		$this->cells[4][3]->canHaveGold();
		$this->cells[2][4]->canHaveGold();
		$this->cells[6][4]->canHaveGold();

		$this->cells[3][0]->setGold(array_pop($gold));
		$this->cells[1][1]->setGold(array_pop($gold));
		$this->cells[5][1]->setGold(array_pop($gold));
		$this->cells[7][1]->setGold(array_pop($gold));
		$this->cells[0][3]->setGold(array_pop($gold));
		$this->cells[4][3]->setGold(array_pop($gold));
		$this->cells[2][4]->setGold(array_pop($gold));
		$this->cells[6][4]->setGold(array_pop($gold));
	}

	public function getCell($x, $y){
		if(isset($this->cells[$x]) && isset($this->cells[$x][$y])){
			return $this->cells[$x][$y];
		}
	}
}