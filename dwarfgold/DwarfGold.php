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
		    		$id = $this->save(null, $game);
		    		$result->gameId = $id;
		    	}
			}
	    	return $result;
	    }
	    public function getPublicGameState($gameId){
	    	$game = $this->loadGame($gameId);
	    	return $game;
	    }
	    public function getPrivateGameState($gameId, $playerId){

	    }
	    public function getAvailableOptions($gameId, $playerId){

	    }
	    public function chooseOption($gameId, $playerId, $options){

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