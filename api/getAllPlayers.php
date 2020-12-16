<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/accessors/PlayerAccessor.php');
//$teamID= "1"; //need to change it
$teamID =  intval(file_get_contents('php://input'));
//$teamID = $_GET['hiddenID'];
try {
    $mia = new PlayerAccessor();
    $results = $mia->getTeamPlayers($teamID); // these are objects
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
//redirects to displayPlayer
//$projectRoot = filter_input('DOCUMENT_ROOT') . '/BABowlingApp';
//header("Location:". $projectRoot."/displayPlayers.php");