<?php

$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once $projectRoot . '/db/dbconnection.php';



$id = intval(file_get_contents('php://input'));

try {
    //create db connection and send an update statement to change game statusID to "INPROGRESS"
    $connClass = new dbConnect;
    $conn = $connClass->connectToDB();
    $stmt = $conn->prepare("update game set gameStateID = 'INPROGRESS' where gameID = $id");
    
    $temp = $stmt->execute(); 
    $results = json_encode($temp, JSON_NUMERIC_CHECK);
    $stmt->closeCursor();

    echo $results;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

