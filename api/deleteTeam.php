<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/db/TeamAccessor.php');
require_once ($projectRoot . '/entity/Team.php');

// reading the HTTP request body - should contain a single integer
$id = intval(file_get_contents('php://input'));

// create a dummy MenuItem object - only ID matters
$TeamItemObj = new Team($id, "dummy", 0);

// delete from DB
try {
    $mia = new TeamAccessor();
    $success = $mia->deleteItem($TeamItemObj);
    echo $success;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
//$projectRoot = filter_input('DOCUMENT_ROOT') . '/BABowlingApp';
//header("Location:" . $projectRoot . "/adminIndex.php");

