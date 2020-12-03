<?php

$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once $projectRoot . '/db/dbconnection.php';



$obj = file_get_contents('php://input');
$obj = json_decode($obj, true);
try {
    //create db connection and send an update statement to change game statusID to "INPROGRESS"
    
    
    $id = intval($obj["gameID"]);
    $balls = $obj["balls"];
    $score = intval($obj["score"]);
    
    $connClass = new dbConnect;
    $conn = $connClass->connectToDB();
    $stmt = $conn->prepare("update game set gameStateID = 'COMPLETE', score = $score, balls = \"$balls\" where gameID = $id");
    
     $temp = $stmt->execute(); 
    $results = json_encode($temp, JSON_NUMERIC_CHECK);
    $stmt->closeCursor();

    echo $results;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
