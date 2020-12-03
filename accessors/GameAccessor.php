<?php
require_once 'dbconnection.php';
require_once 'entity/Game.php';
include 'ChromePhp.php';
class GameAccessor {

    private $getGamesByStatusStatementString = "select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")";
       private $scheduledGameInfoString = "select g.gameID, g.matchID, g.gameNumber, t.teamName ,g.gameStateID from game g, team t, matchup m where g.gameStateID IN('AVAILABLE','INPROGRESS') AND g.matchID = m.matchID AND m.teamID = t.teamID";

    private $conn = NULL;
    private $getGamesByStatusStatement = NULL;
private $scheduledGameInfoStatement = NULL;

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
        
               $this->getGamesByStatusStatement = $this->conn->prepare($this->scheduledGameInfoString);
        if (is_null($this->scheduledGameInfoStatement)) {
            throw new Exception("bad statement: '" . $this->scheduledGameInfoStatement . "'");
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
         $result = [];
     try {
            $stmt = $this->conn->prepare($this->scheduledGameInfoString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($dbresults as $record) {
                
            }
                $record['g.gameID'];
                 $record['g.matchID'];
                $record['g.gameNumber'];
                $record['g.gameStateID'];
                $record['t.teamName'];
                ChromePhp::log($teamName);
                system($teamName);
            $aRecord = [$gameID, $matchID, $gameNumber,$teamName,$gameStateID];
                array_push($result, $aRecord);
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
    
    
    
    
    public function updateGameByID($id){
        
        
        
        
        
        
    }//updateGameByID()

    
}//end class

