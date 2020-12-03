<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once 'dbconnection.php';
require_once ($projectRoot . '/entity/Game.php');

class GameAccessor {

    private $getGamesByStatusStatementString = "select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")";
    private $getScheduledGameInfoString = "Select g.gameID, g.matchID, g.gameNumber, t.teamName ,g.gameStateID from game g, team t, matchup m where g.gameStateID IN('AVAILABLE','INPROGRESS') AND g.matchID = m.matchID AND m.teamID = t.teamID";
    private $conn = NULL;
    private $getGamesByStatusStatement = NULL;
      private $getscheduledGameInfoStatement = NULL;
 


    public function __construct() {
        $connect = new dbConnect();

        $this->conn = $connect->connectToDB();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->getGamesByStatusStatement = $this->conn->prepare($this->getGamesByStatusStatementString);
        if (is_null($this->getGamesByStatusStatement)) {
            throw new Exception("bad statement: '" . $this->getGamesByStatusStatement . "'");
        }
        
        $this->getscheduledGameInfoStatement = $this->conn->prepare($this->getScheduledGameInfoString);
        if (is_null($this->getscheduledGameInfoStatement)) {
            throw new Exception("bad statement: '" . $this->getscheduledGameInfoStatement . "'");
        }
        //add additional prepares here

    }

  
    private function getGamesByQuery($selectString) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($selectString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $record) {
                $gameID = $record['gameID'];
                $matchID = $record['matchID'];
                $gameNumber = $record['gameNumber'];
                $gameStateID = $record['gameStateID'];
                $score = $record['score'];
                $balls = $record['balls'];
                $game = new Game($gameID, $matchID, $gameNumber, $gameStateID, $score,$balls);
                
                array_push($result, $game);
            }
        }
        catch (Exception $e) {
            $result = [];
        }
        finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $result;
    }//end getGamesByQuery()
    
    public function getScheduledGames() {
        
     try {
            $stmt = $this->conn->prepare($this->getScheduledGameInfoString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dbresults as $record) {
                $gameID = $record['gameID'];
                $matchID = $record['matchID'];
                $gameNumber = $record['gameNumber'];
                $gameStateID = $record['gameStateID'];
                $teamName = $record['teamName'];
                ChromePhp::log($teamName);
                system($teamName);
                $aRecord = array($gameID, $matchID, $gameNumber,$teamName,$gameStateID);
                array_push($result, $aRecord);
            }
        }
        catch (Exception $e) {
            $result = [];
        }
        finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }    
        return $result;
    }

    
}//end class
