<?php
	namespace App;
	require_once('../GameInterface/GameInterface.php');
	require_once('Game.php');
	require_once('config.php');
	class DwarfGold implements \iGameFirst {

		var $persistance;
		public function __construct($persistance){
			$this->persistance = $persistance;
		}

	    public function getGameOptions(){
	    	$options = [];
	    	$options['numberOfPlayers'] = [2, 3, 4];
	    	$options['factions'] = [DwarfGoldConfig::MAGE, DwarfGoldConfig::ORC, DwarfGoldConfig::GOBLIN, DwarfGoldConfig::ELF];
	    	$options['advanced'] = ["false", "true"];
	    	$options['peek'] = ["false", "true"];
	    	return $options;
	    }

	    function isValidOptions($options){
	    	$errors = [];
	    	$gameOptions = $this->getGameOptions();
	    	foreach($gameOptions as $gameOptionKey=>$gameOptionValue){
	    		if(isset($options[$gameOptionKey])){
	    			$optionValue = $options[$gameOptionKey];
	    			if(is_array($optionValue)){
	    				foreach($optionValue as $arrayValue){
	    					if(!in_array($arrayValue, $gameOptionValue)){
			    				$errors[] = 'Option value '.$arrayValue.' not in array.';
			    			}
	    				}
	    			} else {
		    			if(!in_array($optionValue, $gameOptionValue)){
		    				$errors[] = 'Option value '.$optionValue.' not in array.';
		    			}
		    		}
	    		} else {
	    			$errors[] = 'Option key '.$gameOptionKey.' not in sent.';
	    		}
	    	}
	    	return $errors;
	    }

	    public function startGame($options){
	    	$result = new \StdClass();
	    	$result->gameId = null;
	    	$result->players = [];
	    	$optionErrors = $this->isValidOptions($options);
	    	if(count($optionErrors) === 0){
	    		$error = false;
		    	if(isset($options['numberOfPlayers'])){
		    		for($i = 0; $i < $options['numberOfPlayers']; $i++){
		    			$result->players[] = '';
		    		}
		    	} else {
		    		$error = true;
		    	}
		    	if(isset($options['factions'])){
		    		$i = 0;
		    		foreach($options['factions'] as $faction){
		    			$result->players[$i] = $faction;
		    			$i += 1;
		    		}
		    	} else {
		    		$error = true;
		    	}
		    	if(isset($options['advanced'])){

		    	} else {
		    		$error = true;
		    	}
		    	if(isset($options['peek'])){

		    	} else {
		    		$error = true;
		    	}
		    	if($error === false){
		    		$game = new Game($options, $this->persistance);
		    		for($i = 0; $i < $options['numberOfPlayers']; $i++){
		    			$game->addPlayer(new Player());
		    		}
		    		$players = $game->getPlayers();
		    		shuffle($options['factions']);
		    		$index = 0;
		    		foreach($players as $player){
		    			$player->setFaction($options['factions'][$index]);
		    			$index += 1;
		    		}
		    		$game->setAdvancedMode($options['advanced'] === 'true');
		    		$game->setCanPeek($options['peek'] === 'true');
		    		$game->start();
		    		$game->setupWarriors();
		    		$game->setupAdvancedTokens();
		    		$id = $this->save(null, $game);
		    		$result->gameId = $id;
		    	}
			}
	    	return $result;
	    }
	    public function getPublicGameState($gameId){
	    	$game = $this->loadGame($gameId);
	    	$publicGame = new \stdClass();
	    	$publicGame->players = [];
	    	$gamePlayers = $game->getPlayers();
	    	foreach($gamePlayers as $player){
	    		$publicPlayer = new \stdClass();
	    		$publicPlayer->powerTokens = $player->getPowerTokens();
	    		$publicGame->players[] = $publicPlayer;
	    	}
	    	$publicGame->palisades = $game->getPalisadeCount();
	    	$board = new \stdClass();
	    	$board->cells = [];
	    	for($x = 0; $x < 8; $x++){
	    		$board->cells[$x] = [];
	    		for($y = 0; $y < 5; $y++){
	    			$boardCell = $game->getBoard()->getCell($x, $y);
	    			$cell = new \stdClass();
	    			$cell->faction = $boardCell->getFaction();
	    			$cell->hasReinforcement = $boardCell->hasReinforcement();
	    			$cell->southPalisade = $boardCell->hasPalisade('south');
	    			$cell->eastPalisade = $boardCell->hasPalisade('east');
	    			$cell->gold = $boardCell->getGold();
	    			$cell->arrows = $boardCell->getArrows();
	    			$board->cells[$x][$y] = $cell;
	    		}
	    	}
	    	$publicGame->board = $board;
	    	return $publicGame;
	    }
	    public function getPrivateGameState($gameId, $playerId){
	    	$game = $this->loadGame($gameId);
	    	$privateGame = new \stdClass();
	    	$player = new \stdClass();
	    	$players = $game->getPlayers();
	    	foreach($players as $gamePlayer){
	    		if($gamePlayer->faction === $playerId){
	    			$player->warriors = $gamePlayer->warriors;
	    			$player->reinforcements = $gamePlayer->getReinforcments();
	    		}
	    	}
	    	$privateGame->player = $player;
	    	return $privateGame;
	    }
	    public function getAvailableOptions($gameId, $playerId){
	    	$options = [];
	    	$game = $this->loadGame($gameId);
	    	$currentPlayer = $game->getCurrentPlayer();
	    	if($currentPlayer->getFaction() === $playerId){
	    		if($game->getAdvancedMode() == true){
	    			$options['Power'] = $game->getValidPowerLocations($playerId);
	    			$options['Reinforce'] = $game->getValidReinforementLocations($playerId);
	    		}
	    		if($game->getCanPeek() == true){
	    			$options['Peek'] = $game->getValidPeekLocations($playerId);
	    		}
	    		$options['Palisade'] = $game->getValidPalisadeLocations($playerId);
	    		$options['Warrior'] = $game->getValidWarriorLocations($playerId);
	    		$options['Pass'] = ['pass'];
	    	}
	    	return $options;
	    }
	    public function chooseOption($gameId, $playerId, $options){
	    	$game = $this->loadGame($gameId);
	    	$currentPlayer = $game->getCurrentPlayer();
	    	if($currentPlayer->getFaction() === $playerId){
	    		if($options->type === 'Warrior'){
	    			$result = $game->placeWarrior($playerId, (int)$options->strength, $options->x, $options->y);
	    			if($result === true){
	    				$this->save($gameId, $game);
	    			}
	    			return $result;
	    		} elseif($options->type === 'Palisade'){
	    			//1 or 2 locations valid
	    			if(count($options->locations) < 1 || count($options->locations) > 2){
	    				return false;
	    			}
	    			foreach($options->locations as $location){
	    				$result = $game->placePalisade($playerId, $location->side, $location->x, $location->y);
	    				if($result === false){
	    					//TODO if one placed and another will not then remove last one
	    					//TODO zero is wrong, 1 is ok, 2 is ok, 3 or more is wrong
	    					return false;
	    				}
	    			}
	    			$this->save($gameId, $game);
	    			return true;
	    		} elseif($options->type === 'Pass'){
	    			$currentPlayer->setPass(true);
	    			$this->save($gameId, $game);
	    			return true;
	    		} elseif($options->type === 'Peek'){
	    			if($game->getCanPeek() == true){
	    				$cell = $game->getBoard()->getCell($options->x, $options->y);
	    				return $cell->getValue();
	    			} else {
	    				return false;
	    			}
	    		}
	    	} else {
	    		return false;
	    	}
	    }

	    /*
		saves game
		*/
		public function save($gameId, $game){
			return $this->persistance->save($gameId, $game);
		}

		/*
		Given a game id, will load a game
		*/
		public function loadGame($gameId){
			return $this->persistance->load($gameId);
		}
	}