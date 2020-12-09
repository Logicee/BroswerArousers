<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/accessors/PlayerAccessor.php');
$data = file_get_contents('php://input');
$teamNum=intval($data);

try {
    $mia = new PlayerAccessor();
    $results = $mia->getTeamPlayers($data); // these are objects
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    echo $data;
 
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}