<?php

/**
Stateless game api
Client does not need to hold the state, just the game id and playerids
*/

interface iGameFirst
{
	/**
	@returns an array of option types, current values, and available values
	*/
    public function getGameOptions();
    /**
    Pass in options, values (eg number of players), can peek or advanced game
	@returns a list of playerIds, gameid
	*/
    public function startGame($options);
    /**
    @returns everything each player can see publicly, gameboard, pieces, cards, score, round, who's turn.
    */
    public function getPublicGameState($gameId);
    /**
    Pass in the player id, passed back when the game started, gameid
	@returns everything that is private for that player, current hand, pieces left
	*/
    public function getPrivateGameState($gameId, $playerId);
    /**
    Pass in the player id, passed back when the game started, gameid
	@returns actions available with a list of targets for each action, place a palisade and here are the available locations, or place reenforcments on the following warriors, or skip placement, pass to end the game
	*/
    public function getAvailableOptions($gameId, $playerId);
    /**
    Pass in gameid, playerid and chosen option
	@returns if option was successful. It should be unless it is not the players turn.
	*/
    public function chooseOption($gameId, $playerId, $options);
}