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
require_once ($projectRoot . '/entity/status.php');

class statusAccessor {

    private $playerString = "select matchup.teamID,matchup.roundID,matchup.matchgroup,game.gameID,game.matchID,game.gameNumber,game.gameStateID,game.balls,game.score,matchup.score,matchup.ranking  from matchup cross join game where matchup.matchID = game.matchID and teamID = :id ";
    private $playerStatement = null;
    private $conn = null;

    public function __construct() {
        $cm = new dbConnect();
        $this->conn = $cm->connectToDB();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->playerStatement = $this->conn->prepare($this->playerString);
        if (is_null($this->playerStatement)) {
            throw new Exception("bad statement: '" . $this->playerStatement . "'");
        }
        //add additional prepares here
    }

    public function getTeamStatus($teamID) {

        $this->playerStatement->bindParam(":id", $teamID);
        $this->playerStatement->execute();
        $results = $this->playerStatement->fetchAll(PDO::FETCH_ASSOC);

        $statuss = [];
        foreach ($results as $row) {
            $teamID = $row['teamID'];
            //$playerName = $row['playerName'];
            $roundID = $row['roundID'];
            $matchgroup = $row['matchgroup'];
            $gameID = $row['gameID'];
            $matchID = $row['matchID'];
            $gameNumber = $row['gameNumber'];
           $gameStateID = $row['gameStateID'];
            $balls = $row['balls'];
            $score = $row['score'];
            $score = $row['score'];
            $ranking = $row['ranking'];
            $status = new Status($teamID, $roundID, $matchgroup, $gameID, $matchID, $gameNumber,$gameStateID, $balls, $score , $score, $ranking);
            array_push($statuss, $status);
        }
        return $statuss;
    }

}
