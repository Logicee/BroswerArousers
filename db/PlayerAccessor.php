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
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once 'dbconnection.php';
require_once ($projectRoot . '/entity/Player.php');

class PlayerAccessor {
    
    private $playerString = "SELECT * FROM player WHERE teamID = :id";
    private $playerStatement = null;
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
    
    public function getPlayersByTeamID($teamID){
        $players = [];
        try{   
        $this->playerStatement->bindParam(":id", $teamID);
        $this->playerStatement->execute();
        $results = $this->playerStatement->fetchAll(PDO::FETCH_ASSOC);
                
      
        foreach($results as $row){
            $FName = $row['firstName'];
            $LName = $row['lastName'];
            $province = $row['provinceCode'];
            $homeTown  = $row['hometown'];
            $playerid = $row['playerID'];
            $teamID = $row['teamID'];
            $player = new Player($playerid,$FName, $LName, $province, $homeTown, $teamID);
            array_push($players, $player);
        }
      }
           catch (Exception $e) {
            $result = NULL;
        }
        finally {
            if (!is_null($this->playerStatement)) {
                $this->playerStatement->closeCursor();
            }
        }
        return $players;
    }
    
}
