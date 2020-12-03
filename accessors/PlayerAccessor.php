<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlayerAccessor
 *
 * @author danie
 */
require_once 'entity/Player.php';

class PlayerAccessor {
    
    private $playerString = "SELECT * FROM player WHERE teamID = :id";
    private $playerStatement;
    private $conn = null;
    
    public function __construct() {
        $connect = new dbConnect();

        $this->conn = $connect->connectToDB();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->playerStatement = $this->conn->prepare($this->playerString);
        if (is_null($this->playerStatement)) {
            throw new Exception("bad statement: '" . $this->playerStatement . "'");
        }
        //add additional prepares here

    }
    
    public function getTeamPlayers($teamID){
        $this->playerStatement->bindParam(":id", $teamID);
        $this->playerStatement->execute();
        $results = $this->playerStatement->fetchAll(PDO::FETCH_ASSOC);
                
        $players = [];
        foreach($results as $row){
            $FName = $row['firstName'];
            $LName = $row['lastName'];
            $province = $row['provinceCode'];
            $homeTown  = $row['hometown'];
            $id = $row['playerID'];
            $player = new Player($FName, $LName, $province, $homeTown, $id);
            array_push($players, $player);
        }
        return $players;
    }
}
