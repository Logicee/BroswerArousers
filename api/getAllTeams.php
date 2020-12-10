<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/db/TeamAccessor.php');
require_once ($projectRoot . '/entity/Team.php');
try {
    $ta = new TeamAccessor();
    $results = $ta->getAllTeams();
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
