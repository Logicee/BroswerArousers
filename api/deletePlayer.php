<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/accessors/TeamAccessor.php');
require_once ($projectRoot . '/entity/Player.php');

$id = intval(file_get_contents('php://input'));
//$playerID, $teamID, $FName, $LName, $homeTown, $provinceCode
$PlayerObj = new Player($id,000,"dummy", "asd", "errre", "oj");

try {
    $mia = new TeamAccessor();
    $success = $mia->deletePlayer($PlayerObj);
    echo $success;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}

