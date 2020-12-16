<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/accessors/TeamAccessor.php');
require_once ($projectRoot . '/entity/Team.php');
require_once ($projectRoot . '/ChromePhp.php');
// reading the HTTP request body
//$body = file_get_contents('php://input');
//$contents1 = json_decode($body, true);

// create a team object
$teamID = $_GET['teamID'];
$teamName = $_GET['teamName'];
$teamObj = new Team($teamID, $teamName, 0);

ChromePhp::log("//////////////////Hello");
// add the object to DB
try {
    $mia = new TeamAccessor();
    ChromePhp::log("//////////////////Before");
    $success = $mia->insertItem($teamObj);
    ChromePhp::log("//////////////////After");
    echo $success;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}

//redirects to adminIndex
$projectRoot = filter_input('DOCUMENT_ROOT') . '/BABowlingApp';
header("Location:". $projectRoot."/adminIndex.php");

