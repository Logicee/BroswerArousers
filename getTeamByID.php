<?php
require_once 'accessors/TeamAccessor.php';
try {
    $ta = new TeamAccessor();
    $team = $ta->getScheduledGames(); //are objects
   
    $team = json_encode($team, JSON_NUMERIC_CHECK);

    echo $team;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
