<?php
interface iPersistance
{	
	/*
	Loads a game
	*/
	public function load($id);
	/*
	Saves a game
	*/
	public function save($id, $data);
}