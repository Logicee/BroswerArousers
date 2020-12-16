<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
$_SESSION["email"] = $_POST['email'];
$_SESSION["password"]=$_POST['pass'];
if(isset($_POST['Login']))
{  header('Location: adminLoggedIn.php');
}
if(isset($_POST['Create']))
{
    header('Location: adminCreate.php');
}