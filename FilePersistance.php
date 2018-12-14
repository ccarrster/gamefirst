<?php
require_once('PersistanceInterface/PersistanceInterface.php');
class FilePersistance implements iPersistance {
	public function __construct(){
		if(!file_exists('games')){
			mkdir('games');
		}
	}
	/*
	Loads a game
	*/
	public function load($id){
		$gameFile = file_get_contents('games'.DIRECTORY_SEPARATOR.$id.'.game');
		return unserialize($gameFile);
	}
	/*
	Saves a game
	If id is null will return new id
	@returns id
	*/
	public function save($id, $data){
		if($id == null){
			$id = uniqid();
		}
		file_put_contents('games'.DIRECTORY_SEPARATOR.$id.'.game', serialize($data));
		return $id;
	}
}