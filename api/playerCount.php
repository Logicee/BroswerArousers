<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/accessors/PlayerAccessor.php');

try {
    $mia = new PlayerAccessor();
    $results = $mia->getPlayerCount();
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}

