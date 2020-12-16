<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
require_once ($projectRoot . '/accessors/PlayerAccessor.php');
require_once ($projectRoot . '/entity/Player.php');
require_once ($projectRoot . '/ChromePhp.php');

$body = file_get_contents('php://input');
$contents1 = json_decode($body, true);

$PlayerObj = new Player($contents1["playerID"],$contents1["teamID"],$contents1["firstName"],$contents1["lastName"],$contents1["hometown"],$contents1["provinceCode"]);

//$PlayerObj = new Player(500, 1, "asdf", "fdsa", "asdf", "AB");
ChromePhp::log($PlayerObj);
try {
    $mia = new PlayerAccessor();
    $success = $mia->insertItem($PlayerObj);
    echo $success;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}
