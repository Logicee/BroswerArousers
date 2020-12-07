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
function handleRowClick(e){
    clearSelections();
    e.target.parentElement.classList.add("highlighted");
    
   
let id= e.target.parentElement.firstChild.innerHTML;
console.log(id);
fillTheTeam(id);

    
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
                buildTable(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();}
function buildTable(text) {
  
    let arr = JSON.parse(text); // get JS Objects
    
     let theTable = document.getElementById("table1");
    let html = theTable.querySelector("tr").innerHTML;
    console.log(arr.length + "array length");
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        html += "<tr>";
       // console.log(row);
        html += "<td>" + row.teamID + "</td>";
        html += "<td>" + row.teamName + "</td>";
        html += "<td>" + row.playerCount + "</td>";
        html += "</tr>";
    }
    lastTeamID = arr[arr.length - 1].teamID;
    theTable.innerHTML = html;
    
}
function buildTable2(text){
 let arr = JSON.parse(text); // get JS Objects
   console.log(arr);
    let theTable = document.getElementById("table2");
    let html = theTable.querySelector("tr").innerHTML;
    console.log(text.length + "array length");
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        html += "<tr>";
        console.log(row);
        
        html += "<td>" + row.FName + "</td>";
        html += "<td>" + row.LName + "</td>";
        html += "<td>" + row.province + "</td>";
        html += "<td>" + row.homeTown + "</td>";
        html += "<td>" + row.ID + "</td>";
        html += "</tr>";
    }
    lastTeamID = text[text.length - 1].teamID;
    theTable.innerHTML = html;
}
function fillTheTeam(text){
    let url="api/getAllPlayers.php";
    //convery team number form string to int
    let teamNum= parseInt(text);
    let xmlhttp= new XMLHttpRequest();
    console.log("running");
    xmlhttp.onreadystatechange= function(){
        if(xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
          
            if (resp.search("ERROR") >= 0) {
                alert("oh no...");
            } else { console.log(xmlhttp.responseText);
                buildTable2(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send(teamNum);}
    
    
