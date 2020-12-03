<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'TeamAccessor.php';
        $TA = new TeamAccessor();
        $team = $TA->getTeamByID(1);
        echo $team->getTeamName().$team->getPlayers()[0]->getFName();
        ?>
    </body>
</html>
