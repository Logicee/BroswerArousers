<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/accessors/GameAccessor.php');

try {
    $ga = new GameAccessor();
    $completeGames = $ga->getCompleteGames(); //are objects
   
    $completeGames = json_encode($completeGames, JSON_NUMERIC_CHECK);

    echo $completeGames;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
