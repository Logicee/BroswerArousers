

matchID = 0;
window.onload = function () {
    getScheduledGames();
    document.querySelector("#theGames").addEventListener("click", rowClick);
    document.querySelector("#scoreGame").addEventListener("click", updateGameStatus);
  
};//end window.onload function()


function rowClick(e) {
    //get all rows and take away  class "highlight"
    let rows = document.querySelectorAll("tr");
    for (let i = 0; i < rows.length; i++) {
        rows[i].classList.remove("highlight");
     
    }
    //when a table row is clicked and is a <td>, add highlight class to parent <tr> and set hidden input value to gameID
    //if status is Available, enable score game button else disable score button
    var element = e.target;
    if (element.tagName == "TD") {
        e.target.parentElement.classList.add("highlight");
        if(e.target.parentElement.lastElementChild.innerHTML == "AVAILABLE"){
            
            //set hidden input to gameID
            document.querySelector("#inGameID").value = e.target.parentElement.children[0].innerHTML;
            
           // e.target.parentElement.children[0].value =  
            document.querySelector("#scoreGame").removeAttribute("disabled");
            
            
        }else{
            document.querySelector("#scoreGame").setAttribute("disabled", false);
        }
    }
    
    

};//end rowClick(e)



//This funcation calls a php function to get the information for scheduled games
function getScheduledGames(){
        let url = "api/getScheduledGames2.php";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0) {
                alert("Unable to access Games!");
            } else {
                //build table using scheduled game data in array
                let arrayGames = JSON.parse(resp);
                let gameList = document.querySelector("#theGames");
                //build table rows using scheduled game data in array and add them to table
                let tableData = "";
                for (let i = 0; i < arrayGames.length; i++) {
                    let game = arrayGames[i];
                    
                    tableData += "<tr><td>"  + game["gameID"] + "</td><td>" + game["matchID"] + "</td>";
                    tableData += "<td>" + game["gameNumber"] + "</td>";
                   tableData += "<td>" + game["teamName"] + "</td>";
                    tableData += "<td>" + game["gameStateID"] + "</td>";
                    tableData += "</tr>";
                }//end for i
                
                gameList.innerHTML = tableData;
            }
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send();
    
};//end getScheduledGames()



//using the game id of row selected is sent as input for the calling of updateGameStaus.php. this call updates the gameStateID from AVAILABLE to INPROGRESS 
function updateGameStatus(){
    var id = document.querySelector("#inGameID").value;
    var url = "api/updateGameStatus.php";
    var xmlhttp = new XMLHttpRequest();
    
    
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var resp = xmlhttp.responseText;
            console.log(resp);
         
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send(id);    
}//end updateGameStatus()
    
    