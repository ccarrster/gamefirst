<?php
namespace App;
require_once('config.php');
require_once('Board.php');
require_once('Team.php');


class Game{
	var $board;
	var $factions = [];
	var $availableFactions = [];
	var $players = [];
	var $palisades;
	var $canPeek = false;
	var $advancedMode = false;
	var $started = false;
	var $playerOrder = [];
	var $currentPlayerKey = 0;
	var $teams = [];

	public function __construct(){
		$this->board = new Board();
		$this->factions[] = DwarfGoldConfig::ORC;
		$this->factions[] = DwarfGoldConfig::GOBLIN;
		$this->factions[] = DwarfGoldConfig::ELF;
		$this->factions[] = DwarfGoldConfig::MAGE;
		foreach($this->factions as $faction){
			$this->availableFactions[] = $faction;
		}
		$this->palisades = 35;
	}

	public function getBoard(){
		return  $this->board;
	}

	public function getFactions(){
		return $this->factions;
	}

	public function getAvailableFactions(){
		return $this->availableFactions;
	}

	public function takeFaction($faction){
		$key = array_search($faction, $this->availableFactions);
		if($key === false){
			return false;
		}
		unset($this->availableFactions[$key]);
		return true;
	}

	public function addPlayer($player){
		$this->players[] = $player;
		end($this->players);
		return key($this->players);
	}

	public function chooseFaction($playerKey, $faction){
		if($this->players[$playerKey]->getFaction() !== null){
			return false;
		}
		$result = $this->takeFaction($faction);
		if($result === true){
			$this->players[$playerKey]->setFaction($faction);
			return true;
		}
		return false;
	}

