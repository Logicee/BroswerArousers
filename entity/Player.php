<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
 * @author danie
 */
class Player {
    
    private $FName;
    private $LName;
    private $province;
    private $homeTown;
    private $ID;
    
    function __construct($FName, $LName, $province, $homeTown, $ID) {
        $this->FName = $FName;
        $this->LName = $LName;
        $this->province = $province;
        $this->homeTown = $homeTown;
        $this->ID = $ID;
    }
    
    function getFName() {
        return $this->FName;
    }

    function getLName() {
        return $this->LName;
    }

    function getProvince() {
        return $this->province;
    }

    function getHomeTown() {
        return $this->homeTown;
    }

    function getID() {
        return $this->ID;
    }


}
