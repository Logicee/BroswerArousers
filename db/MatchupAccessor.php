<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once 'dbconnection.php';
require_once ( $projectRoot . '/db/Matchup.php');

class MatchupAccessor {

    private $getGamesByStatusStatementString = "select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")";
   private $getMatchupByIDStatementString = "select * from matchup where matchID = :id";
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

  
    private function getMatchupsByQuery($selectString) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($selectString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $record) {
                
                $matchID = $record['matchID'];
                $roundID = $record['roundID'];
                $matchGroup = $record['matchGroup'];
                $teamID = $record['teamID'];
                $score = $record['score'];
                $ranking = $record['ranking'];
                $matchup = new Matchup($matchID,$roundID, $matchGroup, $teamID, $score,$ranking);
                
                array_push($result, $matchup);
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
    
    
    public function getMatchupByID($match) {
        $matchup = null;
        
        
        
        try {
            
            
            $this->getMatchupByIDStatementString->bindParam(":id", $match);
            $this->getMatchupByIDStatementString->execute();
             $dbresults = $this->getMatchupByIDStatementString->fetch(PDO::FETCH_ASSOC);
           
             if ($dbresults) {
                 
             
                $matchID = $dbresults['matchID'];
                $roundID = $dbresults['roundID'];
                $matchGroup = $dbresults['matchGroup'];
                $teamID = $dbresults['teamID'];
                $score = $dbresults['score'];
                $ranking = $dbresults['ranking']; 
                $matchup = new Matchup($matchID, $roundID, $matchGroup, $teamID, $score, $ranking);
                
                
            }
            
        }
        catch (Exception $e) {
            $matchup = null;
        }
        finally {
            if (!is_null($this->getMatchupByIDStatementString)) {
                $this->getMatchupByIDStatementString->closeCursor();
            }
        }
    
    return $matchup;
    }//end getMatchupByID()
          

       
    

    
    
}//end class