	public function setupWarriors(){
		if(count($this->players) == 2){
			foreach($this->players as $player){
				$warriors = [11, 2, 1, 1, 1];
				$player->setWarriors($warriors);
			}
			return true;
		} elseif(count($this->players) == 3){
			foreach($this->players as $player){
				$warriors = [7, 2, 1, 1, 0];
				$player->setWarriors($warriors);
			}
			return true;
		} elseif(count($this->players) == 4){
			foreach($this->players as $player){
				$warriors = [5, 1, 1, 1, 0];
				$player->setWarriors($warriors);
			}
			return true;
		} else {
			return false;
		}
	}
	public function getWarriors($playerKey){
		return $this->players[$playerKey]->getWarriors();
	}
	public function getPalisadeCount(){
		return $this->palisades;
	}
	public function getCanPeek(){
		return $this->canPeek;
	}
	public function setCanPeek($peek){
		$this->canPeek = $peek;
	}
	public function getAdvancedMode(){
		return $this->advancedMode;
	}
	public function setAdvancedMode($mode){
		$this->advancedMode = $mode;
	}
	public function setupAdvancedTokens(){
		if($this->advancedMode === true){
			foreach($this->players as $player){
				$faction = $player->getFaction();
				if($faction == DwarfGoldConfig::MAGE){
					$player->setPowerTokens(2);
				} elseif($faction == DwarfGoldConfig::ELF){
					$player->setPowerTokens(2);
				} elseif($faction == DwarfGoldConfig::ORC){
					$player->setPowerTokens(1);
				} elseif($faction == DwarfGoldConfig::GOBLIN){
					$player->setPowerTokens(1);
				}
				$player->setReinforcements(1);
			}
		}
	}
	public function start(){
		$this->started = true;
		foreach($this->players as $player){
			$this->playerOrder[] = $player;
		}
		shuffle($this->playerOrder);
		if(count($this->playerOrder) == 4){
			$team = new Team();
			$team->addFaction($this->playerOrder[0]->getFaction());
			$team->addFaction($this->playerOrder[2]->getFaction());
			$this->teams[] = $team;

			$team2 = new Team();
			$team2->addFaction($this->playerOrder[1]->getFaction());
			$team2->addFaction($this->playerOrder[3]->getFaction());
			$this->teams[] = $team2;
		} else {
			foreach($this->playerOrder as $player){
				$team = new Team();
				$team->addFaction($player->getFaction());
				$this->teams[] = $team;
			}
		}
	}
	public function getCurrentPlayer(){
		return $this->playerOrder[$this->currentPlayerKey];
	}
	public function nextPlayer(){
		if($this->currentPlayerKey == (count($this->playerOrder) - 1)){
			$this->currentPlayerKey = 0;
		} else {
			$this->currentPlayerKey += 1;
		}
	}
	public function getPlayerForFaction($faction){
		foreach($this->players as $player){
			if($player->getFaction() == $faction){
				return $player;
			}
		}
	}
	public function placeWarrior($faction, $value, $x, $y){
		$player = $this->getPlayerForFaction($faction);
		if($player->getWarriors()[$value - 1] > 0){
			$cell = $this->board->getCell($x, $y);
			if($cell->isEmpty()){
				$cell->setFaction($faction);
				$cell->setValue($value);
				$player->removeWarrior($value - 1);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function placePalisade($faction, $side, $x, $y){
		return $this->board->placePalisade($faction, $side, $x, $y);
	}
	public function getTerritories(){
		return $this->board->getTerritories();
	}
	public function getTerritoryGold($territory){
		$gold = 0;
		foreach($territory as $cell){
			$gold += $this->board->getCell($cell[0], $cell[1])->getGold();
		}
		return $gold;
	}
	
	public function getTerritoryWarriorSum($territory){
		$results = [];
		foreach($this->players as $player){
			$results[$player->getFaction()] = 0;
		}
		foreach($territory as $cell){
			$boardCell = $this->board->getCell($cell[0], $cell[1]);
			$faction = $boardCell->getFaction();
			$value = $boardCell->getValue();
			if($faction !== null){
				$results[$faction] += $value;
			}
		}
		return $results;
	}


	public function getFactionWithReinforcmentsInTerritory($territory){
		foreach($territory as $cell){
			$boardCell = $this->board->getCell($cell[0], $cell[1]);
			if($boardCell->hasReinforcement()){
				return $boardCell->getFaction();
			}
		}
		return null;
	}

	public function splitGold(){
		$territories = $this->getTerritories();
		foreach($territories as $territory){
			$reinforcmentFaction = $this->getFactionWithReinforcmentsInTerritory($territory);
			$factionValue = $this->getTerritoryWarriorSum($territory);
			$teamValues = [];
			$reinforcmentTeam = null;
			//Group warrior values by team instead of faction
			foreach($factionValue as $faction=>$value){
				foreach($this->teams as $team){
					if($team->hasFaction($faction)){
						if(!isset($teamValues[$team->getTeamString()])){
							$teamValues[$team->getTeamString()] = 0;
						}
						$teamValues[$team->getTeamString()] += $value;
						//Reinforcments add one
						if($reinforcmentFaction == $faction){
							$teamValues[$team->getTeamString()] += 1;
							$reinforcmentTeam = $team->getTeamString();
						}
					}
				}
			}
			$maxValue = 0;
			$maxTeams = [];
			//The highest value gets the gold, if tied they split
			foreach($teamValues as $teamString=>$value){
				if($value > $maxValue){
					$maxValue = $value;
					$maxTeams = [];
					$maxTeams[] = $teamString;
				} elseif($value == $maxValue){
					$maxTeams[] = $teamString;
				}
			}
			//Reinforcments Win Ties
			foreach($maxTeams as $maxTeam){
				if($maxTeam === $reinforcmentTeam){
					$maxTeams = [];
					$maxTeams[] = $reinforcmentTeam;
					break;
				}
			}
			//Get and split the gold to the teams
			$gold = $this->getTerritoryGold($territory);
			$splitGold = floor($gold/count($maxTeams));
			foreach($maxTeams as $teamString){
				foreach($this->teams as $team){
					if($teamString === $team->getTeamString()){
						$team->addGoldPile($splitGold);
					}
				}
			}
		}
	}

	public function getTeams(){
		return $this->teams;
	}

	public function getWinners(){
		usort($this->teams, array('App\Team','Compare'));
		$localTeams = array_reverse($this->teams);
		$winners = [];
		for($i = 0; $i < count($localTeams); $i++){
			if(count($winners) == 0){
				$winners[] = $localTeams[0]->getTeamString();;
			} else {
				if(Team::Compare($localTeams[0], $localTeams[$i]) === 0){
					$winners[] = $localTeams[$i]->getTeamString();
				}
			}
		}
		return $winners;
	}

	public function getEnemyTargets($inFaction){
		$factionsToAdd = [];
		foreach($this->teams as $team){
			if($team->hasFaction($inFaction) === false){
				$factions = $team->getFactions();
				foreach($factions as $faction){
					$factionsToAdd[] = $faction;
				}
			}
		}
		$warriors = $this->board->getAllWarriors();
		$enemyWarriors = [];
		foreach($warriors as $warrior){
			$warriorFaction = $warrior->faction;
			if(in_array($warriorFaction, $factionsToAdd)){
				$enemyWarriors[] = $warrior;
			}
		}
		return $enemyWarriors;
	}

	public function getFreeSquares(){
		$freeSquares = $this->board->getFreeSquares();
		return $freeSquares;
	}

	public function getArrowTargets($inFaction){
		$targetCells = [];
		$targetFactions = [];
		foreach($this->teams as $team){
			if($team->hasFaction($inFaction) === false){
				foreach($team->getFactions() as $faction){
					$targetFactions[] = $faction;
				}
			}
		}
		$territories = $this->board->getTerritories();
		foreach($territories as $territory){
			$hasInFaction = false;
			$enemies = [];
			$isFull = $this->board->isTerritoryFull($territory);
			foreach($territory as $coordinates){
				$cell = $this->board->getCell($coordinates[0], $coordinates[1]);
				$faction = $cell->getFaction();
				if($faction === $inFaction){
					$hasInFaction = true;
				} else{
					if($faction !== null){
						if(in_array($faction, $targetFactions) === true){
							$enemies[] = $cell;
						}
					}
				}
			}
			if($hasInFaction && !$isFull && count($enemies) > 0){
				foreach($enemies as $enemyCell){
					$targetCells[] = $enemyCell;
				}
			}
		}
		return $targetCells;
	}
	public function getReinforcmentTargets($faction){
		return $this->board->getReinforcmentTargets($faction);
	}
}