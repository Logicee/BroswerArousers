window.onload = function () {
    getStandings();
  
   
  
};//end window.onload function()


//will get teams to place into tournament standings
function getStandings(){
    let url = "api/getStandings.php";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0) {
                alert("Unable to access Standings!");
            } else {
          
                let arrayTeams = JSON.parse(resp);
                console.log(arrayTeams);
                
                let round1 = document.querySelector("#round1");
                let round1brackets = round1.querySelectorAll(".bracket");
                let round2 = document.querySelector("#round2");
                let round2brackets = round2.querySelectorAll(".bracket");
                let round3 = document.querySelector("#round3");
                let round3brackets = round3.querySelectorAll(".bracket");
                let round4 = document.querySelector("#round4");
                let round4brackets = round4.querySelectorAll(".bracket");
                let final = document.querySelector("#final");
                let finalbrackets = final.querySelectorAll(".bracket");
             
                
                let noWinner = false;
                for (var i = 0; i < arrayTeams.length; i++) {
                    let team = arrayTeams[i];
                    //adds seeded round 1 teams to their brackets
                    if (team.roundID == "SEED1") {
                        console.log(round1brackets[(team.matchgroup - 1)]);
                        console.log(team.matchgroup - 1);
                        if (team.matchID % 2 != 0) {
                           round1brackets[(team.matchgroup - 1)].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round1brackets[(team.matchgroup - 1)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }//adds random round 1 teams to their brackets
                        else if (team.roundID == "RAND1") {
                        console.log(round1brackets[(team.matchgroup + 7)]);
                        console.log(team.matchgroup + 7);
                        if (team.matchID % 2 != 0) {
                           round1brackets[(team.matchgroup +7)].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round1brackets[(team.matchgroup + 7)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }
                        else  if (team.roundID == "SEED2") {
                        
                        if (team.matchID % 2 != 0) {
                           round2brackets[(team.matchgroup - 1)].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round2brackets[(team.matchgroup - 1)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }
                    
                      else  if (team.roundID == "RAND2") {
                        
                        if (team.matchID % 2 != 0) {
                           round2brackets[(team.matchgroup + 3)].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round2brackets[(team.matchgroup + 3)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }              else  if (team.roundID == "SEED3") {
                        
                        if (team.matchID % 2 != 0) {
                           round3brackets[(team.matchgroup - 1 )].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round3brackets[(team.matchgroup - 1)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }  else  if (team.roundID == "RAND3") {
                        
                        if (team.matchID % 2 != 0) {
                           round3brackets[(team.matchgroup + 1  )].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round3brackets[(team.matchgroup + 1)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }else  if (team.roundID == "SEED4") {
                        
                        if (team.matchID % 2 != 0) {
                           round4brackets[(team.matchgroup - 1  )].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round4brackets[(team.matchgroup - 1)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }else  if (team.roundID == "RAND4") {
                        
                        if (team.matchID % 2 != 0) {
                           round4brackets[(team.matchgroup )].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          round4brackets[(team.matchgroup)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        
                    }else  if (team.roundID == "FINAL") {
                        
                        if (team.matchID % 2 != 0) {
                           finalbrackets[(team.matchgroup)].querySelector(".team1").innerHTML = team.teamName; 
                           
                        }else{
                          finalbrackets[(team.matchgroup)].querySelector(".team2").innerHTML = team.teamName;   
                        }
                        if (team.ranking == null) {
                            noWinner == true;
                            
                        }
                        if (noWinner) {
                            
                        }else if(team.ranking == 1){
                            document.querySelector(".winner").innerHTML = team.teamName;
                        }
                    }
                    
                }//end for
                
                
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();   
}//end getStandings