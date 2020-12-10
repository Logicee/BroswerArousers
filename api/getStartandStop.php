<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once $projectRoot . '/db/dbconnection.php';

$ROUND = file_get_contents('php://input');
$connClass = new dbConnect;
$conn = $connClass->connectToDB();

$startStmt = $conn->prepare("SELECT min(gameid) FROM game WHERE matchid in(SELECT matchid from matchup where roundid = '$ROUND')");
$startStmt->execute();
$startid = $startStmt->fetch()[0];
$lastStmt = $conn->prepare("SELECT max(gameid) FROM game WHERE matchid in(SELECT matchid from matchup where roundid = '$ROUND')");
$lastStmt->execute();
$lastid = $lastStmt->fetch()[0];

echo "$startid $lastid";