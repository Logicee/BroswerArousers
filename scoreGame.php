<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="bowling1.css"/>
        <script src="scoreGame.js"></script>
        <title>Bowling App Score Sheet</title>
    </head>
    
    <body>
        
        <!--new row header -->
        <div class=" justify-content-center row mt-2">
            <div class="col-11">
                <h1>Bowling Tournament</h1>
            </div>
            <div class="col-1-auto">
                <img id="logo" src="bowling.png" class="img-thumbnail rounded float-right" alt="Bowling App logo"/>
            </div>
        </div>

        <!--new row -->
        <div class="row justify-content-center">    
            <div class="col-auto">
                <h1 class="">Scoresheet</h1>
                <form action="scheduledGames.php">
                    <input id="theGameID" type="hidden" value ="<?php echo $_POST["theGame"];?>">
            </div>

        </div>

        <!--new row team info -->
        <div class=" justify-content-center"> 
            <div class="col-2">
                <h3 id="teamName"><u>King Pins</u></h3>
                <p class="mb-0">Game:<span id="game"></span></p>
                <p  class="mb-0">Round:<span id="round">Qualifier</span></p>
                <!--<p id="player" class="mb-3">Player: Wilson Fisk</p>-->
            </div>
            <div class="col-10">

            </div>
        </div>


        <!--new row frames -->
        <div class=" row justify-content-center">
            <div class="col-auto">
                   <label class="mb-0">Enter Number of Pins knocked down:</label> 
                   <input id="ballScore" class="ballScore text-center"  name="ballScore" type="text" pattern="^[0-9 \/ X x]" maxlength="1"> <button type="button" id="enterBall" class="rounded mr-2">Enter</button><button type="button" id="undoBall" class="rounded" disabled>Undo</button>
                <br>
                <label>("/" for Spare "X" for Strike)</label> 
                <table id="gameFrames" class="table table-responsive  text-center mb-0">
                <thead>
                    
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="hidden bonusColor"></td>
                        
                       
                    </tr>    
                    
                </tbody>
            </table>
                <p id="fLabel" class="float-left">Frame Score:</p>
                <table id="frameScores" class="table table-responsive text-center">
                <thead>
                
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="hidden"></td>
                    </tr>    
                </tbody>
            </table>
                
                <button id="submitScore" class="float-right ml-3" type="submit" disabled>
                Submit Score
            </button>
            <label class="float-right">
                    Total Score:<span id="totalScore"></span>    
            </label>
            </div>
        </div>
        
        <div class=" justify-content-center">
            
        </div>

    </form>
        
        
        
        
    </body>
</html>
