<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/db/PlayerAccessor.php');
require_once ($projectRoot . '/entity/Player.php');
$data = file_get_contents('php://input');


$teamNum=intval($data);

try {
    $pa = new PlayerAccessor();
    $results = $pa->getPlayersByTeamID($teamNum); 
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    
    echo $results;
    
 
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}