<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/accessors/GameAccessor.php');

try {
    $mia = new GameAccessor();
    $results = $mia->getGameState(); // these are objects
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}


