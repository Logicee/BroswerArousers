<?php
class dbConnect{
    
 public function connectToDB(){
            $bowlingDB = new PDO("mysql:host=localhost;dbname=bowlingtournament", "browser", "arouser");
            $bowlingDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

            return $bowlingDB;
            
    }
}
            
