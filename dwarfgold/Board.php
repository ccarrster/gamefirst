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
				$canSouthPalisade = true;
				$canEastPalisade = true;
				if($x === 7){
					$canEastPalisade = false;
				}
				if($y === 4){
					$canSouthPalisade = false;
				}
				$column[] = new Cell($canSouthPalisade, $canEastPalisade);
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

	public function placePalisade($faction, $side, $x, $y){
		$cell = $this->cells[$x][$y];
		$result = $cell->placePalisade($side);
		if($result === false){
			return false;
		}
		if($this->teritoriesAreValid()){
			return true;
		} else {
			$cell->removePalisade($side);
			return false;
		}
	}

	public function teritoriesAreValid(){
		for($x = 0; $x < 8; $x++){
			for($y = 0; $y < 5; $y++){
				$count = 0;
				for($x1 = 0; $x1 < 8; $x1++){
					for($y1 = 0; $y1 < 5; $y1++){
						$this->cells[$x1][$y1]->visited = false;
					}
				}
				$count = 0;
				$this->isCellInValidTerritory($x, $y, $count);
				if($count < 4){
					return false;
				}
			}
		}
		return true;
	}

	public function isCellInValidTerritory($x, $y, &$count){
		$cell = $this->cells[$x][$y];
		$cell->visited = true;
		$count += 1;
		//X+
		if($x < 7){
			if($cell->hasPalisade('east') === false){
				if($this->cells[$x + 1][$y]->visited === false){
					$this->isCellInValidTerritory($x + 1, $y, $count);
				}
			}
		}
		//X-
		if($x > 0){
			if($this->cells[$x - 1][$y]->visited === false){
				if($this->cells[$x - 1][$y]->hasPalisade('east') === false){
					$this->isCellInValidTerritory($x - 1, $y, $count);
				}
			}
		}
		//Y+
		if($y < 4){
			if($this->cells[$x][$y + 1]->visited === false){
				if($cell->hasPalisade('south') === false){
					$this->isCellInValidTerritory($x, $y + 1, $count);
				}
			}
		}
		//Y-
		if($y > 0){
			if($this->cells[$x][$y - 1]->visited === false){
				if($this->cells[$x][$y - 1]->hasPalisade('south') === false){
					$this->isCellInValidTerritory($x, $y - 1, $count);
				}
			}
		}
	}

	public function getTerritories(){
		$territories = [];
		for($x1 = 0; $x1 < 8; $x1++){
			for($y1 = 0; $y1 < 5; $y1++){
				$this->cells[$x1][$y1]->visited = false;
			}
		}
		for($x = 0; $x < 8; $x++){
			for($y = 0; $y < 5; $y++){
				if($this->cells[$x][$y]->visited === false){
					$teritoryCells = [];
					$this->recGetTerritories($x, $y, $teritoryCells);
					$territories[] = $teritoryCells;
				}
			}
		}
		for($x1 = 0; $x1 < 8; $x1++){
			for($y1 = 0; $y1 < 5; $y1++){
				$this->cells[$x1][$y1]->visited = false;
			}
		}
		return $territories;
	}

	public function recGetTerritories($x, $y, &$teritoryCells){
		$cell = $this->cells[$x][$y];
		$cell->visited = true;
		$teritoryCells[] = [$x, $y];
		//X+
		if($x < 7){
			if($cell->hasPalisade('east') === false){
				if($this->cells[$x + 1][$y]->visited === false){
					$this->recGetTerritories($x + 1, $y, $teritoryCells);
				}
			}
		}
		//X-
		if($x > 0){
			if($this->cells[$x - 1][$y]->visited === false){
				if($this->cells[$x - 1][$y]->hasPalisade('east') === false){
					$this->recGetTerritories($x - 1, $y, $teritoryCells);
				}
			}
		}
		//Y+
		if($y < 4){
			if($this->cells[$x][$y + 1]->visited === false){
				if($cell->hasPalisade('south') === false){
					$this->recGetTerritories($x, $y + 1, $teritoryCells);
				}
			}
		}
		//Y-
		if($y > 0){
			if($this->cells[$x][$y - 1]->visited === false){
				if($this->cells[$x][$y - 1]->hasPalisade('south') === false){
					$this->recGetTerritories($x, $y - 1, $teritoryCells);
				}
			}
		}
	}

	public function getAllWarriors(){
		$warriors = [];
		for($x = 0; $x < 8; $x++){
			for($y = 0; $y < 5; $y++){
				$faction = $this->cells[$x][$y]->getFaction();
				if($faction !== null){
					$warrior = new \stdClass();
					$warrior->x = $x;
					$warrior->y = $y;
					$warrior->faction = $faction;
					$warriors[] = $warrior;
				}
			}
		}
		return $warriors;
	}

	public function getFreeSquares(){
		$freeSquares = [];
		for($x = 0; $x < 8; $x++){
			for($y = 0; $y < 5; $y++){
				$faction = $this->cells[$x][$y]->getFaction();
				$hasGold = $this->cells[$x][$y]->hasGold();
				if($faction === null && $hasGold === false){
					$cell = new \stdClass();
					$cell->x = $x;
					$cell->y = $y;
					$freeSquares[] = $cell;
				}
			}
		}
		return $freeSquares;
	}
}