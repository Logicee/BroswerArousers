<?php

class Team implements JsonSerializable {
    private $teamID;
    private $teamName;
    private $earnings;
    
    public function __construct($teamID, $teamName, $earnings) {
        $this->teamID = $teamID;
        $this->teamName = $teamName;
        $this->earnings = $earnings;
    }

    public function getteamID() {
        return $this->gameID;
    }

    public function getTeamName() {
        return $this->matchID;
    }

    public function getEarnings() {
        return $this->gameNumber;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}

