<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/db/GameAccessor.php');
try {
    $ga = new GameAccessor();
    $scheduledGames = $ga->getScheduledGames(); //are objects
   
    $scheduledGames = json_encode($scheduledGames, JSON_NUMERIC_CHECK);

    echo $scheduledGames;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
