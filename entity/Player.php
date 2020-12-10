<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
 * @author danie
 */
class Player implements JsonSerializable {
    private $playerID;
    private $FName;
    private $LName;
    private $province;
    private $homeTown;
    private $teamID;
    
    function __construct($playerID,$FName, $LName, $province, $homeTown, $teamID) {
        $this->playerID = $playerID;
        $this->FName = $FName;
        $this->LName = $LName;
        $this->province = $province;
        $this->homeTown = $homeTown;
        $this->teamID = $teamID;
    }
    
      function getPlayerID() {
        return $this->playerID;
    }
    
    
    function getFName() {
        return $this->FName;
    }

    function getLName() {
        return $this->LName;
    }

    function getProvince() {
        return $this->province;
    }

    function getHomeTown() {
        return $this->homeTown;
    }

    function getTeamID() {
        return $this->teamID;
    }
    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
