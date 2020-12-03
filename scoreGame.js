/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = function () {

    setGameInfo();
    document.querySelector("#ballScore").focus();
    document.querySelector("#enterBall").addEventListener("click", addBall);
    document.querySelector("#undoBall").addEventListener('click', undoBall);
    document.querySelector("#submitScore").addEventListener('click', updateGame);
};//end window onload

//global variables 
var overallTotal = 0;
var balls = new Array;
var arrFrameScores = new Array;
var id = 0;

//adds the score inputted to the balls array, while performing regex validation.
function addBall() {

    let reg = /[0-9 X x \/ ]{1}/;
    let ballScore = document.querySelector("#ballScore").value;
    //
    if (reg.exec(ballScore)) {
        if (ballScore == "x") {
            ballScore = ballScore.toString().toUpperCase();
        }

        balls.push(ballScore);
        refreshFrames();
        //enables undo ball button
        document.querySelector("#undoBall").removeAttribute("disabled");

    } else {//send user alert, setting focus to text input and clearing the value that they tried to submit
        window.alert("Invalid value for number of pins knocked down!");
        document.querySelector("#ballScore").value = "";
        document.querySelector("#ballScore").focus();
    }

    frameScores();
}
;//end addball()

//will remove the last ball score from the "balls" array, refreshing the scores in the frames afterwards
function undoBall() {
    balls.pop();
    refreshFrames();
    if (balls.length === 0) {
        document.querySelector("#undoBall").setAttribute("disabled", false);
    }
    frameScores();
    document.querySelector("#enterBall").removeAttribute("disabled");
    document.querySelector("#submitScore").setAttribute("disabled", false);
}
;// end undoBall


function refreshFrames() {
    //set tables the tables as variables and create arrays of the tds in each table
    let frameTable = document.querySelector("#gameFrames");
    let frameScoreTable = document.querySelector("#frameScores");
//console.log(frameTable);
    let frames = frameTable.getElementsByTagName("td");
    let frameScores = frameScoreTable.getElementsByTagName("td");
    let frameNum = 0;
    arrFrameScores = new Array;
//make sure no <td>s class have the class "highlight", remove scores from <td>s
    for (var i = 0; i < frames.length; i++) {
        frames[i].innerHTML = "";
        frameScores[i].innerHTML = "";
        frames[i].classList.remove("highlightFrame");
    }//end for i

    //check ball scores to make sure they are valid
    for (var i = 0; i < balls.length; i++) {
        let score = balls[i].toString();
        //if score equals a spare but current game frame is empty, remove the ball score from the balls array and alert user of incorrect input
        if (score == "/" && frames[frameNum].innerHTML == "") {

            undoBall();
            window.alert("cannot be a spare only a number from 0-9 or a strike (X)!");
//if score equals a strike but current game frame is not empty, remove the ball score from the balls array and alert user of incorrect input
        } else if (score == "X" && frames[frameNum].innerHTML != "") {

            undoBall();
            window.alert("Invalid value, only spare or number less than the current frame score!");
//if current game frame is not  empty and the the balls scores for the game frame are numbers adding up to a value greater than 9 remove the ball score from the balls array and alert user of incorrect input
        } else if (frames[frameNum].innerHTML != "" && (parseInt(frames[frameNum].innerHTML) + parseInt(score)) > 9) {
            undoBall();
            window.alert("Invalid value, only spare or number less than the current frame score!");
            //if score equals a strike and current game frame is empty keep score
        } else if (score == "X" && frames[frameNum].innerHTML == "") {
            //if bonus game frame enable submit score button and disable enter ball button 
            if (frameNum == 10) {
                document.querySelector("#enterBall").setAttribute("disabled", false);
                document.querySelector("#submitScore").removeAttribute("disabled");
            }
            //add score to game frame and move onto next game frame
            frames[frameNum].innerHTML = score;
            frameNum++;
        } else if (frames[frameNum].innerHTML == "") {
            frames[frameNum].innerHTML = score;

        } else {
            //add score onto game frame string
            frames[frameNum].innerHTML += " " + score;

            //disable enter ball button and enable submit score button at the end of the 10 frames or the end of the bonus frame 
            if (frameNum == frames.length - 1 && score != "/") {
                document.querySelector("#enterBall").setAttribute("disabled", false);
                document.querySelector("#submitScore").removeAttribute("disabled");
            } else if (frameNum == 10 && score == "/") {
                document.querySelector("#enterBall").setAttribute("disabled", false);
                document.querySelector("#submitScore").removeAttribute("disabled");
            } else {

                frameNum++;
            }

        }
    }//end for i


    //if higihlight current frame user is on and if not on bonus frame, do not display the bonus frame
    if (frameNum < 10) {
        frames[frameNum].classList.add("highlightFrame");
        frames[10].classList.add("hidden");
        frameScores[10].classList.add("hidden")
    } else {
        frames[10].classList.remove("hidden");
        frameScores[10].classList.remove("hidden");
    }

    document.querySelector("#ballScore").value = "";
    document.querySelector("#ballScore").focus();
}//end refreshFrames()




