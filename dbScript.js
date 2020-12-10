/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


window.onload = function(){
    document.querySelector("div").onclick = assignScores;
    setTimeout(10000, commitScore);
}

function assignScores(e){
    if(e.target.tagName == 'BUTTON'){
        let round = e.target.value;
        
        var url = "api/getStartandStop.php";
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var resp = xmlhttp.responseText.split(" ");
                console.log(resp);
                let start = Number(resp[0]), stop = Number(resp[1]);
                for(let i=start; i<stop; i++){
                    commitScore(i);
                }
            }
        };  
        xmlhttp.open("POST", url, true);
        xmlhttp.send(round);
    }
}

function commitScore(gameid){
    
    let ballString = "x x x x x x x x x x x"
    let overallTotal = Math.floor(Math.random()*300 + 1);
    let obj = {gameID: gameid, balls: ballString, score: overallTotal};
    var url = "api/updateGameScore.php";
    var xmlhttp = new XMLHttpRequest();


    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var resp = xmlhttp.responseText;
            console.log(resp);
            if(resp.includes('40001'))
                commitScore(gameid);
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send(JSON.stringify(obj));
    
}