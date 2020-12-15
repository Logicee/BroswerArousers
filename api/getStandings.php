<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once $projectRoot . '/db/dbconnection.php';

try {
    $connClass = new dbConnect;
    $conn = $connClass->connectToDB();
    $stmt = $conn->prepare("select m.matchID, m.matchgroup, m.roundID, m.ranking , t.teamName from  team t, matchup m where  m.teamID = t.teamID AND m.roundID NOT LIKE 'QUAL' order by m.matchID");
    $stmt->execute();
    $temp = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $results = json_encode($temp, JSON_NUMERIC_CHECK);
    $stmt->closeCursor();

    echo $results;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
