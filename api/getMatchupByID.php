
<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/db/MatchupAccessor.php');
require_once ($projectRoot . '/entity/Matchup.php');

$matchID = file_get_contents('php://input');

try {
    $ma = new MatchupAccessor();
    $matchup = $ma->getMatchupByID($matchID);
     $matchup = json_encode($matchup, JSON_NUMERIC_CHECK);
    echo $matchup;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}

