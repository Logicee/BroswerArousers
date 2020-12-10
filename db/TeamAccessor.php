<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once 'dbconnection.php';
require_once ($projectRoot . '/entity/Team.php');

class TeamAccessor {

      private $getGamesByStatusStatementString = "select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")";
   
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

    public function getAllTeams(){
        return $this->getTeamsByQuery("select * from team");
    }
  
    private function getTeamsByQuery($selectString) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($selectString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $record) {
                $teamID = $record['teamID'];
                $teamName = $record['teamName'];
                $earnings = $record['earnings'];
                $team = new Team($teamID, $teamName, $earnings);
                
                array_push($result, $team);
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
    }//end getTeamByQuery()
    
    public function getTeamByID($id) {
  
        //return $this->getTeamsByQuery("select * from team where teamID = $id");
        $team = []; 
        try {
            $stmt = $this->conn->prepare("select * from team where teamID = $id");
            $stmt->execute();
            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $teamID = $record['teamID'];
                $teamName = $record['teamName'];
                $earnings = $record['earnings'];
                $team = new Team($teamID, $teamName, $earnings);
            
            
        }
        catch (Exception $e) {
            $team = [];
        }
        finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }
    
    return $team;
    }
}//end class


