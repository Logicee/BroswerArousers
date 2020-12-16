let lastTeamID = 0;
let chkRes;
window.onload = function () {
    chkGameState();
    getAllItems();
    // add event handler for selections on the table
    document.querySelector("#mtable").addEventListener("click", handleRowClick);
    document.querySelector("#clrSelection").addEventListener("click", clearSelections);
    document.querySelector('#deleteTeam').addEventListener("click", deleteTeam);
    document.querySelector("#updateTeam").addEventListener("click", setTeamName);
    document.querySelector("#upTeam").addEventListener("click", updateTeam);
    document.querySelector("#mPlayers").addEventListener("click", managePlayer);
    
};

function handleRowClick(e) {
    //add style to parent of clicked cell
    clearSelections();
    e.target.parentElement.classList.add("highlighted");
    if (chkRes === true) {
        document.querySelector("#createTeam").removeAttribute("enabled", "disabled");
        document.querySelector("#deleteTeam").removeAttribute("disabled", "enabled");
        document.querySelector("#updateTeam").removeAttribute("disabled", "enabled");
        document.querySelector("#mPlayers").removeAttribute("disabled", "enabled");
        document.querySelector("#mPlayers").classList.remove("tempD");
        document.querySelector("#mPlayers").classList.add("aManage_btn");
    } 
    // enable Delete and Update buttons



}


function clearSelections() {
    let trs = document.querySelectorAll("tr");
    for (let i = 0; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");
    }
    if(chkRes === true){
        document.querySelector("#createTeam").removeAttribute("disabled", "enabled");
    } 
    
}

function getAllItems() {
    let url = "api/getAllTeams.php"; // file name or server-side process name
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
    xmlhttp.send();

    // disable Delete and Update buttons
    document.querySelector("#deleteTeam").setAttribute("enabled", "disabled");
    document.querySelector("#updateTeam").setAttribute("enabled", "disabled");
    
}

function buildTable(text) {
    //{"Number":1,"CarName":" Chevrolet Corvette","Year":2020,"Price":92398}
    let arr = JSON.parse(text); // get JS Objects
    let theTable = document.querySelector("#mtable");
    let html = "";
    //  let html = theTable.querySelector("tr").innerHTML;
    console.log(arr.length + "array length");
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        html += "<tr>";
        console.log(row);
        html += "<td scope='row'>" + row.teamID + "</td>";
        html += "<td scope='row'>" + row.teamName + "</td>";
        html += "<td scope='row'>" + row.playerCount + "</td>";
        html += "</tr>";
    }
    lastTeamID = arr[arr.length - 1].teamID;
    theTable.innerHTML = html;
    setTeamID();
    
}

//called when clicked on create team
function setTeamID() {
    document.querySelector("#setTeamID").value = lastTeamID;
}

function deleteTeam() {
    let row = document.querySelector(".highlighted");
    let id = Number(row.querySelectorAll("td")[0].innerHTML);
    let numPlayers = Number(row.querySelectorAll("td")[2].innerHTML);

    //console.log("The number of players : " + numPlayers);
    // AJAX
    if (numPlayers <= 0) {
        let url = "api/deleteTeam.php";
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                let resp = xmlhttp.responseText;
                console.log(resp);
                if (resp !== "1") {
                    alert("Item NOT deleted.");

                } else {
                    alert("Item deleted.");
                }
                console.log(resp);
                getAllItems();
            }
        };
        xmlhttp.open("POST", url, true);
        xmlhttp.send(id);
    } else {
        alert("Team with ID: " + id + " cannot be deleted. Must have 0 players.");
    }

}

function setTeamName() {
    let row = document.querySelector(".highlighted");
    let id = Number(row.querySelectorAll("td")[0].innerHTML);
    let teamName = row.querySelectorAll("td")[1].innerHTML;

    document.querySelector("#teamN").value = teamName;
    console.log(teamName + "************//////*/*/*/*");
}

function updateTeam() {
    let row = document.querySelector(".highlighted");
    let id = Number(row.querySelectorAll("td")[0].innerHTML);
    let teamName = document.querySelector("#teamN").value;
    console.log(id + "" + teamName);
    let obj = {
        "Team_ID": id,
        "TeamName": teamName
    };
    let url = "api/updateTeam.php";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp !== "1") {
                alert("Item not Updated.");
            } else {
                
                alert("Item Updated.");
            }
            getAllItems();
            //   hideUpdatePanel();
        }
    };
    xmlhttp.open("POST", url, true); // must be POST
    xmlhttp.send(JSON.stringify(obj));
    //   console.log("Team ID from updateTeam: " + id);
}

function managePlayer() {
    let row = document.querySelector(".highlighted");
    let id = Number(row.querySelectorAll("td")[0].innerHTML);
    console.log(id);
    document.querySelector("#hiddenID").value = id;
}

function chkGameState() {
    let url = "api/getGameState.php"; // file name or server-side process name
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0) {
                alert("oh no Game has already started. No edits allowed");
            }
            chkRes = findState(xmlhttp.responseText);
            console.log(chkRes);
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function findState(text) {
    let arr = JSON.parse(text);
    let res = false;
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        console.log(row.gameStateID);
        if (row.gameStateID == "INPROGRESS" || row.gameStateID == "COMPLETE") {
            res = false;
            console.log(row.gameStateID + res);
            alert("The game has already started or completed. No changes allowed");
            break;
        } else {
            res = true;
            console.log(row.gameStateID + res);
        }

    }
    if(res === true){
        document.querySelector("#createTeam").removeAttribute("disabled", "enabled");
    }
    return res;
}






