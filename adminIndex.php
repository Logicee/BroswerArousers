<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="bowling1.css"/>

        <script src="adminScript.js"></script>
    </head>
    <body>
        <?php
        $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/BABowlingApp';
        require_once ($projectRoot . '/ChromePhp.php');
        ?>
        <?php ChromePhp::log('/////////****************') ?>
        <form action="index.php">  <button type="submit">LogOut</button></form><!--Need to give main page link-->
        <div class=" justify-content-center row mt-2">
            <div class="col-11">
                <h1>Team Management</h1>
            </div>
            <div class="col-1-auto">
                <img id="logo" class="img-thumbnail rounded float-right" alt="Bowling App logo"/>
            </div>
        </div>
        <div>
            <form action="displayPlayers.php" method="GET">
                <input type="hidden" value="" name="hiddenID" id="hiddenID">
                <button disabled id="mPlayers" class="tempD" type="submit">Manage Players</button>
            </form>
            <button class="aManage_btn"><a href="" id="clrSelection"> Clear Selection</a></button>
            <!--<a href="adminIndex.php" class="aManage_btn">Manage Teams</a>-->
<!--            <a class="aManage_btn" href="" id="mPlayers">Manage Players</a> 
            <a class="aManage_btn" href="" id="clrSelection">Clear Selection</a>-->
        </div>     

        <div class="mainTable">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <h2>Teams</h2>
                    <form action="createTeam.php" method="GET">
                        <input type="hidden" value =" 0" id="setTeamID" name="id">
                        <button id="createTeam" type="submit"enabled>Create Team</button>
                    </form>
                    <!--Experiment-->
                    <button id="updateTeam" disabled type="button" data-toggle="modal" data-target=".bd-example-modal-sm">Update Team</button>
                    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content" >
                                <form class="editTeam">
                                    <div class="form-group">
                                        <h4>Edit Team Name</h4>
                                        <label for="teamName">Team Name</label>
                                        <input name="teamName" type="text" id="teamN">
                                    </div>
                                    <button class="btn btn-primary" type="submit" id="upTeam">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Experiment-->
                    <button id="deleteTeam" disabled>Delete Team</button>
                    <table class="table table-responsive border table-hover text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Team ID</th>
                                <th scope="col">Team Name</th>
                                <th scope="col">Player Count</th>
                            </tr>
                        </thead>
                        <tbody id="mtable">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>
</html>
