<?php

//require_once 'dbconnection.php';
//require_once 'entity/Team.php';
//require_once 'PlayerAccessor.php';
//require_once 'entity/Player.php';

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once 'dbconnection.php';
require_once ($projectRoot . '/entity/Team.php');
require_once ($projectRoot . '/entity/Player.php');
require_once ($projectRoot . '/ChromePhp.php');

class TeamAccessor {

    private $getGamesByStatusStatementString = "select * from game where gameStateID IN(\"AVAILABLE\",\"INPROGRESS\")";
    private $getByIDStatementString = "select * from team where teamID = :number";
    private $insertStatementString = "INSERT INTO `team` (`teamID`, `teamName`) VALUES (:teamID, :teamName)";
    private $deleteStatementString = "delete from team where teamID = :number";
    private $updateStatementString = "update team set teamName = :name where teamID = :id";
    private $deletePlayerString = "delete from player where playerID = :playerNum";
    private $deletePlayer = NULL;
    private $updateStatement = NULL;
    private $deleteStatement = NULL;
    private $getByIDStatement = NULL;
    private $insertStatement = NULL;
    private $conn = NULL;
    private $getGamesByStatusStatement = NULL;

    public function __construct() {
        $cm = new dbConnect();

        $this->conn = $cm->connectToDB();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->getGamesByStatusStatement = $this->conn->prepare($this->getGamesByStatusStatementString);
        if (is_null($this->getGamesByStatusStatement)) {
            throw new Exception("bad statement: '" . $this->getGamesByStatusStatement . "'");
        }
        $this->getByIDStatement = $this->conn->prepare($this->getByIDStatementString);
        if (is_null($this->getByIDStatement)) {
            throw new Exception("bad statement: '" . $this->getAllStatementString . "'");
        }
        $this->insertStatement = $this->conn->prepare($this->insertStatementString);
        if (is_null($this->insertStatement)) {
            throw new Exception("bad statement: '" . $this->getAllStatementString . "'");
        }
        $this->deleteStatement = $this->conn->prepare($this->deleteStatementString);
        if (is_null($this->deleteStatement)) {
            throw new Exception("bad statement: '" . $this->deleteStatementString . "'");
        }
        $this->updateStatement = $this->conn->prepare($this->updateStatementString);
        if (is_null($this->updateStatement)) {
            throw new Exception("bad statement: '" . $this->updateStatementString . "'");
        }
        $this->deletePlayer = $this->conn->prepare($this->deletePlayerString);
        if (is_null($this->deletePlayer)) {
            throw new Exception("bad statement: '" . $this->deletePlayerString . "'");
        }
    }

    private function getTeamsByQuery($selectString) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($selectString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $r) {
                $teamID = $r['teamID'];
                $teamName = $r['teamName'];
                $playerCount = $r['Total_players'];
                $obj = new Team($teamID, $teamName, $playerCount);
                array_push($result, $obj);
            }
        } catch (Exception $e) {
            $result = [];
        } finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $result;
    }

    public function getAllTeams() {
        // return $this->getTeamsByQuery("select t.teamName, p.teamID, count(*) as Total_players from team t, player p where t.teamID = p.teamID group by t.teamID");
        return $this->getTeamsByQuery("select t.teamName, t.teamID, count(p.playerID) as Total_players from team t  LEFT JOIN player p ON t.teamID = p.teamID group by t.teamID;");
    }

    public function getTeamByID($id) {

        //return $this->getTeamsByQuery("select * from team where teamID = $id");
        $team = [];
        try {
            $stmt = $this->conn->prepare("select * from team where teamID = $id");
            $stmt->execute();
            $record = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            $playerAccess = new PlayerAccessor();

            $teamID = $record['teamID'];
            $teamName = $record['teamName'];
            $earnings = $record['earnings'];
            $team = new Team($teamID, $teamName, $earnings, $playerAccess->getTeamPlayers($teamID));
        } catch (Exception $e) {
            $team = [];
        } finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $team;
    }
    
    public function insertItem($item) {
        $success = false;

        $teamID = $item->getTeamID();
        $teamName = $item->getTeamName();
        $earnings = $item->getPlayerCount();
        ChromePhp::log("The values are: " . $teamID . $teamName . $earnings);
        try {
            $this->insertStatement->bindParam(":teamID", $teamID);
            $this->insertStatement->bindParam(":teamName", $teamName);
            // $this->insertStatement->bindParam(":earnings", $earnings);
            $success = $this->insertStatement->execute(); // this doesn't mean what you think it means
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->insertStatement)) {
                $this->insertStatement->closeCursor();
            }
            return $success;
        }
    }

    public function deleteItem($item) {
        $success = false;

        $TeamID = $item->getTeamID(); // only the ID is needed

        try {
            $this->deleteStatement->bindParam(":number", $TeamID);
            $success = $this->deleteStatement->execute(); // this doesn't mean what you think it means
            $rc = $this->deleteStatement->rowCount();
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->deleteStatement)) {
                $this->deleteStatement->closeCursor();
            }
            return $success;
        }
    }

    public function updateItem($item) {
        $success = false;

        $teamID = $item->getTeamID();
        $teamName = $item->getTeamName();
        try {
            $this->updateStatement->bindParam(":name", $teamName);
            $this->updateStatement->bindParam(":id", $teamID);
            $success = $this->updateStatement->execute(); // this doesn't mean what you think it means
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->updateStatement)) {
                $this->updateStatement->closeCursor();
            }
            return $success;
        }
    }

    public function deletePlayer($item) {
        $success = false;

        $PlayerID = $item->getPlayerID(); // only the ID is needed

        try {
            $this->deletePlayer->bindParam(":playerNum", $PlayerID);
            $success = $this->deletePlayer->execute(); // this doesn't mean what you think it means
            $rc = $this->deletePlayer->rowCount();
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->deletePlayer)) {
                $this->deletePlayer->closeCursor();
            }
            return $success;
        }
    }
    

}

//end class

