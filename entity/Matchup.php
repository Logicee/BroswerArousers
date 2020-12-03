<?php

class Matchup implements JsonSerializable {
    private $matchID;
    private $roundID;
    private $matchGroup;
    private $teamID;
    private $score;
    private $ranking;
    
    public function __construct($matchID,$roundID, $matchGroup, $teamID, $score,$ranking) {
        
        $this->matchID = $matchID;
        $this->roundID = $roundID;
        $this->matchGroup = $matchGroup;
        $this->teamID = $teamID;
        $this->score = $score;
        $this->ranking = $ranking;
    }

    
    public function getMatchID() {
        return $this->matchID;
    }
    public function getRoundID() {
        return $this->roundID;
    }

public function getMatchGroup() {
        return $this->matchGroup;
    }

    public function getTeamID() {
        return $this->teamID;
    }


    public function getScore() {
        return $this->score;
    }
    public function getRanking() {
        return $this->ranking;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}

