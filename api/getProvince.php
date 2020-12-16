<?php
$projectRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/BABowlingApp';
require_once ($projectRoot . '/accessors/PlayerAccessor.php');
require_once ($projectRoot . '/entity/Province.php');

try {
    $mia = new PlayerAccessor();
    $results = $mia->getAllProvince();
    $results = json_encode($results);
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}

