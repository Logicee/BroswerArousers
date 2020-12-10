/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


window.onload = function () {

    getAllTeams();
    // add event handler for selections on the table
    document.querySelector("#table1").addEventListener("click", handleRowClick);
  

    
    
};

let teamID = 0;

function handleRowClick(e){
    var element = e.target;
    clearSelections();

       if (element.tagName == "TD") {
        e.target.parentElement.classList.add("highlighted");
    
            teamID = e.target.parentElement.firstChild.innerHTML;
console.log(teamID);
getTeamPlayers();
       
    }
      
}
function clearTheTable(){
 let theTable = document.querySelector("table");
 theTable.innerHTML-"";
}

function clearSelections(){
      let trs = document.querySelectorAll("tr");
    for (let i = 0; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");
    }
   
}
function getAllTeams()
        {  let url = "api/getAllTeams.php"; // file name or server-side process name
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0) {
                alert("oh no...");
            } else {
                buildTeamTable(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();}


function buildTeamTable(text) {
  
    let arr = JSON.parse(text);
    
     let theTable = document.getElementById("table1");
    let html = "" ;
    
    
    
    console.log(arr.length + "array length");
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        html += "<tr>";
       // console.log(row);
        html += "<td>" + row.teamID + "</td>";
        html += "<td>" + row.teamName + "</td>";
        html += "</tr>";
    }
    lastTeamID = arr[arr.length - 1].teamID;
    theTable.querySelector("#theTeams").innerHTML = html;
    
}
function buildPlayerTable(text){
 let arr = JSON.parse(text);
   console.log(arr);
    let theTable = document.getElementById("table2");
    let html = "";
    console.log(text.length + "array length");
   
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        html += "<tr>";
        console.log(row);
        
        html += "<td>" + row.playerID + "</td>";
        html += "<td>" + row.FName + " " + row.LName + "</td>";
       html += "<td>" + row.homeTown + "</td>";
        html += "<td>" + row.province + "</td>";
        html += "</tr>";
    }
    theTable.querySelector("tbody").innerHTML = html;
  
}

//will list players from team selected
function getTeamPlayers(){
      
    let url="api/getPlayersByTeamID.php";
    //convert team number from string to int
    let teamNum= parseInt(teamID);
    let xmlhttp= new XMLHttpRequest();
    console.log(teamNum);
    xmlhttp.onreadystatechange= function(){
        if(xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
          
            if (resp.search("ERROR") >= 0) {
                alert("oh no...");
            } else { console.log(xmlhttp.responseText);
                buildPlayerTable(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send(teamID.toString());
    
    
}//

    
    
