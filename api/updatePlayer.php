<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/accessors/PlayerAccessor.php');
require_once ($projectRoot . '/entity/Player.php');
require_once ($projectRoot . '/ChromePhp.php');

$body = file_get_contents('php://input');
$contents1 = json_decode($body, true);
ChromePhp::log("here");
$playerObj = new Player($contents1['playerID'],100,$contents1['firstName'], $contents1['lastName'], $contents1['hometown'], $contents1['provinceCode']);

try {
    $mia = new PlayerAccessor();
    $success = $mia->updateItem($playerObj);
    echo $success;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}