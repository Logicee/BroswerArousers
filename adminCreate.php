<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
/*
echo $_SESSION['email'];
echo $_SESSION['password'];
echo"CREATE THIS USER";
Create a user with the contents (if they meet criteria) AND THEN FORWARD TO ADMIN INDEX. */
header('Location: adminIndex.php');
