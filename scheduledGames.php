<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="scheduledGames.js"/>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="bowling1.css"/>

        <title>Bowling App Scheduled Games</title>
    </head>
    <body>
        <form action="index.php">  <button type="submit">LogOut</button></form>
        <div class=" justify-content-center row mt-2">
            <div class="col-11">
                <h1>Bowling Tournament</h1>
            </div>
            <div class="col-1-auto">
                <img id="logo" class="img-thumbnail rounded float-right" alt="Bowling App logo" src="bowling.png"/>
            </div>
        </div>
        <div class="row justify-content-center">    
            <div class="col-auto">
                <h2 class="">Games List</h2>
                <form action="scoreGame.php" method="POST">


                    <table id="scheduledGamesTable" class="table table-responsive border table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th>Game ID</th>
                        <th>Round</th>
                        <th>Game</th>
                        <th>Team</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="theGames">
                    <tr>
                        <td>Qualifier</td>
                        <td>1</td>
                        <td>King Pins</td>
                        <td>In Progress</td>
                    </tr>
                     <tr>
                        <td>Qualifier</td>
                        <td>1</td>
                        <td>Lucky Strikes</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>Qualifier</td>
                        <td>1</td>
                        <td>Cosmos</td>
                        <td>In Progress</td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
        <div class="row justify-content-center">
            <input id="inGameID" type="hidden" name="theGame">
            <button id="scoreGame" type="submit" disabled>
                    Score Game
            </button>
        </div>
</form>
    </body>
</html>
