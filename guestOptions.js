/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


window.onload = function () {
    // add event handlers for buttons
    document.querySelector("#standing").addEventListener("click", standingView);
    document.querySelector("#recap").addEventListener("click", recapView);
    document.querySelector("#payout").addEventListener("click", payoutView);
HideEmAll();
};


function HideEmAll(){
   let tabbys= document.querySelectorAll(".hide");
  console.log(tabbys);;
   for (var i = 0; i < tabbys.length; i++) {
        let temp= tabbys[i];
                temp.classList.add("hidden");
        console.log(tabbys[i]);
    }}


function standingView(){
    HideEmAll();
    document.querySelector("#standingtab").classList.remove("hidden");
    
}
function recapView(){
    HideEmAll();
    document.querySelector("#recaptab").classList.remove("hidden");
            let url = "api/getAllGames.php";
                             let gameList = document.querySelector("#recaptab");
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            console.log("got here");
            let tableData="";
            if (resp.search("ERROR") >= 0) {
                alert("Unable to access Games!");
            }
           
            else { console.log("alternate");
                let arrayGames = JSON.parse(xmlhttp.responseText);
                
                if(arrayGames.length!=0){
               tableData = "";
                for (let i = 0; i < arrayGames.length; i++) {
                    let game = arrayGames[i];
                    getMatchByMatchID(game.matchID)
                    tableData += "<tr><td>" + game.matchID + "</td>";
                    tableData += "<td>" + game.gameNumber + "</td>";
                    tableData += "<td>" + match + "</td>";
                    tableData += "<td>" + game.gameStateID + "</td>";
                    tableData += "</tr>";
                }}
            else{tableData="No complete games yet!"; }}
            
                
                gameList.innerHTML = tableData;
            
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send();
};//

function payoutView()
{ HideEmAll();
    document.querySelector("#payouttab").classList.remove("hidden");
}















































