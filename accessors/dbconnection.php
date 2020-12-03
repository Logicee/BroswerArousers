<?php
class dbConnect{
    
 public function connectToDB(){
            $bowlingDB = new PDO("mysql:host=localhost;dbname=bowlingtournament", "pinkal", "pinkal");
            $bowlingDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

            return $bowlingDB;
            
    }
}
            
