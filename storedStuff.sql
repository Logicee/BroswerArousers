use bowlingTournament
delimiter !
drop trigger if exists establishWinners!
CREATE TRIGGER `establishWinners` AFTER UPDATE ON `game` FOR EACH ROW BEGIN 
-- checks all games from the matchgroup updated to see if they're done
-- call procedure assign ranks
DECLARE round varchar(10);
DECLARE theGroup int;
DECLARE games int;
DECLARE doneGames int;
IF new.gameStateID = 'COMPLETE' THEN 
	SET round = (SELECT roundid FROM matchup WHERE matchID = old.matchID); 
	SET theGroup = (SELECT matchGroup FROM matchup WHERE matchID = old.matchID); 
    SET doneGames = (SELECT count(*) FROM game WHERE matchID in(SELECT matchID FROM matchup WHERE roundID = round AND matchgroup = theGroup) AND gamestateID = 'COMPLETE');
    SET games = (SELECT count(*) FROM game WHERE matchID in(SELECT matchID FROM matchup WHERE roundID = round AND matchgroup = theGroup));
	IF doneGames = games THEN
		CALL assignRanks(theGroup, round);
        CALL generatePayout(theGroup, round);
    END IF;    
END IF;
END!

drop procedure if exists generatePayout!
CREATE PROCEDURE generatePayout(in theGroup int, in round VARCHAR(10)) BEGIN
-- increment the earnings for winning teams
DECLARE prize int default 400;

IF round = 'QUAL' THEN
	CALL generatePayoutQual();
ELSE
	IF round = 'FINAL' THEN
		SET prize = 1600;
    END IF;
	
    UPDATE team SET earnings = earnings + prize
		WHERE teamid = (SELECT teamid FROM matchup 
		WHERE ranking = 1 AND roundid = round and matchgroup = theGroup);
    
END IF;
END!

drop procedure if exists generatePayoutQual!
CREATE PROCEDURE generatePayoutQual() BEGIN
-- establishes payouts for the winners of round 1
DECLARE V_id int;
DECLARE arrow cursor for SELECT teamid FROM matchup WHERE roundid = 'QUAL' AND ranking <= 16;
DECLARE EXIT HANDLER FOR NOT FOUND BEGIN END; 

OPEN arrow;
LOOP 
	FETCH NEXT FROM arrow into V_id;
	UPDATE team SET earnings = 400 WHERE teamid = V_id;
END LOOP;

END!

drop procedure if exists assignRanks!
CREATE PROCEDURE assignRanks(in theGroup int, in round varchar(10)) BEGIN
-- go through all matches of matchgroup
-- highest score is rank 1 next highest 2 etc
DECLARE done tinyint default 0;
DECLARE count int default 0;
DECLARE v_matchid int;
DECLARE arrow cursor for SELECT matchid 
FROM matchup 
WHERE matchGroup = theGroup AND roundid = round
ORDER BY score desc;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
open arrow;
do_stuff: LOOP
	FETCH NEXT FROM arrow INTO v_matchid;

	IF done = 1 THEN
		LEAVE do_stuff;
	END IF;

	SET count = count+1;
	UPDATE matchup SET ranking = count WHERE matchid = V_matchid;
END LOOP;
END!

drop trigger if exists updateScore!
CREATE TRIGGER updateScore AFTER UPDATE ON game FOR EACH ROW BEGIN
-- increment match score 
DECLARE id int;
SET id = old.matchid;

IF new.gamestateid = 'COMPLETE' THEN
	UPDATE matchup SET score = (SELECT sum(score) FROM game WHERE matchid = id)
		WHERE matchid = id;
END IF;

END!
