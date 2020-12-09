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
    
    function assignMatches($gameid){
        try{
        //check if the rounds are ranked
        $this->conn->prepare("update team set teamname = 'fj'")->execute();
        //get amount of matches in round vs ranked matches
        $roundStmt = $this->conn->prepare("SELECT roundid FROM matchup WHERE matchid = "
                . "(SELECT matchid FROM game WHERE gameid = $gameid)");
        $roundStmt->execute();
        $round = $roundStmt->fetch()[0];
        $this->conn->prepare("update team set teamname = 'fag'")->execute();
        $set1 = $this->conn->prepare("SELECT count(*) FROM matchup WHERE roundid ='$round'");
        $set1->execute();
        $count1 = $set1->fetch()[0];
        $set2 = $this->conn->prepare("SELECT count(*) FROM matchup WHERE roundid = '$round'"
                . " AND ranking is not null");
        $set2->execute();
        $count2 = $set2->fetch()[0];

        if ($count1 == $count2){
            $this->conn->prepare("update team set teamname = 're'")->execute();
            if ($round == 'QUAL'){
                $this->conn->prepare("update team set teamname = 'psp'")->execute();
                $winnersStmt = $this->conn->prepare("SELECT teamid FROM matchup WHERE roundid = '$round'"
                    . " AND ranking <= 16"
                    . " ORDER BY ranking");
                $winnersStmt->execute();
                $winners = $winnersStmt->fetchAll();
                
                //top 8 in each matchgroup
                $startStmt = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'SEED1'");
                $startStmt->execute();
                $startid = $startStmt->fetch()[0];
                
                
                for($i=0, $j=0; $i<16; $i+=2){
                    $this->conn->prepare("update matchup SET teamID = ". $winners[$j++][0] ." WHERE matchID = ". ($startid+$i))->execute();
                }
                
                    $this->conn->prepare("update team set teamname = 'cd'")->execute();
                
                //bottom 8 per matchgroup
                for($i=1, $j=8; $i<16; $i+=2){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$j++][0]." WHERE matchid = ".($startid+$i))->execute();
                }
                $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid FROM matchup WHERE roundid = 'SEED1')")->execute();
                
                shuffle($winners);
                $startStmt = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'SEED1'");
                $startStmt->execute();
                $startid = $startStmt->fetch()[0];
                for($i=0; $i<16; $i++){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$i]." WHERE matchid = ".$startid+$i)->execute();
                }
                $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid FROM matchup WHERE roundid = 'SEED1')")->execute();
                
            } elseif (substr($round, 0, 4) == 'RAND') {
                $winners = shuffle($this->conn->prepare("SELECT teamid FROM matchup WHERE roundid =".$round
                    . " AND ranking = 1")->execute());
                $next = (int)substr($round, -1) +1;
                $startid = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'RAND".$next."'")->execute();
                for($i=0; $i< sizeof($winners); $i++){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$i]." WHERE matchid = ".$startid+$i)->execute();
                }
            } elseif(substr($round, 0, 4) == 'SEED'){
                $winners = $this->conn->prepare("SELECT teamid FROM matchup WHERE roundid ='$round'"
                    . " AND ranking = 1"
                    . " ORDER BY matchgroup")->execute();
                $next = (int)substr($round, -1) +1;
                //top half in each matchgroup
                $startid = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'SEED".$next."'")->execute();
                for($i=0, $j=0; $i<sizeof($winners); $i+=2){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$i]." WHERE matchid = ".$startid+$i)->execute();
                }
                //bottom half per matchgroup
                for($i=1, $j=sizeof($winners); $i<sizeof($winners); $i+=2){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$i]." WHERE matchid = ".$startid+$i)->execute();
                }
            }
        }
        } catch (PDOException $e){
        return $e;
        }
        return 'ran';
    }

    
}//end class