//will score frames based on input of the balls in the balls array
function frameScores() {
    let gameFrameTable = document.querySelector("#gameFrames");
    let gameFrames = gameFrameTable.getElementsByTagName("td");
    let frameScoreTable = document.querySelector("#frameScores");
    let frameScores = frameScoreTable.getElementsByTagName("td");
    let ballCount = balls.length;
    let nextBallStart = 0;
    let counter = 0;
    let score = 0;
    let reset = false;
    let extraBalls = false;
    let lastFrame = false;
    overallTotal = 0;
    //for each SCORE cell calculate the score based on the current individual ball scores in the balls array
    for (var i = 0; i < frameScores.length; i++) {
        let currentFrame = frameScores[i];
        if (i == 9) {
            lastFrame = true;
        } else {
            lastFrame = false;
        }
        //resets the score of the score cell and the number of balls counted for the score and disables the "reset" stopper for scoring of the score frames
        score = 0;
        counter = 0;
        extraBalls = false;
        reset = false;
        //if the next ball to start the score sum, is a ball that hasnt been rolled yet OR the GAME frame for the SCORE cell is currently empty, SET the SCORE cell as empty
        //else calculate the score for the SCORE cell
        if (nextBallStart > ballCount || gameFrames[i].innerHTML == "") {
            currentFrame.innerHTML = "";
        } else {


            for (var j = 0; j < ballCount; j++) {
                //no ball scores have been added to the score set the indexer to the nextBallStart value
                if (counter == 0) {
                    j = nextBallStart;
                }
                console.log(j);

                //if score is a strike add 10 to the score for the score cell
                if (balls[j] == "X") {
                    score += 10;
                    //if this is the first ball being added to the score cell make the nextBallStart become the value of the next ball score to be evaluated. This is to be used as the starting ball score for the NEXT score cell. 
                    //also make extra balls true to add additional balls to the score
                    if (counter == 0) {
                        nextBallStart = (j + 1);
                        extraBalls = true;
                        //if a strike and on last frame show bonus frame
                        if (lastFrame) {
                            gameFrames[10].classList.remove("hidden");
                        }
                        //if 3 balls are now added to score, enable reset to stop scoring of the score cell.
                    } else if (counter == 2) {
                        reset = true;

                    }

                    counter++;
                    //if the current ball is a strike add the remaining amount needed to make the score of the last two ball equal to 10, to the score cell 
                } else if (balls[j] == "/") {
                    score += (10 - parseInt(balls[j - 1]));
                    //if this was the 2nd ball used in the score calculation allow for extra balls in score 
                    if (counter == 1) {
                        nextBallStart = (j + 1);
                        extraBalls = true;
                        //if last frame, show bonus frame
                        if (lastFrame) {
                            gameFrames[10].classList.remove("hidden");


                        }
                    } else if (counter == 2) {
                        reset = true;

                    }
                    counter++;
                } else {
                    //if ball knocked down less than 10 pins, add number of pins to score variable. 
                    score += parseInt(balls[j]);
                    console.log(score);
                    if (counter == 2) {
                        reset = true;

                        //if no extraballs and number of  balls used in calulation is  = 2 , set reset to true to stop scoring of current game frame
                    } else if (counter == 1 && extraBalls == false) {
                        reset = true;
                        //if lastFrame, keep bonus frame and bonus score cell hidden, enable submit score and and disable enter ball button
                        if (lastFrame) {
                            gameFrames[10].classList.add("hidden");
                            frameScores[10].classList.add("hidden");
                            document.querySelector("#enterBall").setAttribute("disabled", false);
                            document.querySelector("#submitScore").removeAttribute("disabled");
                        }
                        nextBallStart = (j + 1);
                    }
                    counter++;

                }
                // set current score cell to the score being calculated
                currentFrame.innerHTML = score;


                //break loop if reset is enabled
                if (reset) {
                    break;
                }


            }//end for j 
        }//end else
    }//end for i
    //go through eatch score cell and sum them to find the current overall score of the game.
    for (var i = 0; i < frameScores.length; i++) {
        let frameScore = parseInt(frameScores[i].innerHTML);
        if (Number.isInteger(frameScore)) {
            overallTotal += frameScore;
        }
    }
    //display total score on web page
    document.querySelector("#totalScore").innerHTML = overallTotal;
}//end frameScores()


//use the id that was sent to this screGame.php page using the "POST" method. sent as an input for the getGameScoreSheet.php call
//set game info using the returned gameInfo object.
function setGameInfo() {
    id = document.querySelector("#theGameID").value;
    let url = "api/getGameScoreSheetInfo.php";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0) {
                alert("Unable to access Games!");
            } else {
                let arrayGames = JSON.parse(resp);
                let team = document.querySelector("#teamName");
                let gameNumber = document.querySelector("#game");
                let round = document.querySelector("#round");
                team.innerHTML = "<u>" + arrayGames[0]["teamName"] + "</u>";
                round.innerHTML = arrayGames[0]["roundID"];
                gameNumber.innerHTML = arrayGames[0]["gameNumber"];

            }
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send(id);


}//end setGameInfo()


//will make a updateGameScore.php call to update the game score, balls, and gameState.
function updateGame() {

    let ballString = "";

    for (var i = 0; i < balls.length; i++) {
        if (i == balls.length - 1) {
            ballString += balls[i].toString();
        } else {
            ballString += balls[i].toString() + " ";
        }
    }
//sends an object as php input for the call
    let obj = {gameID: id, balls: ballString, score: overallTotal};
    var url = "api/updateGameScore.php";
    var xmlhttp = new XMLHttpRequest();


    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var resp = xmlhttp.responseText;
            console.log(resp);

        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.send(JSON.stringify(obj));




}//end updateGame

