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
    function getTheRecap($teamID){
        $result=[];
        try{ $recap= $this->conn->prepare("SELECT gameID,gameNumber, FROM game WHERE matchID IN (SELECT matchID FROM matchup WHERE teamID= $teamID)");
           $recap->execute(); 
           $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
           foreach ($dbresults as $record) { $gameID = $record['gameID'];
           $gameNumber = $record['gameNumber'];
           $aRecord = array($gameID,$gameNumber,$teamID);
           array_push($result,$aRecord);
        }}
        catch (PDOException $e){
        $result=[];
        } finally {
            if (!is_null($recap)) {
                $recap->closeCursor();
            }
    } return $result;}
    
    function assignMatches($gameid){
        try{
        //check if the rounds are ranked
        //get amount of matches in round vs ranked matches
        $roundStmt = $this->conn->prepare("SELECT roundid FROM matchup WHERE matchid = "
                . "(SELECT matchid FROM game WHERE gameid = $gameid)");
        $roundStmt->execute();
        $round = $roundStmt->fetch()[0];
        $set1 = $this->conn->prepare("SELECT count(*) FROM matchup WHERE roundid ='$round'");
        $set1->execute();
        $count1 = $set1->fetch()[0];
        $set2 = $this->conn->prepare("SELECT count(*) FROM matchup WHERE roundid = '$round'"
                . " AND ranking is not null");
        $set2->execute();
        $count2 = $set2->fetch()[0];

        if ($count1 == $count2){
            
            if ($round == 'QUAL'){
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
                
                
                //bottom 8 per matchgroup
                for($i=1, $j=15; $i<16; $i+=2){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$j--][0]." WHERE matchid = ".($startid+$i))->execute();
                }
                $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid FROM matchup WHERE roundid = 'SEED1')")->execute();
                
                shuffle($winners);
                $startStmt = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'RAND1'");
                $startStmt->execute();
                $startid = $startStmt->fetch()[0];
                for($i=0; $i<16; $i++){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$i][0]." WHERE matchid = ".($startid+$i))->execute();
                }
                $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid FROM matchup WHERE roundid = 'RAND1')")->execute();
                
            } elseif (substr($round, -1) == '4'){
                $seedStmt = $this->conn->prepare("SELECT count(*) FROM matchup WHERE roundid = 'seed4' AND ranking is not null");
                $randStmt = $this->conn->prepare("SELECT count(*) FROM matchup WHERE roundid = 'rand4' AND ranking is not null");
                $randStmt->execute();
                $seedStmt->execute();
                if($randStmt->fetch()[0] == 2 && $seedStmt->fetch()[0] == 2){
                    $win1Stmt = $this->conn->prepare("SELECT teamid FROM matchup WHERE roundid = 'rand4' AND ranking = 1");
                    $win2Stmt = $this->conn->prepare("SELECT teamid FROM matchup WHERE roundid = 'seed4' AND ranking = 1");
                    $win1Stmt->execute();
                    $win2Stmt->execute();
                    $winner1 = $win1Stmt->fetch()[0];
                    $winner2 = $win2Stmt->fetch()[0];
                    $this->conn->prepare("update matchup set teamid = $winner1 WHERE matchid = 111")->execute();
                    $this->conn->prepare("update matchup set teamid = $winner2 WHERE matchid = 112")->execute();
                    $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid from matchup WHERE roundid = 'FINAL')")->execute();
                }
            }elseif (substr($round, 0, 4) == 'RAND') {
                
                $winnerStmt = $this->conn->prepare("SELECT teamid FROM matchup WHERE roundid = '$round'"
                    . " AND ranking = 1");
                $winnerStmt->execute();
                $winners = $winnerStmt->fetchAll();
                shuffle($winners);
                $next = (int)substr($round, -1) +1;
                $startStmt = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'RAND$next'");
                $startStmt->execute();
                $startid = $startStmt->fetch()[0];
                for($i=$startid, $j=0; $i< sizeof($winners)+$startid; $i++){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$j++][0]." WHERE matchid = ".$i)->execute();
                }
                $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid from matchup WHERE roundid = 'RAND$next')")->execute();
            } elseif(substr($round, 0, 4) == 'SEED'){
                
                $winnerStmt = $this->conn->prepare("SELECT teamid FROM matchup WHERE roundid = '$round'"
                    . " AND ranking = 1"
                    . " ORDER BY matchgroup");
                $winnerStmt->execute();
                $winners = $winnerStmt->fetchAll();
                $next = (int)substr($round, -1) +1;
                //top half in each round
                $startStmt = $this->conn->prepare("SELECT min(matchid) FROM matchup WHERE roundid = 'SEED$next'");
                $startStmt->execute();
                $startid = $startStmt->fetch()[0];
                for($i=$startid, $j=0; $i<sizeof($winners)+$startid; $i+=2){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$j++][0]." WHERE matchid = ".$i)->execute();
                }
                //bottom half per round
                for($i=$startid+1, $j=sizeof($winners); $i<sizeof($winners)+$startid; $i+=2){
                    $this->conn->prepare("update matchup SET teamid = ".$winners[$j--][0]." WHERE matchid = ".$i)->execute();
                }
                $this->conn->prepare("update game SET gamestateid = 'AVAILABLE' WHERE matchid in(SELECT matchid from matchup WHERE roundid = 'SEED$next')")->execute();
            }
        }
        } catch (PDOException $e){
        return $e;
        }
        return 'ran';
    }

    
}//end class

