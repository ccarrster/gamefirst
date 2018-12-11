<?php
	namespace App;
	require_once('../GameInterface/GameInterface.php');
	require_once('config.php');
	class DwarfGold implements \iGameFirst {
	    public function getGameOptions(){
	    	$options = [];
	    	$options['numberOfPlayers'] = [2, 3, 4];
	    	$options['factions'] = [DwarfGoldConfig::MAGE, DwarfGoldConfig::ORC, DwarfGoldConfig::GOBLIN, DwarfGoldConfig::ELF];
	    	$options['advanced'] = ["false", "true"];
	    	$options['peek'] = ["false", "true"];
	    	return $options;
	    }
	    public function startGame($options){

	    }
	    public function getPublicGameState($gameId){

	    }
	    public function getPrivateGameState($gameId, $playerId){

	    }
	    public function getAvailableOptions($gameId, $playerId){

	    }
	    public function chooseOption($gameId, $playerId, $options){

	    }
	}