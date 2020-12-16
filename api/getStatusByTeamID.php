<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/db/statusAccessor.php');
require_once ($projectRoot . '/entity/status.php');
$data = file_get_contents('php://input');


$teamNum=intval($data);

try {
    $pa = new statusAccessor();
    $results = $pa->getTeamStatus($teamNum); 
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    
    echo $results;
    
 
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}