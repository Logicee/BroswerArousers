<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/accessors/TeamAccessor.php');
require_once ($projectRoot . '/entity/Team.php');

// reading the HTTP request body
//$body = file_get_contents('php://input');
//$contents1 = json_decode($body, true);

// create a team object
$teamID = $_GET['teamID'];
$teamName = $_GET['teamName'];
$CarObj = new Team(51, "sdf", Null);

// add the object to DB
try {
    $mia = new TeamAccessor();
    $success = $mia->insertItem($CarObj);
    echo $success;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}

//redirects to adminIndex
$projectRoot = filter_input('DOCUMENT_ROOT') . '/BABowlingApp';
header("Location:". $projectRoot."/adminIndex.php");
?>
