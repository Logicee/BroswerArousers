<?php
require_once 'dbconnection.php';
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/entity/Game.php');
;

class GameAccessor {

    private $getGamesByStatusStatementString = "select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")";
    private $getGamesByComplete="SELECT * from game WHERE gameStateID='COMPLETE'";
   
    private $conn = NULL;
    private $getGamesByStatusStatement = NULL;
 


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
  
        return $this->getGamesByQuery("select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")");
        
    }
    public function getCompleteGames() {
  
        return $this->getGamesByQuery($this->getGamesByComplete);
        
    }

    public function getGameState() {
        return $this->getGamesByQuery("select * from game");
    }
    
}//end class

