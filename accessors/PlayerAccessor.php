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
require_once ($projectRoot . '/entity/Player.php');
require_once ($projectRoot . '/entity/Province.php');
require_once 'dbconnection.php';
require_once ($projectRoot . '/ChromePhp.php');

class PlayerAccessor {

    private $playerString = "SELECT * FROM player WHERE teamID = :id";
    private $provinceString = "SELECT * FROM province";
    private $totalPlayerString = "SELECT * FROM player";
    private $insertPlayerString = "insert into player values (:playerID, :teamID, :firstName, :lastName, :hometown, :provinceCode)";
    //private $insertPlayerString = "INSERT INTO `player` (`playerID`, `teamID`, `firstName`, `lastName`, `hometown`, `provinceCode`) VALUES (:playerID, :teamID, :firstName, :lastName, :hometown, :provinceCode)";
    private $updatePlayerString = "Update player set firstName = :firstName, lastName = :lastName, hometown = :hometown, provinceCode = :provinceCode where playerID = :playerID";
    private $updatePlayerStatement = null;
    private $insertPlayerStatement = null;
    private $totalPlayerStatement = null;
    private $provinceStatement = null;
    private $playerStatement;
    private $conn = null;

    public function __construct() {
        $connect = new dbConnect();

        $this->conn = $connect->connectToDB();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->playerStatement = $this->conn->prepare($this->playerString);
        if (is_null($this->playerStatement)) {
            throw new Exception("bad statement: '" . $this->playerStatement . "'");
        }
        $this->provinceStatement = $this->conn->prepare($this->provinceString);
        if (is_null($this->provinceStatement)) {
            throw new Exception("bad statement: '" . $this->provinceStatement . "'");
        }
        $this->totalPlayerStatement = $this->conn->prepare($this->totalPlayerString);
        if (is_null($this->totalPlayerStatement)) {
            throw new Exception("bad statement: '" . $this->totalPlayerStatement . "'");
        }
        $this->insertPlayerStatement = $this->conn->prepare($this->insertPlayerString);
        if (is_null($this->insertPlayerStatement)) {
            throw new Exception("bad statement: '" . $this->insertPlayerStatement . "'");
        }
        $this->updatePlayerStatement = $this->conn->prepare($this->updatePlayerString);
        if (is_null($this->updatePlayerStatement)) {
            throw new Exception("bad statement: '" . $this->updatePlayerStatement . "'");
        }
        //add additional prepares here
    }

    public function getTeamPlayers($teamID) {
        $this->playerStatement->bindParam(":id", $teamID);
        $this->playerStatement->execute();
        $results = $this->playerStatement->fetchAll(PDO::FETCH_ASSOC);

        $players = [];
        foreach ($results as $row) {
           $playerID = $row['playerID'];
            $teamID = $row['teamID'];
            $fName = $row['firstName'];
            $lName = $row['lastName'];
            $homeTown = $row['hometown'];
            $provinceCode = $row['provinceCode'];
            $player = new Player($playerID, $teamID, $fName, $lName, $homeTown, $provinceCode);
            array_push($players, $player);
        }
        return $players;
    }

    public function getPlayerCount() {
        $result = [];
        try {
            $stmt = $this->conn->prepare($this->totalPlayerString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $row) {
                $playerID = $row['playerID'];
                $teamID = $row['teamID'];
                $fName = $row['firstName'];
                $lName = $row['lastName'];
                $homeTown = $row['hometown'];
                $provinceCode = $row['provinceCode'];
                $player = new Player($playerID, $teamID, $fName, $lName, $homeTown, $provinceCode);
                array_push($result, $player);
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

    public function getAllProvince() {
        $result = [];
        try {
            $stmt = $this->conn->prepare($this->provinceString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $r) {
                $provinceCode = $r['provinceCode'];
                $provinceName = $r['provinceName'];
                $obj = new Province($provinceCode, $provinceName);
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

    public function insertItem($item) {
        $success = false;

        $playerID = $item->getTeamID();
        $teamID = $item->getPlayerID();
        $firstName = $item->getFName();
        $lastName = $item->getLName();
        $homeTown = $item->getHomeTown();
        $province = $item->getProvinceCode();

        ChromePhp::log($playerID);
        ChromePhp::log($teamID);
        ChromePhp::log($firstName);
        ChromePhp::log($lastName);
        ChromePhp::log($homeTown);
        ChromePhp::log($province);
        try {
            $this->insertPlayerStatement->bindParam(":playerID", $playerID);
            $this->insertPlayerStatement->bindParam(":teamID", $teamID);
            $this->insertPlayerStatement->bindParam(":firstName", $firstName);
            $this->insertPlayerStatement->bindParam(":lastName", $lastName);
            $this->insertPlayerStatement->bindParam(":hometown", $homeTown);
            $this->insertPlayerStatement->bindParam(":provinceCode", $province);
            $success = $this->insertPlayerStatement->execute(); // this doesn't mean what you think it means
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->insertPlayerStatement)) {
                $this->insertPlayerStatement->closeCursor();
            }
            return $success;
        }
    }

    public function updateItem($item) {
        $success = false;

        $playerID = $item->getPlayerID();
        $firstName = $item->getFName();
        $lastName = $item->getLName();
        $hometown = $item->getHomeTown();
        $provinceCode = $item->getProvinceCode();

        try {
            $this->updatePlayerStatement->bindParam(":firstName", $firstName);
            $this->updatePlayerStatement->bindParam(":lastName", $lastName);
            $this->updatePlayerStatement->bindParam(":hometown", $hometown);
            $this->updatePlayerStatement->bindParam(":provinceCode", $provinceCode);
            $this->updatePlayerStatement->bindParam(":playerID", $playerID);
            $success = $this->updatePlayerStatement->execute();
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->updatePlayerStatement)) {
                $this->updatePlayerStatement->closeCursor();
            }
            return $success;
        }
    }

}
