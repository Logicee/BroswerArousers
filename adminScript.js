let lastTeamID = 0;
window.onload = function () {

    getAllItems();
    // add event handler for selections on the table
    document.querySelector("#table").addEventListener("click", handleRowClick);
    document.querySelector("#clrSelection").addEventListener("click", clearSelections);
};

function handleRowClick(e) {
    //add style to parent of clicked cell
    clearSelections();
    e.target.parentElement.classList.add("highlighted");

    // enable Delete and Update buttons
    document.querySelector("#createTeam").removeAttribute("enabled", "disabled");
    document.querySelector("#deleteTeam").removeAttribute("disabled", "enabled");
    document.querySelector("#updateTeam").removeAttribute("disabled", "enabled");
}

function clearSelections() {
    let trs = document.querySelectorAll("tr");
    for (let i = 0; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");
    }
    document.querySelector("#createTeam").removeAttribute("disabled", "enabled");
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
//    document.querySelector("#deleteTeam").setAttribute("disabled", "disabled");
//    document.querySelector("#updateTeam").setAttribute("disabled", "disabled");
}

function buildTable(text) {
    //{"Number":1,"CarName":" Chevrolet Corvette","Year":2020,"Price":92398}
    let arr = JSON.parse(text); // get JS Objects
    let theTable = document.querySelector("table");
    let html = theTable.querySelector("tr").innerHTML;
    console.log(arr.length + "array length");
    for (let i = 0; i < arr.length; i++) {
        let row = arr[i];
        html += "<tr>";
        console.log(row);
        html += "<td>" + row.teamID + "</td>";
        html += "<td>" + row.teamName + "</td>";
        html += "<td>" + row.playerCount + "</td>";
        html += "</tr>";
    }
    lastTeamID = arr[arr.length - 1].teamID;
    theTable.innerHTML = html;
    setTeamID();
}

//called when clicked on create team
function setTeamID(){
    document.querySelector("#setTeamID").value = lastTeamID;
}



