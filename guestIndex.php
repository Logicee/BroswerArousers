<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="bowling1.css"/>
        
        <script src="guestScript.js"></script>
    </head>
    <body>
        <form action="index.php">  <button type="submit">LogOut</button></form><!--Need to give main page link-->
        <div class=" justify-content-center row mt-2">
           
            <div class="col-1-auto">
                <img id="logo" class="img-thumbnail rounded float-right"src="bowling.png" alt="Bowling App logo"/>
            </div>
        </div>
          <div> <h2>Teams</h2></div>
          <form action="disha.php"><button type="submit">More Options</button></form>
          
          <button id="QR" disabled>View all rounds</button>
          <form action="tournamentStandingsPage.php"><button type="submit">View Tournament Standings</button></form>
          <form action="disha.php"><button type="submit">View Payouts</button></form>

            
            
        <div class="mainTable">
         
                
          <div class="row justify-content-center">
                <div class="col-auto">
                    
                    
                    
                    <table class="table table-responsive border table-hover text-center" id="table1">
                        <thead class="thead-dark">
                            <tr class="">
                                <th class="w-50">
                                    Team ID
                                </th>
                                <th class="w-50">
                                    Team Name
                                </th>
                            </tr>
                           
                        </thead>
                        <tbody id="theTeams">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            <div class="row justify-content-center"><table class="table table-responsive border table-hover text-center" id="table3">
                          
                          <tbody id="teams">
                              
                          </tbody>
                  </table></div>
          <div class="secondTable">
              <div class="row justify-content-center">
                  <div class="col-auto">
                      <table class="table table-responsive border table-hover text-center" id="table2">
                          <thead class="thead-dark">
                             
                              <tr>
                                  <th class="w-25">Player ID</th><th class="w-50">Player Name</th><th class="w-20">Hometown</th><th class="w-20">Province</th>
                              </tr>
                          </thead>
                          <tbody id="thePlayers">
                              
                          </tbody>
                      </table>
                      
                  </div></div>
              </div> 
                     
       
    </body>
</html>
