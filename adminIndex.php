<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="bowling1.css"/>
        
        <script src="adminScript.js"></script>
    </head>
    <body>
        <form action="index.php">
            
            
            <button type="submit">LogOut</button><!--Need to give main page link-->
            
        </form>
        
        <div class=" justify-content-center row mt-2">
            <div class="col-11">
                <h1>Team Management</h1>
            </div>
            <div class="col-1-auto">
                <img id="logo" class="img-thumbnail rounded float-right" alt="Bowling App logo"/>
            </div>
        </div>
        <div>
            <a href="adminIndex.php" class="aManage_btn">Manage Teams</a>
            <a class="aManage_btn" href="">Manage Players</a> 
            <a class="aManage_btn" href="" id="clrSelection">Clear Selection</a>
        </div>     
        <div class="mainTable">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <h2>Teams</h2>
                    <form action="createTeam.php" method="GET">
                        <input type="hidden" value =" 0" id="setTeamID" name="id">
                        <button id="createTeam" type="submit"enabled>Create Team</button>
                    </form>
                    <button id="updateTeam" disabled>Update Team</button>
                    <button id="deleteTeam" disabled>Delete Team</button>
                    
                    <table class="table table-responsive border table-hover text-center" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Team ID</th>
                                <th>Team Name</th>
                                <th>Player Count</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
       
    </body>
</html>
