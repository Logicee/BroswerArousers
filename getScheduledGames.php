<?php
require_once 'accessors/GameAccessor.php';
try {
    $ga = new GameAccessor();
    $scheduledGames = $ga->getScheduledGames(); //are objects
   
    $scheduledGames = json_encode($scheduledGames, JSON_NUMERIC_CHECK);

    echo $scheduledGames;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
