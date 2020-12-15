<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/db/GameAccessor.php');
$teamNum = file_get_contents('php://input');
try {
    $ga = new GameAccessor();
    $completeGames = $ga->getTheRecap($teamNum); //are objects
   
    $completeGames = json_encode($completeGames, JSON_NUMERIC_CHECK);

    echo $completeGames;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}