<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once $projectRoot . '/db/dbconnection.php';

try {
    $id = intval(file_get_contents('php://input'));
    $connClass = new dbConnect;
    $conn = $connClass->connectToDB();
    $stmt = $conn->prepare("select g.gameID, g.matchID, g.gameNumber, t.teamName ,g.gameStateID, m.roundID from game g, team t, matchup m where g.gameStateID IN('AVAILABLE','INPROGRESS') AND g.matchID = m.matchID AND m.teamID = t.teamID and g.gameID = $id");
    $stmt->execute();
    $temp = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $results = json_encode($temp, JSON_NUMERIC_CHECK);
    $stmt->closeCursor();

    echo $results;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
